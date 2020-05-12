<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Members extends MY_Controller
{
    CONST FRONTEND_NAME = 'members';

    public function __construct()
    {
        parent::__construct();

        //set theme
        $this->theme->theme(config_item('theme_frontend'))
            ->add_partial('header_top')
            ->add_partial('header_bottom')
            ->add_partial('breadcumb')
            ->add_partial('footer');

        $this->lang->load('frontend', $this->_site_lang);


        //add breadcrumb
        $this->breadcrumb->add(lang('frontend_heading'), base_url());
    }

    public function index()
    {
        $data['title'] = lang('frontend_heading');


        theme_load('index', $data);
    }

    public function login()
    {
        $this->theme->title(lang('login_heading'));


        // validate form input
        $this->form_validation->set_rules('username', str_replace(':', '', lang('text_username')), 'required');
        $this->form_validation->set_rules('password', str_replace(':', '', lang('text_password')), 'required');
        $this->form_validation->set_rules('captcha', str_replace(':', '', lang('text_captcha')), 'required');

        if (isset($_POST) && !empty($_POST) && $this->form_validation->run() === TRUE)
        {
            if(!check_captcha($this->input->post('captcha'))) {
                $data['errors'] = lang('error_captcha');
            } else {
                $remember = (bool)$this->input->post('remember');
                if ($this->Member->login($this->input->post('username'), $this->input->post('password'), $remember, true)) {
                    set_alert(lang('login_successful'), ALERT_SUCCESS);
                    redirect(self::MANAGE_URL);
                }

                $data['errors'] = empty($this->Member->errors()) ? lang('login_unsuccessful') : $this->Member->errors();
            }
        }

        if ($this->form_validation->error_array()) {
            $data['errors'] = $this->form_validation->error_array();
        }

        $userData = array();

        // Load facebook oauth library
        $this->load->library('facebook');

        // Authenticate user with facebook
        $access_token = $this->facebook->is_authenticated();
        if($access_token){
            // Get user info from facebook
            $fbUser = $this->facebook->request('get', '/me?fields=id,name,first_name,last_name,email,link,gender,picture.type(large), birthday');

            // Preparing data for database insertion
            $userData['oauth_provider'] = 'facebook';
            $userData['oauth_uid']    = !empty($fbUser['id'])?$fbUser['id']:'';;
            $userData['first_name']    = !empty($fbUser['first_name'])?$fbUser['first_name']:'';
            $userData['last_name']    = !empty($fbUser['last_name'])?$fbUser['last_name']:'';
            $userData['email']        = !empty($fbUser['email'])?$fbUser['email']:'';
            $userData['phone']        = !empty($fbUser['phone'])?$fbUser['phone']:'';
            $userData['gender']        = !empty($fbUser['gender'])?$fbUser['gender']:'';
            $userData['picture']    = !empty($fbUser['picture']['data']['url'])?$fbUser['picture']['data']['url']:'';
            $userData['link']        = !empty($fbUser['link'])?$fbUser['link']:'https://www.facebook.com/';

            // Insert or update user data to the database
            //$userID = $this->user->checkUser($userData);

            // Check user data insert or update status
            $data['user_data'] = $userData;



            // Store the user profile info into session
            $this->session->set_userdata('userData', $userData);

            if(!empty($userID)){
                $data['userData'] = $userData;

                // Store the user profile info into session
                $this->session->set_userdata('userData', $userData);
            }else{
                $data['userData'] = array();
            }

            // Facebook logout URL
            $data['logout_url'] = $this->facebook->logout_url();
        } else {
            // Facebook authentication url
            $data['auth_url'] =  $this->facebook->login_url();
        }

        // Load zalo oauth library
        $this->load->library('zalo_lib');
        // Authenticate user with facebook
        $zalo_access_token = $this->zalo_lib->is_authenticated();
        if($zalo_access_token) {
            $user_zalo = $this->zalo_lib->get_user($zalo_access_token);

            $data['user_zalo'] = $user_zalo;
            // Facebook logout URL
            //$data['zalo_logout_url'] = $this->zalo_lib->logout_url();
        } else {
            $data['zalo_auth_url'] =  $this->zalo_lib->login_url();
        }

        $data['image_captcha'] = print_captcha();

        theme_load('login', $data);
    }
}
