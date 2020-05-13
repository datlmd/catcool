<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends MY_Controller
{
    CONST FRONTEND_NAME = 'customers';

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

        prepend_script(js_url('js/customer/login', 'common'));

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
                if ($this->Customer->login($this->input->post('username'), $this->input->post('password'), $remember, true)) {
                    set_alert(lang('login_successful'), ALERT_SUCCESS);
                    redirect(self::MANAGE_URL);
                }

                $data['errors'] = empty($this->Member->errors()) ? lang('login_unsuccessful') : $this->Member->errors();
            }
        }

        if ($this->form_validation->error_array()) {
            $data['errors'] = $this->form_validation->error_array();
        }

        $data['image_captcha'] = print_captcha();

        theme_load('login', $data);
    }

    public function social_login()
    {
        //check login

        $auth_url  = '';
        $user_data = [];

        if (isset($_REQUEST) && !empty($_REQUEST['type'])) {
            switch ($this->input->post_get('type')) {
                case 'fb':
                    // Load facebook oauth library
                    $this->load->library('facebook');

                    // Authenticate user with facebook
                    $access_token = $this->facebook->is_authenticated();
                    if (!empty($access_token)) {
                        // Get user info from facebook
                        $fb_user   = $this->facebook->request('get', '/me?fields=id,name,first_name,last_name,email,link,gender,picture.type(large), birthday');
                        $user_data = [
                            'id'         => !empty($fb_user['id']) ? $fb_user['id'] : '',
                            'first_name' => !empty($fb_user['first_name']) ? $fb_user['first_name'] : '',
                            'last_name'  => !empty($fb_user['last_name']) ? $fb_user['last_name'] : '',
                            'email'      => !empty($fb_user['email']) ? $fb_user['email'] : '',
                            'phone'      => !empty($fb_user['phone']) ? $fb_user['phone'] : '',
                            'gender'     => !empty($fb_user['gender']) ? $fb_user['gender'] : '',
                            'image'      => !empty($fb_user['picture']['data']['url']) ? $fb_user['picture']['data']['url'] : '',
                        ];
                    } else {
                        $auth_url =  $this->facebook->login_url();
                    }

                    break;
                case 'gg':
                    // Load zalo oauth library
                    $this->load->library('google');
                    if(isset($_GET['code'])) {
                        // Authenticate user with google
                        if($this->google->get_authenticate($_GET['code'])) {

                            // Get user info from google
                            $gg_user = $this->google->get_user_info();
                            $user_data = [
                                'id'         => !empty($gg_user['id']) ? $gg_user['id'] : '',
                                'first_name' => !empty($gg_user['given_name']) ? $gg_user['given_name'] : '',
                                'last_name'  => !empty($gg_user['family_name']) ? $gg_user['family_name'] : '',
                                'email'      => !empty($gg_user['email']) ? $gg_user['email'] : '',
                                'phone'      => !empty($gg_user['phone']) ? $gg_user['phone'] : '',
                                'gender'     => !empty($gg_user['gender']) ? $gg_user['gender'] : '',
                                'image'      => !empty($gg_user['picture']) ? $gg_user['picture'] : '',
                            ];
                        } else {
                            $auth_url = $this->google->login_url();
                        }
                    } else {
                        $auth_url = $this->google->login_url();
                    }
                    break;
                case 'zalo':
                    // Load zalo oauth library
                    $this->load->library('zalo_lib');

                    // Authenticate user with zalo
                    $access_token = $this->zalo_lib->is_authenticated();
                    if (!empty($access_token)) {
                        $zalo_user = $this->zalo_lib->get_user($access_token);
                        $user_data = [
                            'id'         => !empty($zalo_user['id']) ? $zalo_user['id'] : '',
                            'first_name' => !empty($zalo_user['name']) ? $zalo_user['name'] : '',
                            'last_name'  => !empty($zalo_user['last_name']) ? $zalo_user['last_name'] : '',
                            'dob'        => !empty($zalo_user['birthday']) ? $zalo_user['birthday'] : '',
                            'email'      => !empty($zalo_user['email']) ? $zalo_user['email'] : '',
                            'phone'      => !empty($zalo_user['phone']) ? $zalo_user['phone'] : '',
                            'gender'     => !empty($zalo_user['gender']) ? $zalo_user['gender'] : '',
                            'image'      => !empty($zalo_user['picture']['data']['url']) ? $zalo_user['picture']['data']['url'] : '',
                        ];
                    } else {
                        $auth_url =  $this->zalo_lib->login_url();
                    }

                    break;
                case 'tt':
                    break;
                default:
                    break;
            }
        }

        if (empty($auth_url) && empty($user_data)) {
            json_output(['status' => 'ng', 'msg' => 'No result!']);
        }

        if (!empty($auth_url)) {
            json_output(['status' => 'ok', 'auth_url' => $auth_url]);
        }

        //check user $user_data


        if ($this->input->is_ajax_request()) {
            json_output(['status' => 'redirect', 'url' => get_last_url()]);
        }

        redirect(get_last_url('customers/login'));
    }
}
