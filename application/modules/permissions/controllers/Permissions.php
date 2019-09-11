<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Permissions extends Admin_Controller
{
    public $config_form = [];
    public $data        = [];

    CONST MANAGE_NAME       = 'permissions';
    CONST MANAGE_URL        = self::MANAGE_NAME;
    CONST MANAGE_PAGE_LIMIT = PAGINATION_DEFAULF_LIMIT;

    public function __construct()
    {
        parent::__construct();

        $this->lang->load('permissions_manage', $this->_site_lang);

        //load model manage
        $this->load->model("permissions/PermissionManager", 'Manager');

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_name', self::MANAGE_NAME);

        //add breadcrumb
        $this->breadcrumb->add(lang('catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('list_heading'), base_url(self::MANAGE_URL));

        //check validation
        $this->config_form = [];
    }

    public function index()
    {

    }

    public function not_allowed()
    {
        $this->data['title'] = $this->lang->line('not_permission_heading');


        $this->theme->load('not_allowed', $this->data);

    }
}
