<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

include_once FCPATH . 'vendor/autoload.php';

use Doctrine\Common\ClassLoader;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\DBAL\Event\Listeners\MysqlSessionInit;
use Gedmo\Timestampable\TimestampableListener;
use Gedmo\Sluggable\SluggableListener;
use Gedmo\Tree\TreeListener;
use Doctrine\Common\EventManager;

/**
 * Doctrine bootstrap library for CodeIgniter
 *
 * @author	Joseph Wynn <joseph@wildlyinaccurate.com>
 * @link	http://wildlyinaccurate.com/integrating-doctrine-2-with-codeigniter-2
 */
class Doctrine
{
    public $em;
    public $tool = null;
    public function __construct()
    {
        // Load the database configuration from CodeIgniter
        require APPPATH . 'config/database.php';
        $connection_options = array(
            'driver'		=> 'pdo_mysql',
            'user'			=> $db['default']['username'],
            'password'		=> $db['default']['password'],
            'host'			=> $db['default']['hostname'],
            'dbname'		=> $db['default']['database'],
            'charset'		=> $db['default']['char_set'],
            'driverOptions'	=> array(
                'charset'	=> $db['default']['char_set'],
            ),
        );
        // With this configuration, your model files need to be in application/models/Entity
        // e.g. Creating a new Entity\User loads the class from application/models/Entity/User.php
        $models_namespace = 'Entity';
        $models_path = APPPATH . 'models';
        $proxies_dir = APPPATH . 'models/Proxies';
        $metadata_paths = array(APPPATH . 'models/Entity');

        // Set up models loading
        $loader = new ClassLoader('models', APPPATH);
        $loader->register();
        foreach (glob(APPPATH.'modules/*', GLOB_ONLYDIR) as $m) {
            $module = str_replace(APPPATH.'modules/', '', $m);
            $loader = new ClassLoader($module, APPPATH.'modules');
            $loader->register();
        }
        // Set up Gedmo
        $classLoader = new ClassLoader('Gedmo', APPPATH.'third_party');
        $classLoader->register();
        $evm = new EventManager;
        // timestampable
        $evm->addEventSubscriber(new TimestampableListener);
        // sluggable
        $evm->addEventSubscriber(new SluggableListener);
        // tree
        $evm->addEventSubscriber(new TreeListener);

        // Set $dev_mode to TRUE to disable caching while you develop
        $dev_mode = false;
        // If you want to use a different metadata driver, change createAnnotationMetadataConfiguration
        // to createXMLMetadataConfiguration or createYAMLMetadataConfiguration.
        $config = Setup::createAnnotationMetadataConfiguration($metadata_paths, $dev_mode, $proxies_dir);
        $this->em = EntityManager::create($connection_options, $config);
        $loader = new ClassLoader($models_namespace, $models_path);
        $loader->register();

        // Force UTF-8
        $this->em->getEventManager()->addEventSubscriber(
            new MysqlSessionInit('utf8', 'utf8_unicode_ci'));

        // Schema Tool
        $this->tool = new SchemaTool($this->em);
    }
}