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
        $CI = & get_instance();

        if (empty(config_item('multi_language')) && !is_array(config_item('multi_language'))) {
            return false;
        }

        $list_language = config_item('multi_language');
        foreach ($list_language as $key => $value) {
            $list_language[$key] = lang($key);
        }

        return $list_language;
    }
}

if (!function_exists('is_show_select_language'))
{
    function is_show_select_language()
    {
        if (empty(config_item('is_show_select_language'))) {
            return false;
        }

        return true;
    }
}