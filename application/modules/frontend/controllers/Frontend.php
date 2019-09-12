<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Frontend extends MY_Controller
{
    public $config_form = [];
    public $data        = [];

    CONST FRONTEND_NAME = 'frontend';

    public function __construct()
    {
        parent::__construct();

        //set theme
        $this->theme->theme(config_item('theme_frontend'))
            ->add_partial('header')
            ->add_partial('footer');

        $this->theme->title(config_item('site_name'))
            ->description(config_item('site_description'))
            ->keywords(config_item('site_keywords'));

        $this->lang->load('frontend', $this->_site_lang);


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
