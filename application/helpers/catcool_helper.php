<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('get_lang'))
{
    function get_lang()
    {
        $CI = & get_instance();

        $language = get_cookie('cc_lang_web_value');
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

        $multi_language = get_multi_lang();
        if (empty($lang) || !is_multi_lang() || !array_key_exists($lang, $multi_language)) {
            $lang = config_item('language');
        }

        $cookie_config = array(
            'name' => 'cc_lang_web_value',
            'value' => $lang,
            'expire' => time() + (86400 * 30),
            'domain' => '',
            'path' => '/',
            'prefix' => '',
            'secure' => FALSE
        );
        set_cookie($cookie_config);

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
        $CI->load->model("catcool/LanguageManager", 'Language');

        //list lang
        $list_language = $CI->Language->get_list_by_publish();
        if (empty($list_language)) {
            return false;
        }

        foreach ($list_language as $key => $value) {
            $list_language[$value['code']] = lang($value['code']);
            unset($list_language[$key]);
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
        if (!empty(config_item('is_check_csrf_admin')) && config_item('is_check_csrf_admin') === TRUE) {
            $CI = & get_instance();

            $csrfkey = $CI->input->post($CI->session->flashdata('csrfkey'));
            if ($csrfkey && $csrfkey == $CI->session->flashdata('csrfvalue')) {
                return TRUE;
            }
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

if(!function_exists('draw_tree_output'))
{

    function draw_tree_output($list_data, $input_html, $level = 0, $selected_value = [], $indent_symbol = '-&nbsp;', $href_uri = '')
    {
        if (empty($list_data)) {
            return null;
        }

        $output = '';
        foreach($list_data as $value)
        {
            // Init
            $each_category_html = $input_html;

            $indent = '';
            for($i = 1; $i <= $level; $i++)
            {
                $indent .= $indent_symbol;
            }

            if (!empty($selected_value) && !is_array($selected_value)) {
                $selected_value = explode("," , $selected_value);
            }

            $selected = (!empty($selected_value) && in_array($value['id'], $selected_value)) ? 'selected' : '';


            $find_replace = array(
                '##VALUE##'         => $value['id'],
                '##INDENT_SYMBOL##' => $indent,
                '##NAME##'          => (isset($value['title'])) ? $value['title'] : $value['name'],
                '##SELECTED##'      => $selected,
                '##HREF##'          => $href_uri
            );

            $output .= strtr($each_category_html, $find_replace);

            if(isset($value['subs']))
            {
                $output .= draw_tree_output($value['subs'], $input_html, $level + 1, $selected_value, $indent_symbol, $href_uri);
            }
        }

        return $output;
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

if (!function_exists('get_list_limit')) {
    function get_list_limit($limit_array = null)
    {
        if (!empty($limit_array) && is_array($limit_array)) {
            return $limit_array;
        }

        $limit_array = [
            PAGINATION_DEFAULF_LIMIT  => PAGINATION_DEFAULF_LIMIT,
            50  => 50,
            100 => 100,
            200 => 200,
        ];

        return $limit_array;
    }
}

if(!function_exists('image_url'))
{
    function image_url($image = null)
    {
        if (empty($image)) {
            return base_url('content/assets/uploads/');
        } else {
            return base_url('content/assets/uploads/') . $image;
        }
    }
}

//set last url sử dụng trong admin
if(!function_exists('get_last_url'))
{

    function get_last_url($last_url = FALSE)
    {
        $last_url = $last_url ? $last_url : base_url();

        if(isset($_SESSION[URL_LAST_SESS_NAME]))
        {
            $last_url = $_SESSION[URL_LAST_SESS_NAME];

            unset($_SESSION[URL_LAST_SESS_NAME]);
        }
        return $last_url;
    }

}

//get previous url
if(!function_exists('previous_url'))
{
    function previous_url()
    {
        if(isset($_SESSION[URL_LAST_SESS_NAME]))
        {
            $url = $_SESSION[URL_LAST_SESS_NAME];

            unset($_SESSION[URL_LAST_SESS_NAME]);
        }
        else
        {
            $url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : base_url();
        }

        return $url;
    }
}

//get previous url
if(!function_exists('keep_previous_url'))
{
    function keep_previous_url()
    {
        $url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : base_url();

        if(!isset($_SESSION[URL_LAST_SESS_NAME]))
        {

            $_SESSION[URL_LAST_SESS_NAME] = $url;
        }
    }
}
/**
 * Upload file
 *
 * @param string $field_name
 * @param string $upload_uri example images/avatar
 * @param string $type jpg|png
 * @param int max_size
 * @param int max_width
 * @param int max_height
 * @param boolean $is_make_ymd_folder
 * @return array 'error' 1|0, 'message' error, 'file' file info, 'sort_link' yyyy/mm/dd/path
 */
if(!function_exists('upload_file'))
{
    function upload_file($field_name, $upload_uri, $type = 'jpg|JPG|jpeg|JPEG|png|PNG', $max_size = '2000', $max_width = '2000', $max_height = '2000', $encrypt_name = false, $is_make_ymd_folder = TRUE)
    {
        $CI = & get_instance();

        $dir_upload = get_folder_upload($upload_uri, $is_make_ymd_folder);

        $config = array(
            'upload_path' => $dir_upload['dir'],
            'allowed_types' => $type,
            'max_size' => $max_size,
            'max_width' => $max_width,
            'max_height' => $max_height,
            'encrypt_name' => $encrypt_name
        );

        $CI->load->library('upload', $config);

        if(!$CI->upload->do_upload($field_name))
        {
            return array(
                'status' => 'ng',
                'msg' => $CI->upload->display_errors()
            );
        }
        else
        {
            $file = $CI->upload->data();

            return array(
                'status' => 'ok',
                'file' => $file,
                'image' => $dir_upload['sub_dir'] . '/' . $file['file_name']
            );
        }
    }
}

/**
 * Get folder upload file
 *
 * @param string $folder_uri /images/avatar
 * @param string $sub_link_file return
 * @return array 'dir' full path, 'sub_dir' path yyyy/mm/dd
 */
if(!function_exists('get_folder_upload'))
{
    function get_folder_upload($folder_uri, $is_make_ymd_folder = TRUE)
    {
        // get dir path
        $dir = CATCOOLPATH . 'content/assets/uploads/' . $folder_uri;

        // get date
        $sub_folder = ($is_make_ymd_folder) ? date('Y') . '/' . date('m') . '/' . date('d') : '';

        if(!is_dir($dir))
        {
            mkdir($dir, 0775, TRUE);
        }

        $dir_all = ($is_make_ymd_folder) ? $dir . '/' . $sub_folder : $dir;

        // get folder path
        $dir_all = str_replace('//', '/', $dir_all);

        // make dir
        if(!is_dir($dir_all))
        {
            mkdir($dir_all, 0775, TRUE);
        }

        $sub_dir = $folder_uri . '/' . $sub_folder;

        return [
            'dir'     => $dir_all,
            'sub_dir' => str_replace('//', '/', $sub_dir)
        ];

        return FALSE;
    }
}

/**
 * Debug by PG
 *
 * @param type $var
 */
if(!function_exists('cc_debug'))
{
    function cc_debug($var, $is_die = TRUE)
    {
        echo '<pre>';
        print_r($var);
        echo '</pre>';

        if($is_die == TRUE)
        {
            exit();
        }
    }
}

if(!function_exists('standar_date'))
{
    function get_date($format = 'Y-m-d H:i:s')
    {
        return date($format, time());
    }
}

/**
 * Chuyển dạng date sang dạng chuẩn SQL
 *
 * @param string $char_standar Dấu phân cách dạng chuẩn
 * @param string $char Dấu phân cách dạng hiện tại
 * @return string yyyy-mm-dd
 */
if(!function_exists('standar_date'))
{
    function standar_date($date, $char_standar = '-', $char = '/', $show = FALSE)
    {
        // if show view
        if($show == TRUE)
        {
            // check char
            if(strpos($date, $char_standar) === FALSE)
            {
                return date('Y-m-d',  strtotime($date));
            }

            // convert date yy-mm-dd to array
            $date_array = explode($char_standar, $date);

            // return date dd/mm/yy
            $return_date = $date_array[2] . $char . $date_array[1] . $char . $date_array[0];

            if($return_date != $char . $char)
            {
                return $return_date;
            }
        }
        else // insert db
        {
            // check char
            if(strpos($date, $char) === FALSE)
            {
                return date('Y-m-d',  strtotime($date));
            }

            // convert date dd/mm/yyyy to array
            $date_array = explode($char, $date);

            // return date yyyy/mm/dd
            $return_date = $date_array[2] . $char_standar . $date_array[1] . $char_standar . $date_array[0];

            if($return_date != $char_standar . $char_standar)
            {
                return $return_date;
            }
        }

        return '';
    }
}

if(!function_exists('format_date'))
{
    function format_date($date, $format = FALSE, $style = FALSE)
    {
        $style = $style ? $style : 1;
        $format = $format ? $format : 'd/m/y, H:i';

        //format date to compare
        $date = date('Y-m-d H:i:s', strtotime($date));
        $today = date('Y-m-d 00:00:00');

        $formated_date = '';

        switch($style)
        {
            case 1:
                if($today < $date)
                    $format_date = 'Hôm nay ' . date('H:i', strtotime($date));
                else
                    $format_date = date($format, strtotime($date));

                break;
            case 2:
                break;
        }

        return $format_date;
    }
}
/**
 * Add/Subtract time
 * @param datetime $date
 * @param int $time time add
 * @param boolean $is_add
 */
if(!function_exists('add_time'))
{
    function add_time($date, $time, $is_add = TRUE)
    {
        $date_convert_time = strtotime($date);
        if($is_add)
        {
            $date_added = $date_convert_time + $time;
        }
        else
        {
            $date_added = $date_convert_time - $time;
        }
        return date('Y-m-d H:i:s', $date_added);
    }
}
if(!function_exists('get_client_ip'))
{
    function get_client_ip(){
        $ip = '';
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
        {
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        else
        {
            $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}

if(!function_exists('filter_bad_word_comment_content'))
{
    function filter_bad_word_comment_content($content)
    {
        static $filter;

        if (!$filter) {
            $filter = read_file(APPPATH . 'modules/comments/config/filter_comment.txt');

            $filter = explode(';', $filter);

            if ($filter) {
                foreach ($filter as $key => $value) {
                    $filter[$key] = trim($value);
                }
            }
        }

//         $content = preg_filter($filter, '***', $content);
        $content = str_replace($filter, '****', $content);

        return $content;
    }
}

/**
 * write custom cache
 */
if(!function_exists('write_html_cache'))
{
    function write_html_cache($key, $output_cache)
    {
        $CI = & get_instance();
        $CI->load->helper('file');
        write_file(FPENGUIN . APPPATH . "cache/html/cache__html__$key.html", $output_cache);
    }

}

/**
 * get custom cache
 */
if(!function_exists('get_html_cache'))
{
    function get_html_cache($key)
    {
        @include FPENGUIN . APPPATH . "cache/html/cache__html__$key.html";
    }
}

/**
 * create random string
 * @param int $length
 */
if(!function_exists('random_string'))
{
    function random_string_bk($length = 6)
    {
        $base = 'ABCDEFGHKLMNOPQRSTWXYZabcdefghjkmnpqrstwxyz123456789';
        $max = strlen($base) - 1;

        mt_srand((double) microtime() * 1000000);

        $activatecode = '';
        while(strlen($activatecode) < $length)
        {
            $activatecode .= $base{mt_rand(0, $max)};
        }

        return $activatecode;
    }
}
/**
 * get javascript global
 *
 * @return string js global
 */
if(!function_exists('script_global'))
{
    function script_global()
    {
        $CI = & get_instance();

        return '
            var base_url = "' . base_url() . '";
            var current_url = "' . current_url() . '";
            var image_url = "' . base_url() . 'content/assets/uploads/";
            var global_username = "' . $CI->session->userdata('username') . '";
        ';
    }
}
