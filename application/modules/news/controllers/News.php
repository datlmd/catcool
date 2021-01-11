<?php defined('BASEPATH') OR exit('No direct script access allowed');

class News extends MY_Controller
{
    CONST FRONTEND_NAME = 'news';

    public function __construct()
    {
        parent::__construct();

        //set theme
        $this->theme->theme(config_item('theme_frontend'))
            ->add_partial('header_top')
            ->add_partial('header_bottom')
            //->add_partial('breadcumb')
            ->add_partial('footer_bottom');

        $this->lang->load('news', $this->_site_lang);

        //load model manage
        $this->load->model("news/News_model", 'News_model');

    }

    public function index()
    {
        set_meta_seo();

        $data = [];

        theme_load('index', $data);
    }

    public function category()
    {
        $this->theme->add_partial('content_right');
        $data = [];

        theme_load('category', $data);
    }

    public function detail()
    {
        $this->theme->add_partial('content_right');

        $data = [];

        theme_load('detail', $data);
    }
}
