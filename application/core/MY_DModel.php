<?php
/**
 * Contains common functionality for CRUD Operation
 *
 * @final My_Model
 * @category models
 * @author Md. Ali Ahsan Rana
 * @link http://codesamplez.com
 */
class My_DModel extends CI_Model {

    /**
     * @var \Doctrine\ORM\EntityManager $em
     */
    var $em;

    var $entity;

    /**
     *
     * @param int $id
     * @return DxUsers
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * Initialize with entity name and entity manager
     * @param type $entity
     * @param type $em
     */
    function init($entity, $em) {
        $this->entity = $entity;
        $this->em = $em;
    }

    /**
     * Tao entity tu db
     *
     * @param null table_class neu muon tao 1 entity
     * @throws bool
     */
    function generate_classes($table_class = null)
    {
        try {
            $this->em->getConfiguration()->setMetadataDriverImpl(new \Doctrine\ORM\Mapping\Driver\DatabaseDriver($this->em->getConnection()->getSchemaManager()));
            $platform = $this->em->getConnection()->getDatabasePlatform();
            $platform->registerDoctrineTypeMapping('enum', 'string');

            $cmf = new \Doctrine\ORM\Tools\DisconnectedClassMetadataFactory();
            $cmf->setEntityManager($this->em);

            $metadata = $cmf->getAllMetadata();
            if (empty($metadata)) {
                return false;
            }

            //neu tao entity tu 1 table
            if (!empty($table_class)) {
                foreach ($metadata as $key => $val) {
                    if ($val->name != $table_class) {
                        unset($metadata[$key]);
                    }
                }
            }

            $generator = new \Doctrine\ORM\Tools\EntityGenerator();
            $generator->setUpdateEntityIfExists(true);
            $generator->setGenerateStubMethods(true);
            $generator->setGenerateAnnotations(true);
            $generator->generate($metadata, APPPATH . "models/Entities");
        } catch (Exception $e) {
            log_message("error", $e->getMessage(), false);
            return false;
        }
    }

    /**
     * Retrieve a single record according to given identifer
     * @param type $id identifier of the record
     * @return type
     */
    function get($id)
    {
        try
        {
            $result = $this->em->find($this->entity,$id);
            return $result;
        }
        catch(Exception $err)
        {
            log_message("error", $err->getMessage(), false);
            return NULL;
        }
    }

    /**
     * Return list of recors according to given start index and length
     * @param type $start the start index number for the city list
     * @param type $length Determines how many records to fetch
     * @return type
     */
    function get_by_range($start=1,$length=10,$criteria = array(),$orderBy = NULL)
    {
        try
        {
            return $this->em->getRepository($this->entity)->findBy($criteria, $orderBy, $length, $start);
        }
        catch(Exception $err)
        {
            log_message("error", $err->getMessage(), false);
            return NULL;
        }
    }

    /**
     * Return the number of records
     * @return integer
     */
    function get_count()
    {
        try
        {
            $query = $this->em->createQueryBuilder()
                ->select("count(c)")
                ->from($this->entity, "c")
                ->getQuery();
            return $query->getSingleScalarResult();
        }
        catch(Exception $err)
        {
            log_message("error", $err->getMessage(), false);
            return 0;
        }
    }

    /**
     * Save an enitity(insert for new one)
     * @param type $entity Docrine Entity object
     * @return boolean
     */
    function save($entity)
    {
        try
        {
            if (is_array($entity)){
                $entity = (object) $entity;
            }

            $this->em->persist($entity);
            $this->em->flush();
            return $entity->id();
        }
        catch(Exception $err)
        {
            log_message("error", $err->getMessage(), false);
            return FALSE;
        }
    }

    /**
     * Delete an Entity according to given (list of) id(s)
     * @param type $ids array/single
     * @return boolean
     */
    function delete($ids)
    {
        try
        {
            if(!is_array($ids))
            {
                $ids = array($ids);
            }
            foreach($ids as $id)
            {
                $entity = $this->em->getPartialReference($this->entity, $id);
                $this->em->remove($entity);
            }
            $this->em->flush();
            return TRUE;
        }
        catch(Exception $err)
        {
            log_message("error", $err->getMessage(), false);
            return FALSE;
        }
    }

    function get_array($query, $parameters = null, $limit = 100, $offset = 0, $is_total = false)
    {
        try {
            if (empty($query)) {
                return false;
            }

            $query = str_replace("__TABLE_NAME__", $this->entity, $query);
            if (empty($parameters)) {
                $query = $this->em->createQuery($query);
            } else {
                if (isset($parameters['language'])) {
                    $parameters['language'] = '%' . $parameters['language'] . '%';
                }

                $query = $this->em->createQuery($query)->setParameters($parameters);
            }

            $total_records = 0;
            if ($is_total) {
                $total_records = count($query->getArrayResult());
            }

            if (!empty($limit)) {
                if (!isset($offset)) {
                    $offset = 0;
                }
                $query->setFirstResult($offset)->setMaxResults($limit);
            }

            $result = $query->getArrayResult();
            if (empty($result)) {
                return false;
            }

            if ($is_total) {
                return [$result, $total_records];
            }

            return $result;

        } catch(Exception $err) {
            log_message("error", $err->getMessage(), false);
            return FALSE;
        }
    }

    function get_first($query, $parameters = null)
    {
        try {
            if (empty($query)) {
                return false;
            }

            $query = str_replace("__TABLE_NAME__", $this->entity, $query);
            if (empty($parameters)) {
                $query = $this->em->createQuery($query);
            } else {
                if (isset($parameters['language'])) {
                    $parameters['language'] = '%' . $parameters['language'] . '%';
                }
                $query = $this->em->createQuery($query)->setParameters($parameters);
            }

            $query->setMaxResults(1);

            $result = $query->getArrayResult();
            if (empty($result)) {
                return false;
            }

            return $result[0];
        } catch(Exception $err) {
            log_message("error", $err->getMessage(), false);
            return FALSE;
        }
    }

    function execute($query, $parameters = null)
    {
        try {
            if (empty($query) || empty($parameters)) {
                return false;
            }

            $query = str_replace("__TABLE_NAME__", $this->entity, $query);

            $result = $this->em->createQuery($query)->setParameters($parameters);
            $result->execute();

            return true;
        } catch(Exception $err) {
            log_message("error", $err->getMessage(), false);
            return FALSE;
        }
    }
}