<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Frontend extends MY_Controller
{
    public $config_form = [];
    public $data        = [];

    CONST FRONTEND_NAME = 'frontend';

    public function __construct()
    {
        parent::__construct();

        $this->lang->load('frontend', $this->_site_lang);


        $this->theme->theme('default')
            ->title('Admin Panel')
            ->add_partial('header')
            ->add_partial('footer');
            //->add_partial('sidebar');


        //add breadcrumb
        $this->breadcrumb->add(lang('frontend_heading'), base_url());
    }

    public function index()
    {
        $this->data['title'] = lang('frontend_heading');


        $this->theme->load('index', $this->data);
    }

    public function about()
    {



        $this->theme->load('about', $this->data);
    }

    public function contact()
    {
        $this->theme->add_js('assets/js/contact-map');


        $this->theme->load('contact', $this->data);
    }
}
