<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Include the autoloader provided in the SDK
require_once APPPATH .'third_party/Zalo/autoload.php';

use Zalo\Zalo;
use Zalo\ZaloEndPoint;

Class Zalo_lib
{
    private $zalo;
    private $helper;

    public function __construct()
    {
        // Load config
        $this->load->config('config_zalo');

        if (!isset($this->zalo)) {
            $this->zalo = new Zalo([
                'app_id'     => $this->config->item('zalo_app_id'),
                'app_secret' => $this->config->item('zalo_app_secret'),
                'callback_url' => $this->config->item('zalo_login_redirect_url'),
            ]);
        }

        $this->helper = $this->zalo->getRedirectLoginHelper();

        if ($this->config->item('zalo_auth_on_load') === TRUE) {
            // Try and authenticate the user right away (get valid access token)
            $this->is_authenticated();
        }
    }

    public function object()
    {
        return $this->zalo;
    }

    public function is_authenticated()
    {
        $callBackUrl = $this->config->item('zalo_login_redirect_url');
        $oauthCode   = isset($_GET['code']) ? $_GET['code'] : "THIS NOT CALLBACK PAGE !!!"; // get oauthoauth code from url params
        $accessToken = $this->helper->getAccessToken($callBackUrl); // get access token
        if ($accessToken != null) {
            $expires = $accessToken->getExpiresAt(); // get expires time
            return $accessToken;
        }

        return false;
    }

    public function get_user($access_token = null, $params = ['fields' => 'id,name,birthday,gender,phone,picture'])
    {
        try {
            $response = $this->zalo->get(ZaloEndpoint::API_GRAPH_ME, $access_token, $params);
            return $response->getDecodedBody();
        } catch (\Zalo\Exceptions\ZaloResponseException $e) {
            return $this->logError($e->getCode(), $e->getMessage());
        } catch (\Zalo\Exceptions\ZaloSDKException $e) {
            return $this->logError($e->getCode(), $e->getMessage());
        }
    }

    public function login_url()
    {
        // Login type must be web, else return empty string
        if ($this->config->item('zalo_login_type') != 'web') {
            return '';
        }

        // Get login url
        return $this->helper->getLoginUrl($this->config->item('zalo_login_redirect_url'));
    }

    private function logError($code, $message)
    {
        log_message('error', '[ZALO PHP SDK] code: ' . $code.' | message: '.$message);
        return ['error' => $code, 'message' => $message];
    }

    /**
     * Enables the use of CI super-global without having to define an extra variable.
     *
     * @param $var
     *
     * @return mixed
     */
    public function __get($var)
    {
        return get_instance()->$var;
    }
}
