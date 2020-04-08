<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Admin_Controller
{
    public $config_form = [];
    public $data        = [];

    CONST MANAGE_ROOT       = 'users/auth';
    CONST MANAGE_URL        = 'users/auth';

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

        $this->lang->load('users_manage', $this->_site_lang);

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('heading_title'), base_url(self::MANAGE_URL));
    }

    public function index()
    {
        //tat ca xu ly auth

        return null;
    }

    public function recaptcha()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        json_output(['captcha' => print_re_captcha()]);
    }
}
