<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Include the autoloader provided in the SDK
require_once APPPATH .'third_party/Google_api_php_client/vendor/autoload.php';

class Google {

    public function __construct()
    {
        $this->config->load('config_social');

        $this->client = new Google_Client();
        $this->client->setApplicationName($this->config->item('application_name', 'google'));
        $this->client->setClientId($this->config->item('client_id', 'google'));
        $this->client->setClientSecret($this->config->item('client_secret', 'google'));
        $this->client->setRedirectUri($this->config->item('redirect_uri', 'google'));
        $this->client->setDeveloperKey($this->config->item('api_key', 'google'));
        $this->client->setScopes($this->config->item('scopes', 'google'));
        $this->client->setAccessType('online');
        $this->client->setApprovalPrompt('auto');

        $this->oauth2 = new Google_Service_Oauth2($this->client);
    }

    public function login_url() {
        return $this->client->createAuthUrl();
    }

    public function get_authenticate($code) {
        if (empty($code)) {
            return false;
        }

        return $this->client->authenticate($code);
    }

    public function get_access_token() {
        return $this->client->getAccessToken();
    }

    public function set_access_token() {
        return $this->client->setAccessToken();
    }

    /**
     * Reset OAuth access token
     *
     * @return bool
     */
    public function revoke_token() {
        return $this->client->revokeToken();
    }

    public function get_user_info() {
        return $this->oauth2->userinfo->get();
    }

    public function __get($var)
    {
        return get_instance()->$var;
    }
}
