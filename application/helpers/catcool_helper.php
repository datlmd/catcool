<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('get_lang'))
{
    function get_lang()
    {
        $CI = & get_instance();

        $language = $CI->session->userdata('site_lang');
        if(!empty($language)) {
            return $language;
        }

        return config_item('language');
    }
}

if (!function_exists('set_lang'))
{
    function set_lang($lang)
    {
        $CI = & get_instance();

        if (empty($lang) || !is_multi_lang() || !array_key_exists($lang, config_item('multi_language'))) {
            $CI->session->set_userdata('site_lang', config_item('language'));
        } else {
            $CI->session->set_userdata('site_lang', $lang);
        }

        return true;
    }
}

if (!function_exists('is_multi_lang'))
{
    function is_multi_lang()
    {
        if (!empty(config_item('is_multi_language'))) {
            return config_item('is_multi_language');
        }

        return false;
    }
}

if (!function_exists('get_multi_lang'))
{
    function get_multi_lang()
    {
        if (!empty(config_item('multi_language')) && is_array(config_item('multi_language'))) {
            return config_item('multi_language');
        }

        return false;
    }
}

if (!function_exists('get_csrf_nonce'))
{
    /**
     * @return array A CSRF key-value pair
     */
    function get_csrf_nonce()
    {
        $CI = & get_instance();

        $CI->load->helper('string');

        $key   = random_string('alnum', 8);
        $value = random_string('alnum', 20);

        $CI->session->set_flashdata('csrfkey', $key);
        $CI->session->set_flashdata('csrfvalue', $value);

        return [$key => $value];
    }
}

if (!function_exists('valid_csrf_nonce'))
{
    /**
     * @return bool Whether the posted CSRF token matches
     */
    function valid_csrf_nonce()
    {
        $CI = & get_instance();

        $csrfkey = $CI->input->post($CI->session->flashdata('csrfkey'));
        if ($csrfkey && $csrfkey === $CI->session->flashdata('csrfvalue')) {
            return TRUE;
        }

        return FALSE;
    }
}