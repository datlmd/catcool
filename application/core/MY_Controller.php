<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
/**
 * MY_Controller
 *
 * @category MY_Controller
 * @package  CodeIgniter
 * @author   Tariqul Islam <tareq@webkutir.net>
 * @license  http://directory.fsf.org/wiki/License:ReciprocalPLv1.3 Reciprocal Public License v1.3
 * @link     http://webkutir.net
 */
class MY_Controller extends MX_Controller
{
    public $em;
    /**
     * Constructor of MY Controller
     */
    function __construct()
    {
        parent::__construct();

        //set time zone
        date_default_timezone_set('Asia/Saigon');

        $this->em = $this->doctrine->em;
        $this->smarty->assign('currenturl', $this->uri->uri_string());
    }
}

// ------------------------------------------------------------------------
/**
 * Ajax_Controller
 *
 * @package 	CodeIgniter
 * @category 	Core Extension
 * @author 	Kader Bouyakoub <bkader@mail.com>
 * @link 	https://github.com/bkader
 */
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

/**
 * API Controller
 *
 * @package     CodeIgniter-Extended
 * @author      Kader Bouyakoub
 * @link        @bkader <github>
 * @link        @KaderBouyakoub <twitter>
 */
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
 * @package 	CodeIgniter
 * @category 	Core Extension
 * @author 	Kader Bouyakoub <bkader_at_mail_dot_com>
 * @link 	https://github.com/bkader
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
 * @package 	CodeIgniter
 * @category 	Core Extension
 * @author 	Kader Bouyakoub <bkader_at_mail_dot_com>
 * @link 	https://github.com/bkader
 */
class Admin_Controller extends User_Controller
{
    protected $_site_lang;

    public function __construct()
    {
        parent::__construct();

        // check language
        if(!empty($_GET['lang'])) {
            set_lang($_GET['lang']);
            redirect(base_url(uri_string()));
        }

        $this->_site_lang = get_lang();

        $this->load->database();
        $this->load->library(['ion_auth', 'breadcrumb', 'pagination']);

        $this->lang->load('auth', $this->_site_lang);

        // load config file
        $this->config->load('pagination', TRUE);

        $this->lang->load('general_manage', $this->_site_lang);

        $controller = $this->uri->segment(2,'none');
        $method     = $this->uri->segment(3,'none');

        //get param current
        if (!empty($_SERVER['QUERY_STRING'])) {
            $this->smarty->assign('params_current', '?' . $_SERVER['QUERY_STRING']);
        }

        if ($controller != 'auth' && $method != 'login') {
            if (!$this->ion_auth->logged_in()) {
                //set redirect back
                $this->session->set_userdata('redirect_back', current_url());

                // redirect them to the login page
                redirect('user/auth/login', 'refresh');
            } else if (!$this->ion_auth->is_admin()) {
                // remove this elseif if you want to enable this for non-admins
                // redirect them to the home page because they must be an administrator to view this
                show_error('You must be an administrator to view this page.');
            }
        }

        //get menu admin
        $this->load->model("menus/MenuManager", 'Menu');
        $menu_admin = $this->Menu->get_menu_active(['context' => 'admin', 'language' => $this->_site_lang]);
        $menu_admin = format_tree($menu_admin);

        $this->smarty->assign('menu_admin', $menu_admin);
    }
}
/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */
