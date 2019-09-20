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

        //load third_party develbar
        if (!empty(config_item('enable_develbar')) && config_item('enable_develbar') == TRUE) {
            $this->load->add_package_path(APPPATH . 'third_party/DevelBar');
        }
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

    public function is_super_admin()
    {
        $super_admin = $this->session->userdata('super_admin');
        if (!empty($super_admin) && $super_admin === TRUE) {
            return TRUE;
        }

        return FALSE;
    }

    public function get_user_id()
    {
        $user_id = $this->session->userdata('user_id');
        if (!empty($user_id)) {
            return $user_id;
        }

        return NULL;
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

        $this->lang->load('general_manage', $this->_site_lang);

//        $module     = $this->uri->segment(1,'none');
//        $controller = $this->uri->segment(2,'none');
//        $method     = $this->uri->segment(3,'none');

        //get menu admin
        $this->load->model("menus/Menu_manager", 'Menu');
        $menu_admin = $this->Menu->get_menu_active(['is_admin' => STATUS_ON, 'language' => $this->_site_lang]);
        $menu_admin = format_tree($menu_admin);

        $this->smarty->assign('menu_admin', $menu_admin);

    }

    /**
     * get info paging
     *
     * @param $manage_url
     * @param $total
     * @param $limit
     * @param $offset
     * @return array
     */
    public function get_paging_admin($manage_url, $total, $limit, $offset)
    {
        if (empty($total) || !is_numeric($total)) {
            return [];
        }

        if (empty($manage_url)) {
            $manage_url = current_url();
        }

        if (empty(config_item('pagination_admin'))) {
            $this->config->load('pagination_admin', TRUE);
        }
        //create pagination
        $settings               = config_item('pagination_admin');
        $settings['base_url']   = $manage_url;
        $settings['total_rows'] = $total;
        $settings['per_page']   = $limit;

        // use the settings to initialize the library
        $this->pagination->initialize($settings);

        // build paging links
        $paging['pagination_links'] = $this->pagination->create_links();

        $page_to   = ($total < $limit) ? $total : ($offset * $limit) + $limit;
        $page_from = ($offset * $limit) + 1;

        $paging['pagination_title'] = sprintf(lang('total_records'), $page_from, $page_to, $total);

        return $paging;
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
