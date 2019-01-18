<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . "models/doctrine/entities/User.php");
//use \User;
class Welcome extends MY_Controller {

    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct();

    }

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		//$this->load->view('welcome_message');
		$data['title'] = 'hello world';

		try {
            $this->load->model("welcome/UserManager");
            $data_user['user_name'] = 'dat le';
            $data_user['email'] = 'Email';
            //$this->UserManager->save_user($ta_user);
            echo "<pre>";
            print_r($this->UserManager->save_user($data_user));

            $contact = new User();
            $contact->setUsername('sfdsf');
            $contact->setEmail('email');

            try {
                //save to database
                $this->em->persist($contact);
                $this->em->flush();
            }
            catch(Exception $err){

                die($err->getMessage());
            }
//
//// When you have set up your database, you can persist these entities:
//             $em = $this->doctrine->em;
//             $em->persist($user);
//             $em->flush();
        } catch (Exception $e) {
		    echo $e->getMessage();
        }

        $this->parser->parse("hello_catcool", $data);
	}
}
