<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Catcool extends Admin_Controller
{
    public $config_form = [];
    public $data        = [];

    CONST MANAGE_ROOT = 'catcool';
    CONST MANAGE_URL  = 'catcool/';

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
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

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
    
    public function send_mail() {
        // load thư viên
        //phpinfo();
        $this->load->library('email');
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = "ssl://smtp.googlemail.com";
        $config['smtp_user'] = 'lmd.dat@gmail.com';
        $config['smtp_pass'] = 'tovyyqgibmnruaes';
        $config['smtp_port'] = 465;

        $config['charset']    = 'utf-8';
        $config['newline']    = "\r\n";
        $config['mailtype'] = 'text';
        $config['validation'] = TRUE;

//        $config = Array(
//            'protocol' => 'smtp',
//            'smtp_host' => 'ssl://smtp.googlemail.com',
//            'smtp_port' => 465,
//            'smtp_user' => 'lmd.dat@gmail.com',
//            'smtp_pass' => 'tovyyqgibmnruaes',
//            'mailtype'  => 'html',
//            'charset'   => 'utf-8'
//        );

        $this->email->initialize($config);
        $this->email->set_newline("\r\n");

        $this->email->from('lmd.dat@gmail.com', 'Dat Le');
        $list = array('legiaminh8602@yahoo.com');
        $this->email->to($list);
        //$this->email->reply_to('my-email@gmail.com', 'Explendid Videos');
        $this->email->subject('This is an email test');
        $this->email->message('It is working. Great!');
        //$this->email->send();
        
        if(!$this->email->send()){
            echo $this->email->print_debugger();
            echo 'Gửi email thất bại'; //tạo thông báo gửi email thất bại
        
        }else{
        
            echo 'Gửi email thành công';
        
        }
        die;
    }
}
