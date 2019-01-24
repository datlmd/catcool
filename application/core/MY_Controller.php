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
    /**
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct();
        // Put your user rank check logic here:
        // if ( ! $this->current_user->admin)
        // {
        // 	redirect('','refresh');
        // 	exit;
        // }
    }
}
/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */
