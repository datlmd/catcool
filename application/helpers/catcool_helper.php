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

if (!function_exists('create_token'))
{
    /**
     * @return array A CSRF key-value pair
     */
    function create_token()
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

if (!function_exists('valid_token'))
{
    /**
     * @return bool Whether the posted CSRF token matches
     */
    function valid_token()
    {
        $CI = & get_instance();

        $csrfkey = $CI->input->post($CI->session->flashdata('csrfkey'));
        if ($csrfkey && $csrfkey == $CI->session->flashdata('csrfvalue')) {
            return TRUE;
        }

        return FALSE;
    }
}

if (!function_exists('format_tree')) {
    function format_tree($list_tree, $parent_id = 0)
    {
        if (empty($list_tree)) {
            return false;
        }

        $tree_array = [];
        foreach ($list_tree as $element) {
            if ($element['parent_id'] == $parent_id) {
                $subs = format_tree($list_tree, $element['id']);
                if (!empty($subs)) {
                    $element['subs'] = $subs;
                }
                $tree_array[$element['id']] = $element;
            }
        }

        return $tree_array;
    }
}

if (!function_exists('format_tree_output')) {
    function format_tree_output($list_tree, $parent_id = 0, $sub_mark = null)
    {
        if (empty($list_tree)) {
            return false;
        }

        if (empty($sub_mark)) {
            $sub_mark = '-';
        }

        if ($parent_id !== 0) {
            $sub_mark .= $sub_mark;
        }

        $tree_array = [];
        foreach ($list_tree as $element) {
            if ($element['parent_id'] == $parent_id) {
                $value = isset($element['title']) ? $element['title'] : $element['name'];

                $tree_array[$element['id']] = $sub_mark . $value;
                $sub_list = format_tree_output($list_tree, $element['id'], $sub_mark);
                if (!empty($sub_list)) {
                    $tree_array = array_merge($tree_array, $sub_list);
                }
            }
        }

        return $tree_array;
    }
}

if (!function_exists('format_dropdown')) {
    function format_dropdown($list_array)
    {
        if (empty($list_array)) {
            return false;
        }

        $dropdown_list = [];
        foreach ($list_array as $value) {
            $dropdown_list[$value['id']] = isset($value['title']) ? $value['title'] : $value['name'];
        }

        return $dropdown_list;
    }
}

if (!function_exists('tree_output_html')) {
    function tree_output_html($list_tree, $parent_id = 0)
    {
        if (empty($list_tree)) {
            return false;
        }

        $tree_html = "<ul>";
        foreach ($list_tree as $element) {
            if ($element['parent_id'] == $parent_id) {
                $value    = isset($element['title']) ? $element['title'] : $element['name'];
                $sub_list = tree_output_html($list_tree, $element['id']);
                $tree_html .= '<li>' . $value . $sub_list . "</li>";
            }
        }
        $tree_html .= "</ul>";
        return $tree_html;
    }
}

// Check if the function does not exists
if ( ! function_exists('slugify'))
{
    // Slugify a string
    function slugify($string)
    {
        // Get an instance of $this
        $CI =& get_instance();

        $CI->load->helper('text');
        $CI->load->helper('url');

        // Replace unsupported characters (add your owns if necessary)
        $string = str_replace("'", '-', $string);
        $string = str_replace(".", '-', $string);
        $string = str_replace("?", '2', $string);

        // Slugify and return the string
        return url_title(convert_accented_characters($string), 'dash', true);
    }
}