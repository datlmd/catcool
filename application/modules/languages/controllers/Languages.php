<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Languages extends Admin_Controller
{
    public $config_form = [];
    public $data        = [];

    public function __construct()
    {
        parent::__construct();

        //set theme
    }

    public function switch_lang($code)
    {
        set_lang($code);

        $this->cache->delete('get_menu_cc');

        redirect(previous_url());
    }
}
