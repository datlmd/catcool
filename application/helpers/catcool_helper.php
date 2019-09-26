<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('get_lang'))
{
    function get_lang()
    {
        if (is_multi_lang() == false) {
            return config_item('language');
        }

        $CI = & get_instance();
        if (!empty($CI->session->userdata("site_lang"))) {
            return $CI->session->userdata("site_lang");
        }

        $language_value = '';
        if (!empty(is_multi_lang()) && is_multi_lang() == true) {
            $language = get_cookie('cc_lang_web_value');
            if (!empty($language)) {
                $language_value = $language;
            }
        }

        if (empty($language_value)) {
            $language_value = config_item('language');
        }

        $CI->session->set_userdata("site_lang", $language_value);

        return $language_value;
    }
}

if (!function_exists('set_lang'))
{
    function set_lang($lang)
    {
        if (is_multi_lang() == false) {
            return config_item('language');
        }

        $CI = & get_instance();

        $multi_language = get_multi_lang();
        if (empty($lang) || !isset($multi_language[$lang])) {
            $lang = config_item('language');
        }

        $cookie_config = [
            'name' => 'cc_lang_web_value',
            'value' => $lang,
            'expire' => 86400 * 30,
            'domain' => '',
            'path' => '/',
            'prefix' => '',
            'secure' => FALSE
        ];
        set_cookie($cookie_config);

        $CI->session->set_userdata("site_lang", $lang);

        return true;
    }
}

if (!function_exists('is_multi_lang'))
{
    function is_multi_lang()
    {
        if (!empty(config_item('is_multi_language')) && config_item('is_multi_language') == true) {
            return true;
        }

        return false;
    }
}

if (!function_exists('is_show_select_language'))
{
    function is_show_select_language()
    {
        if (is_multi_lang() == false) {
            return false;
        }

        if (empty(config_item('is_show_select_language'))) {
            return false;
        }

        return true;
    }
}

if (!function_exists('get_lang_abbr'))
{
    function get_lang_abbr()
    {
        $lang           = get_lang();
        $multi_language = get_multi_lang(true);

        return $multi_language[$lang];
    }
}

if (!function_exists('get_multi_lang'))
{
    /**
     * $list_language = ['vn' => 'vi', 'english' => 'en']
     *
     * @param bool $is_show_code
     * @return array|bool
     */
    function get_multi_lang($is_show_code = false)
    {
        //list lang
        $list_language = explode(',', config_item('list_multi_language'));
        if (empty($list_language)) {
            return false;
        }

        foreach ($list_language as $key => $value) {
            $lang_tmp = explode(':', $value);
            if (count($lang_tmp) != 2) {
                continue;
            }

            if ($is_show_code) {
                $list_language[$lang_tmp[1]] = $lang_tmp[0];
            } else {
                $list_language[$lang_tmp[1]] = lang($lang_tmp[1]);
            }

            unset($list_language[$key]);
        }

        return $list_language;
    }
}

if (!function_exists('create_token'))
{
    /**
     * @return array A CSRF key-value pair
     */
    function create_token()
    {
        if (empty(config_item('is_check_csrf_admin'))) { // neu config is_check_csrf_admin = false khong can check
            return [];
        }

        $CI = & get_instance();

        $CI->load->helper('string');

        $key   = 't_' . md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] . random_string('alnum', 8));
        $value = md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] . random_string('alnum', 20));

        if (!empty(config_item('csrf_cookie_expire'))) {
            $expire = config_item('csrf_cookie_expire');
        } else {
            $expire = 7200; // 2 gio
        }
        $cookie_config = [
            'name' => $key,
            'value' => $value,
            'expire' => $expire,
            'domain' => '',
            'path' => '/',
            'prefix' => '',
            'secure' => FALSE
        ];

        set_cookie($cookie_config);

        return [config_item('csrf_name_key') => $key, config_item('csrf_name_value') => $value];
    }
}

if (!function_exists('valid_token'))
{
    /**
     * @return bool Whether the posted CSRF token matches
     */
    function valid_token($is_get = FALSE)
    {
        if (empty(config_item('is_check_csrf_admin'))) { // neu config is_check_csrf_admin = false khong can check
            return TRUE;
        }

        $csrf_key   = '';
        $csrf_value = '';

        if ($is_get === FALSE && $_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_POST[config_item('csrf_name_key')]) || !isset($_POST[config_item('csrf_name_value')])) {
                return FALSE;
            }
            $csrf_key   = $_POST[config_item('csrf_name_key')];
            $csrf_value = $_POST[config_item('csrf_name_value')];

        } else {
            if (!isset($_GET[config_item('csrf_name_key')]) || !isset($_GET[config_item('csrf_name_value')])) {
                return FALSE;
            }
            $csrf_key   = $_GET[config_item('csrf_name_key')];
            $csrf_value = $_GET[config_item('csrf_name_value')];
        }

        if (!isset($_COOKIE[$csrf_key])) {
            return FALSE;
        }

        if (!empty($csrf_value) && $csrf_value == get_cookie($csrf_key)) {
            //xoa token cookie
            delete_cookie($csrf_key);

            return TRUE;
        }

        return FALSE;

    }
}

if(!function_exists('create_input_token'))
{
    function create_input_token($csrf)
    {
        if (empty($csrf) || !isset($csrf[config_item('csrf_name_key')]) || !isset($csrf[config_item('csrf_name_value')])) {
            return NULL;
        }

        return '
            <input type="hidden" name="' . config_item('csrf_name_key') . '" value="' . $csrf[config_item('csrf_name_key')] . '">
            <input type="hidden" name="' . config_item('csrf_name_value') . '" value="' . $csrf[config_item('csrf_name_value')] . '">
        ';
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
        $upload_path = get_upload_url();
        if (! is_file( CATCOOLPATH . $upload_path . $image)) {
            return img_alt_url(200, 150);
        }

        return base_url($upload_path) . $image;
    }
}

