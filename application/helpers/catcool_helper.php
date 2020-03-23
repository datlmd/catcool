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
        if (is_multi_lang() == false || empty($lang)) {
            return config_item('language');
        }

        $is_lang        = false;
        $multi_language = get_list_lang();
        foreach($multi_language as $value) {
            if ($value['code'] == $lang) {
                $is_lang = true;
            }
        }
        if (!$is_lang) {
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

        $CI = & get_instance();
        $CI->session->set_userdata("site_lang", $lang);

        return true;
    }
}

if (!function_exists('is_multi_lang'))
{
    function is_multi_lang()
    {
        $list_language = json_decode(config_item('list_language_cache'), 1);
        if (count($list_language) >= 2) {
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

if (!function_exists('get_list_lang'))
{
    /**
     * Get list language
     *
     * @return bool|mixed
     */
    function get_list_lang()
    {
        //list lang
        $list_language = json_decode(config_item('list_language_cache'), 1);
        if (empty($list_language)) {
            return false;
        }

        foreach ($list_language as $key => $value) {
            if ($value['code'] == get_lang()) {
                $list_language[$key]['active'] = true;
            }
            if (empty($value['icon'])) {
                $list_language[$key]['icon'] = '<i class="flag-icon flag-icon-' . $value['code'] . ' mr-2"></i>';
            } else {
                $list_language[$key]['icon'] = '<i class="' . $value['icon'] . ' mr-2"></i>';
            }
        }

        return $list_language;
    }
}

if (!function_exists('get_lang_id'))
{
    /**
     * @return int
     */
    function get_lang_id()
    {
        $language_id = 1;
        //list lang
        $list_language = json_decode(config_item('list_language_cache'), 1);
        foreach ($list_language as $key => $value) {
            if ($value['code'] == get_lang()) {
                $language_id = $value['id'];
                break;
            }
        }

        return $language_id;
    }
}

if (!function_exists('format_data_lang_id'))
{
    /**
     * @param $data
     * @return mixed
     */
    function format_data_lang_id($data)
    {
        if (empty($data['details'])) {
            return $data;
        }
        $data['details'] = array_column($data['details'], null, 'language_id');

        return $data;
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

if(!function_exists('http_get_query'))
{
    function http_get_query()
    {
        $CI = &get_instance();

        $query_string_sep = (strpos(base_url(), '?') === FALSE) ? '?' : '&amp;';
        if ( !empty($CI->input->get())) {
            return $query_string_sep.http_build_query($CI->input->get());
        }

        return false;
    }
}

if (!function_exists('format_tree'))
{
    function format_tree($list_data, $parent_id = 0)
    {
        if (empty($list_data)) {
            return false;
        }

        if (is_array($list_data) && empty($list_data['data'])) {
            return null;
        }

        if (is_array($list_data) && !empty($list_data['data']) && !empty($list_data['key_id'])) {
            $list_tree = $list_data['data'];
            $key_id    = $list_data['key_id'];
        } else {
            $list_tree = $list_data;
            $key_id    = 'id';
        }

        $tree_array = [];
        foreach ($list_tree as $element) {
            if ($element['parent_id'] == $parent_id) {
                $subs = format_tree($list_data, $element[$key_id]);
                if (!empty($subs)) {
                    $element['subs'] = $subs;
                }
                $tree_array[$element[$key_id]] = $element;
            }
        }

        return $tree_array;
    }
}

if (!function_exists('fetch_tree'))
{
    /**
     * get node parent
     *
     * @param $tree
     * @param $parent_id
     * @param bool $parentfound
     * @param array $list
     * @return array
     */
    function fetch_tree($tree, $parent_id, $parentfound = false, $list = array())
    {
        foreach ($tree as $k => $v) {
            if ($parentfound || $k == $parent_id) {
                $rowdata = [];
                foreach ($v as $field => $value) {
                    if ($field != 'subs') {
                        $rowdata[$field] = $value;
                    }
                }
                $list[] = $rowdata;
                if (!empty($v['subs'])) {
                    $list = array_merge($list, fetch_tree($v['subs'], $parent_id, true));
                }
            } elseif (!empty($v['subs'])) {
                $list = array_merge($list, fetch_tree($v['subs'], $parent_id));
            }
        }

        return $list;
    }
}

if(!function_exists('draw_tree_output'))
{
    /**
     * <select name="parent_id" id="parent_id" size="8" class="form-control">
     *  <option value="">{lang('select_dropdown_label')}</option>
     *  {$output_html = '<option ##SELECTED## value="##VALUE##">##INDENT_SYMBOL####NAME##</option>'}
     *  {$indent_symbol = '-&nbsp;-&nbsp;'}
     *  {draw_tree_output(['data' => $list_patent, 'key_id' => 'category_id', 'id_root' => $edit_data.category_id], $output_html, 0, $edit_data.parent_id, $indent_symbol)}
     * </select>
     *
     * @param $list_data
     * @param $input_html
     * @param int $level
     * @param array $selected_value
     * @param string $indent_symbol - $indent_symbol = '-&nbsp;-&nbsp;'
     * @param string $href_uri
     * @return null|string
     */
    function draw_tree_output($list_data, $input_html, $level = 0, $selected_value = [], $indent_symbol = '-&nbsp;', $href_uri = '')
    {
        if (empty($list_data)) {
            return null;
        }

        if (is_array($list_data) && empty($list_data['data'])) {
            return null;
        }

        if (is_array($list_data) && !empty($list_data['data']) && !empty($list_data['key_id'])) {
            $list_tree = $list_data['data'];
            $key_id    = $list_data['key_id'];
            $id_root   = !empty($list_data['id_root']) ? $list_data['id_root'] : null;
        } else {
            $list_tree = $list_data;
            $key_id    = 'id';
            $id_root   = null;
        }

        $output = '';
        foreach($list_tree as $value)
        {
            // Init
            $each_category_html = $input_html;

            if (!empty($selected_value) && !is_array($selected_value)) {
                $selected_value = explode("," , $selected_value);
            }

            $selected = (!empty($selected_value) && in_array($value[$key_id], $selected_value)) ? 'selected' : '';

            if ($value[$key_id] == $id_root || $value['parent_id'] == $id_root) {
                $selected = 'disabled';
            }

            //check khi da ngon ngu
            if (!empty($value['detail'])) {
                $name = (isset($value['detail']['title'])) ? $value['detail']['title'] : (isset($value['detail']['name']) ? $value['detail']['name'] : '');
            } else {
                $name = (isset($value['title'])) ? $value['title'] : (isset($value['name']) ? $value['name'] : '');
            }

            $indent = '';
            for($i = 1; $i <= $level; $i++)
            {
                $indent .= $indent_symbol;
            }

            $find_replace = array(
                '##VALUE##'         => $value[$key_id],
                '##INDENT_SYMBOL##' => $indent,
                '##NAME##'          => $name,
                '##SELECTED##'      => $selected,
                '##HREF##'          => $href_uri
            );

            $output .= strtr($each_category_html, $find_replace);

            if(isset($value['subs']))
            {
                if ($value['parent_id'] == $id_root) {
                    $id_root = $value[$key_id];
                }
                $output .= draw_tree_output(['data' => $value['subs'], 'key_id' => $key_id, 'id_root' => $id_root], $input_html, $level + 1, $selected_value, $indent_symbol, $href_uri);
            }
        }

        return $output;
    }
}

if(!function_exists('draw_tree_output_name'))
{
    /**
     * @param $list_data
     * @param $input_html
     * @param int $level
     * @param array $selected_value
     * @param string $href_uri
     * @return null|string
     */
    function draw_tree_output_name($list_data, $input_html, $level = 0, $selected_value = [], $indent_symbol = null, $href_uri = '')
    {
        if (empty($list_data)) {
            return null;
        }

        if (is_array($list_data) && !empty($list_data['data']) && !empty($list_data['key_id'])) {
            $list_tree = $list_data['data'];
            $key_id    = $list_data['key_id'];
            $id_root   = !empty($list_data['id_root']) ? $list_data['id_root'] : null;
        } else {
            $list_tree = $list_data;
            $key_id    = 'id';
            $id_root   = null;
        }

        $output = '';
        foreach($list_tree as $value)
        {
            // Init
            $each_category_html = $input_html;

            if (!empty($selected_value) && !is_array($selected_value)) {
                $selected_value = explode("," , $selected_value);
            }

            $selected = (!empty($selected_value) && in_array($value[$key_id], $selected_value)) ? 'selected' : '';

            if ($value[$key_id] == $id_root || $value['parent_id'] == $id_root) {
                $selected = 'disabled';
            }

            //check khi da ngon ngu
            if (!empty($value['detail'])) {
                $name = (isset($value['detail']['title'])) ? $value['detail']['title'] : (isset($value['detail']['name']) ? $value['detail']['name'] : '');
            } else {
                $name = (isset($value['title'])) ? $value['title'] : (isset($value['name']) ? $value['name'] : '');
            }

            $indent = empty($indent_symbol) ? '' : $indent_symbol;

            $find_replace = array(
                '##VALUE##'         => $value[$key_id],
                '##INDENT_SYMBOL##' => $indent,
                '##NAME##'          => $name,
                '##SELECTED##'      => $selected,
                '##HREF##'          => $href_uri
            );

            $output .= strtr($each_category_html, $find_replace);

            if(isset($value['subs']))
            {
                $indent = $indent . $name . ' > ';
                if ($value['parent_id'] == $id_root) {
                    $id_root = $value[$key_id];
                }
                $output .= draw_tree_output_name(['data' => $value['subs'], 'key_id' => $key_id, 'id_root' => $id_root], $input_html, $level + 1, $selected_value, $indent, $href_uri);
            }
        }

        return $output;
    }
}

if (!function_exists('format_dropdown')) {
    function format_dropdown($list_array, $key_id = 'id')
    {
        if (empty($list_array)) {
            return false;
        }

        $dropdown_list = [];
        foreach ($list_array as $value) {
            //check khi da ngon ngu
            if (!empty($value['detail'])) {
                $name = (isset($value['detail']['title'])) ? $value['detail']['title'] : (isset($value['detail']['name']) ? $value['detail']['name'] : '');
            } else {
                $name = (isset($value['title'])) ? $value['title'] : (isset($value['name']) ? $value['name'] : '');
            }

            $dropdown_list[$value[$key_id]] = $name;
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
            return img_alt_url(RESIZE_IMAGE_THUMB_WIDTH, RESIZE_IMAGE_THUMB_HEIGHT);
        }

        return base_url($upload_path) . $image;
    }
}

if(!function_exists('image_thumb_url'))
{
    function image_thumb_url($image = null, $width = RESIZE_IMAGE_THUMB_WIDTH, $height = RESIZE_IMAGE_THUMB_HEIGHT)
    {
        $upload_path = get_upload_url();
        if (! is_file( CATCOOLPATH . $upload_path . $image)) {
            return img_alt_url($width, $height);
        }

        $CI = &get_instance();
        $CI->load->model('images/image_tool', 'image_tool');

        return base_url($upload_path) . $CI->image_tool->resize($image, $width, $height);
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
 * @return array 'error' 1|0, 'message' error, 'file' file info, 'sort_link' yyyymm
 */
if(!function_exists('upload_file'))
{
    function upload_file($field_name, $upload_uri, $type = 'jpg|JPG|jpeg|JPEG|png|PNG|gif|GIF|bmp|BMP', $max_size = 0, $max_width = 0, $max_height = 0, $encrypt_name = true, $is_make_ymd_folder = TRUE)
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
            $file = $CI->upload->data();

            return [
                'status' => 'ng',
                'file'   => (!empty($file['file_name'])) ? $file['file_name'] : '',
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

if(!function_exists('move_file_tmp'))
{
    /**
     * copy file den thu muc moi va xoa file cu
     *
     * @param $field_name_tmp
     * @return bool|mixed
     */
    function move_file_tmp($field_name_tmp)
    {
        if (empty($field_name_tmp)) {
            return FALSE;
        }

        $upload_path = get_upload_path();
        $file_info   = pathinfo($upload_path . $field_name_tmp);

        if (! is_file($upload_path . $field_name_tmp)) {
            return FALSE;
        }

        $file_new   = str_replace('tmp/', '', $field_name_tmp);
        $folder_new = str_replace('tmp/', '', $file_info['dirname']);

        if (!is_dir($folder_new)) {
            mkdir($folder_new, 0775, true);
        }

        if (write_file($upload_path . $file_new, read_file($upload_path . $field_name_tmp))) {
            delete_files(unlink($upload_path . $field_name_tmp));
            return $file_new;
        }

        return FALSE;
    }
}

if(!function_exists('delete_file_upload'))
{

    function delete_file_upload($file_name)
    {
        $upload_path = get_upload_path();

        if (! is_file($upload_path . $file_name)) {
            return FALSE;
        }

        return delete_files(unlink($upload_path . $file_name));
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
        $sub_folder = ($is_make_ymd_folder) ? date('Ym') : '';

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
            return CATCOOLPATH . UPLOAD_FILE_DIR . $upload_uri;
        }

        return CATCOOLPATH . UPLOAD_FILE_DIR;
    }
}

if(!function_exists('get_upload_url'))
{
    function get_upload_url($upload_uri = NULL)
    {
        return !empty($upload_uri) ? UPLOAD_FILE_DIR . $upload_uri : UPLOAD_FILE_DIR;
    }
}

//check field data is image or not
if(!function_exists('is_image_link'))
{
    function is_image_link($field, $extension = null)
    {
        if (!empty($extension)) {
            $extension = (is_array($extension)) ? $extension : explode('|', $extension);
        } else {
            $extension = ['png', 'PNG', 'jpg', 'JPG', 'jpeg', 'JPEG', 'gif', 'GIF', 'bmp', 'BMP'];
        }

        $info = pathinfo($field);
        if(in_array($info["extension"], $extension))
            return TRUE;

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

if (!function_exists('json_output'))
{
    function json_output($data)
    {
        if (empty($data)) {
            return false;
        }

        header('content-type: application/json; charset=utf8');
        echo json_encode($data);
        exit();
    }
}