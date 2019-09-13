<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Controller extends MX_Controller
{
    protected $_site_lang;
    /**
     * Constructor of MY Controller
     */
    function __construct()
    {
        parent::__construct();

        // check language
        if(!empty($_GET['lang'])) {
            set_lang($_GET['lang']);
            redirect(base_url(uri_string()));
        }

        $this->_site_lang = get_lang();

        $this->load->library(['breadcrumb', 'pagination']);

        //set time zone
        date_default_timezone_set('Asia/Saigon');

        $this->smarty->assign('currenturl', $this->uri->uri_string());
    }
}

class Ajax_Controller extends MY_Controller
{
    /**
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct();
        // Make sure it's always an ajax request.
        //Events::trigger('before_ajax_controller');
        if (!$this->input->is_ajax_request())
        {
            // Do anyting you want!
            show_404();
        }

        //$this->load->library('response');
        //Events::trigger('after_ajax_controller');
        // Below here are what you need to load.
    }
}

class API_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
}

// ------------------------------------------------------------------------
/**
 * User_Controller
 *
 * All controllers that require a logged-in user should extend this class.
 *
 */
class User_Controller extends MY_Controller
{
    /**
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct();
        // Put your user check logic here:
        // if ( ! $this->auth->online())
        // {
        // 	redirect('login','refresh');
        // 	exit;
        // }
    }
}
// ------------------------------------------------------------------------
/**
 * Admin_Controller
 *
 * Controllers that require a logged-in admin user should extend this class.
 *
 */
class Admin_Controller extends User_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->library(['acl']);

        //$this->lang->load('auth', $this->_site_lang);

        // load config file
        $this->config->load('pagination', TRUE);

        $this->lang->load('general_manage', $this->_site_lang);

//        $module     = $this->uri->segment(1,'none');
//        $controller = $this->uri->segment(2,'none');
//        $method     = $this->uri->segment(3,'none');

        //get param current
        if (!empty($_SERVER['QUERY_STRING'])) {
            $this->smarty->assign('params_current', '?' . $_SERVER['QUERY_STRING']);
        }

//        if ($method != 'login') {
//            if (!$this->ion_auth->logged_in()) {
//                //set redirect back
//                $this->session->set_userdata('redirect_back', current_url());
//
//                // redirect them to the login page
//                redirect('users/manage/login');
//            } else if (!$this->ion_auth->is_admin()) {
//                // remove this elseif if you want to enable this for non-admins
//                // redirect them to the home page because they must be an administrator to view this
//                show_error('You must be an administrator to view this page.');
//            }
//        }

        //get menu admin
        $this->load->model("menus/MenuManager", 'Menu');
        $menu_admin = $this->Menu->get_menu_active(['is_admin' => STATUS_ON, 'language' => $this->_site_lang]);
        $menu_admin = format_tree($menu_admin);

        $this->smarty->assign('menu_admin', $menu_admin);

    }
}

class Ajax_Admin_Controller extends User_Controller
{
    /**
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct();

        // Make sure it's always an ajax request.
        //Events::trigger('before_ajax_controller');
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $this->lang->load('general_manage', $this->_site_lang);

        $this->load->database();
        $this->load->library(['acl']);

        //$this->load->library('response');
        //Events::trigger('after_ajax_controller');
        // Below here are what you need to load.
    }
}