if ( ! function_exists('img_alt'))
{
    /**
     * Displays an alternative image using placehold.it website.
     *
     * @return  string
     */
    function img_alt($width, $height = null, $text = null, $background = null, $foreground = null)
    {
        $params = array();
        if (is_array($width))
        {
            $params = $width;
        }
        else
        {
            $params['width']        = $width;
            $params['height']       = $height;
            $params['text']         = $text;
            $params['background']   = $background;
            $params['foreground']   = $foreground;
        }
        $params['height']       = (empty($params['height'])) ? $params['width'] : $params['height'];
        $params['text']         = (empty($params['text'])) ? $params['width'].' x '. $params['height'] : $params['text'];
        $params['background']   = (empty($params['background'])) ? 'CCCCCC' : $params['height'];
        $params['foreground']   = (empty($params['foreground'])) ? '969696' : $params['foreground'];
        return '<img src="http://placehold.it/'. $params['width'].'x'. $params['height'].'/'.$params['background'].'/'.$params['foreground'].'&text='. $params['text'].'" alt="Placeholder">';
    }
}

if ( ! function_exists('img_alt_url'))
{
    /**
     * Displays an alternative image using placehold.it website.
     *
     * @return  string
     */
    function img_alt_url($width, $height = null, $text = null, $background = null, $foreground = null)
    {
        $params = array();
        if (is_array($width))
        {
            $params = $width;
        }
        else
        {
            $params['width']        = $width;
            $params['height']       = $height;
            $params['text']         = $text;
            $params['background']   = $background;
            $params['foreground']   = $foreground;
        }
        $params['height']       = (empty($params['height'])) ? $params['width'] : $params['height'];
        $params['text']         = (empty($params['text'])) ? $params['width'].' x '. $params['height'] : $params['text'];
        $params['background']   = (empty($params['background'])) ? 'CCCCCC' : $params['height'];
        $params['foreground']   = (empty($params['foreground'])) ? '969696' : $params['foreground'];
        return 'http://placehold.it/'. $params['width'].'x'. $params['height'].'/'.$params['background'].'/'.$params['foreground'].'&text='. $params['text'];
    }
}

//set last url
if(!function_exists('set_last_url'))
{

    function set_last_url($except_methods = FALSE)
    {
        if(URL_LAST_FLAG == 0)
        {
            return false;
        }

        if($except_methods)
        {
            //fetch array
            $except_methods = explode(',', $except_methods);

            $CI = &get_instance();

            $current_method = $CI->router->method;

            foreach($except_methods as $except)
            {
                if($except == $current_method)
                {
                    return;
                }
            }
        }
        //if(!isset($_SESSION[URL_LAST_SESS_NAME]))
        $_SESSION[URL_LAST_SESS_NAME] = full_url();
    }

}

/**
 * get link url
 *
 * @param string $uri
 * @return string full link
 */
function full_url()
{
    $pageURL = 'http';

    if(isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on")
    {
        $pageURL .= "s";
    }

    $pageURL .= "://";
    if($_SERVER["SERVER_PORT"] != "80")
    {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    }
    else
    {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
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
    function upload_file($field_name, $upload_uri, $type = 'jpg|JPG|jpeg|JPEG|png|PNG|gif|GIF|bmp|BMP', $max_size = 0, $max_width = 0, $max_height = 0, $encrypt_name = false, $is_make_ymd_folder = TRUE)
    {
        $CI = & get_instance();

        $dir_upload = get_folder_upload($upload_uri, $is_make_ymd_folder);

        $config = [
            'upload_path'   => $dir_upload['dir'],
            'allowed_types' => $type,
            'max_size'      => $max_size,
            'max_width'     => $max_width,
            'max_height'    => $max_height,
            'encrypt_name'  => $encrypt_name
        ];

        $CI->load->library('upload', $config);

        if(!$CI->upload->do_upload($field_name))
        {
            return [
                'status' => 'ng',
                'msg'    => $CI->upload->display_errors()
            ];
        }
        else
        {
            $file = $CI->upload->data();

            return [
                'status' => 'ok',
                'file'   => $file,
                'image'  => $dir_upload['sub_dir'] . '/' . $file['file_name']
            ];
        }
    }
}

/**
 * Get folder upload file
 *
 * @param string $folder_uri /images/avatar
 * @param string $sub_link_file return
 * @return array 'dir' full path, 'sub_dir' path yymmdd
 */
if(!function_exists('get_folder_upload'))
{
    function get_folder_upload($folder_uri, $is_make_ymd_folder = TRUE)
    {
        // get dir path
        $dir = get_upload_path() . $folder_uri;

        // get date
        $sub_folder = ($is_make_ymd_folder) ? date('ymd') : '';

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

if(!function_exists('get_upload_path'))
{
    function get_upload_path($upload_uri = NULL)
    {
        if (!empty($upload_uri)) {
            return CATCOOLPATH . 'content/assets/uploads/'. $upload_uri;
        }

        return CATCOOLPATH . 'content/assets/uploads/';
    }
}

if(!function_exists('get_upload_url'))
{
    function get_upload_url($upload_uri = NULL)
    {
        if (!empty($upload_uri)) {
            return  'content/assets/uploads/' . $upload_uri;
        }

        return 'content/assets/uploads/';
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
if(!function_exists('random_string_bk'))
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
            var image_url = "' . base_url() . get_upload_url() . '";
            var global_username = "' . $CI->session->userdata('username') . '";
        ';
    }
}
