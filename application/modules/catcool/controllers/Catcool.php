<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Catcool extends Admin_Controller
{
    public $config_form = [];
    public $data        = [];

    CONST MANAGE_NAME       = 'catcool';
    CONST MANAGE_URL        = self::MANAGE_NAME . '/';

    public function __construct()
    {
        parent::__construct();

        //set theme
        $this->theme->theme(config_item('theme_admin'))
            ->add_partial('header')
            ->add_partial('footer')
            ->add_partial('sidebar');

        $this->theme->title(config_item('site_name'))
            ->description(config_item('site_description'))
            ->keywords(config_item('site_keywords'));

        $this->lang->load('builder', $this->_site_lang);

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_name', self::MANAGE_NAME);

        //add breadcrumb
        $this->breadcrumb->add(lang('catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
    }

    public function index()
    {
        $this->data          = [];
        $this->data['title'] = lang('module_heading');


        theme_load('dashboard', $this->data);
    }

    public function help()
    {
        $this->data          = [];
        $this->data['title'] = lang('module_heading');


        theme_load('help', $this->data);
    }
}
