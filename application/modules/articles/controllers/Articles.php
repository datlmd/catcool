<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Articles extends MY_Controller
{
    CONST FRONTEND_NAME = 'articles';

    public function __construct()
    {
        parent::__construct();

        //set theme
        $this->theme->theme(config_item('theme_frontend'))
            ->add_partial('header_top')
            ->add_partial('header_bottom')
            ->add_partial('breadcumb')
            ->add_partial('footer_bottom');

        $this->lang->load('articles', $this->_site_lang);

        //load model manage
        $this->load->model("articles/Article", 'Article');
        $this->load->model("articles/Article_description", 'Article_description');

        //add breadcrumb
        $this->breadcrumb->openTag(config_item('breadcrumb_open'));
        $this->breadcrumb->closeTag(config_item('breadcrumb_close'));
        $this->breadcrumb->itemOpenTag(config_item('breadcrumb_item_open'));
        $this->breadcrumb->itemCloseTage(config_item('breadcrumb_item_close'));

        $this->breadcrumb->add(lang('frontend_heading'), base_url());
    }

    public function index()
    {
        $data['title'] = lang('frontend_heading');

        $limit             = empty($this->input->get('filter_limit', true)) ? 10 : $this->input->get('filter_limit', true);
        $start_index       = (isset($_GET['page']) && is_numeric($_GET['page'])) ? ($_GET['page'] - 1) * $limit : 0;
        list($list, $tota) = $this->Article->get_list_published([], $limit, $start_index);

        $data = [
            'list'   => $list,
            'paging' => $this->get_paging(base_url(), 50, $limit, $this->input->get('page')),
        ];

        theme_load('list', $data);
    }
}
