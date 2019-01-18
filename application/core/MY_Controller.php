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
