<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Permissions extends Admin_Controller
{
    public $config_form = [];
    public $data        = [];

    CONST MANAGE_ROOT       = 'permissions';
    CONST MANAGE_URL        = 'permissions';

    public function __construct()
    {
        parent::__construct();

        //set theme
        $this->theme->theme(config_item('theme_admin'))
            ->add_partial('header')
            ->add_partial('footer')
            ->add_partial('sidebar');

        $this->lang->load('permissions_manage', $this->_site_lang);

        //load model manage
        $this->load->model("permissions/Permission", 'Permission');

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('heading_title'), base_url(self::MANAGE_URL));

        //check validation
        $this->config_form = [];
    }

    public function index()
    {

    }

    public function not_allowed()
    {
        $this->data['title'] = $this->lang->line('not_permission_heading');

        theme_load('not_allowed', $this->data);
    }
}
