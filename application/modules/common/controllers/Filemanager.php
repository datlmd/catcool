<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Filemanager extends Admin_Controller
{
    private $dir_image      = '';
    private $dir_image_path = '';

    CONST PATH_SUB_NAME   = 'root';
    CONST FILE_PAGE_LIMIT = 20;//PAGINATION_MANAGE_DEFAULF_LIMIT;

    private $upload_type = '';

    private $image_thumb_width  = '';
    private $image_thumb_height = '';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('images/image_tool', 'image_tool');
        $this->lang->load('filemanager', $this->_site_lang);

        $this->dir_image      = get_upload_url();
        $this->dir_image_path = get_upload_path();

        $this->upload_type = 'jpg|JPG|jpeg|JPEG|png|PNG|gif|GIF|bmp|BMP';
        if (!empty(config_item('file_ext_allowed')) && (empty($this->input->get('thumb')) || $this->input->get('thumb') == 'undefined')) {
            $this->upload_type = config_item('file_ext_allowed');
        }
        $this->image_thumb_width = !empty(config_item('image_thumbnail_small_width')) ? config_item('image_thumbnail_small_width') : RESIZE_IMAGE_THUMB_WIDTH;
        $this->image_thumb_height = !empty(config_item('image_thumbnail_small_height')) ? config_item('image_thumbnail_small_height') : RESIZE_IMAGE_THUMB_HEIGHT;
    }

    public function index()
    {
        if (!$this->acl->check_acl()) {
            json_output(['status' => 'ng', 'msg' => lang('error_permission_execute')]);
        }
        $server = site_url();

        $filter_name = $this->input->get('filter_name');
        if (!empty($filter_name)) {
            $filter_name = rtrim(str_replace('*', '', $filter_name), '/');
        } else {
            $filter_name = null;
        }

        // Make sure we have the correct directory
        $directory = $this->input->get('directory');
        if (isset($directory)) {
            $directory = rtrim($this->dir_image_path . self::PATH_SUB_NAME . '/' . str_replace('*', '', $directory), '/');
        } else {
            $directory = $this->dir_image_path . self::PATH_SUB_NAME;
        }

        $page = $this->input->get('page');
        if (isset($page)) {
            $page = $page;
        } else {
            $page = 1;
        }

        $directories = [];
        $files = [];

        $data['images'] = [];

        if (substr(str_replace('\\', '/', realpath($directory . '/')), 0, strlen($this->dir_image_path . self::PATH_SUB_NAME)) == $this->dir_image_path . self::PATH_SUB_NAME) {
            // Get directories
            $directories = glob($directory . '/*' . $filter_name . '*', GLOB_ONLYDIR);

            if (!$directories) {
                $directories = [];
            }

            // Get files
            $file_type = "jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF,bmp,BMP";
            if (!empty(config_item('file_ext_allowed')) && (empty($this->input->get('thumb')) || $this->input->get('thumb') == 'undefined')) {
                $file_type = str_replace('|', ',', config_item('file_ext_allowed'));
            }
            $files = glob($directory . '/*' . $filter_name . '*.{' . $file_type . '}', GLOB_BRACE);

            if (!$files) {
                $files = [];
            }
        }

        $file_size = [];
        $file_tmp = [];
        foreach ($files as $key => $file) {
            $file_info = get_file_info($file);
            $file_size[$file] = !empty($file_info['size']) ? $file_info['size'] : 0;
            $file_tmp[$file_info['date']] = $file;
        }
        krsort($file_tmp);

        // Merge directories and files
        $images = array_merge($directories, $file_tmp);

        // Get total number of files and directories
        $image_total = count($images);

        // Split the array based on current page number and max number of items per page of 10
        $images = array_splice($images, ($page - 1) * self::FILE_PAGE_LIMIT, self::FILE_PAGE_LIMIT);


        foreach ($images as $image) {
            $name = str_split(basename($image), 14);

            if (is_dir($image)) {
                $url = '';

                $target = $this->input->get('target');
                if (isset($target)) {
                    $url .= '&target=' . $target;
                }
                $thumb = $this->input->get('thumb');
                if (isset($thumb)) {
                    $url .= '&thumb=' . $thumb;
                }
                $is_show_lightbox = $this->input->get('is_show_lightbox');
                if (isset($is_show_lightbox)) {
                    $data['is_show_lightbox'] = 1;
                    $url .= '&is_show_lightbox=1';
                }

                $data['images'][] = [
                    'thumb' => '',
                    'name'  => implode(' ', $name),
                    'type'  => 'directory',
                    'path'  => substr($image, strlen($this->dir_image_path)),
                    'href'  => site_url('common/filemanager').'?directory=' .substr($image, strlen($this->dir_image_path . self::PATH_SUB_NAME . '/')) . $url,
                ];
            } elseif (is_file($image)) {
                $ext_tmp = explode('.', implode(' ', $name));
                $extension = end($ext_tmp);
                switch ($extension) {
                    case "jpg":
                    case "JPG":
                    case "jpeg":
                    case "JPEG":
                    case "gif":
                    case "GIF":
                    case "png":
                    case "PNG":
                    case "bmp":
                    case "BMP":
                        $data['images'][] = [
                            'thumb' => $server . $this->dir_image . $this->image_tool->resize(substr($image, strlen($this->dir_image_path)), $this->image_thumb_width, $this->image_thumb_height) . '?' . time(),
                            'name'  => implode(' ', $name) . ' (' . $this->_convert_filesize($file_size[$image], 0) . ')',
                            'type'  => 'image',
                            'path'  => substr($image, strlen($this->dir_image_path)),
                            'href'  => $server . $this->dir_image . substr($image, strlen($this->dir_image_path)) . '?' . time(),
                        ];
                        break;
                    case "svg":
                    case "SVG":
                        $data['images'][] = [
                            'thumb' => $server . $this->dir_image . substr($image, strlen($this->dir_image_path)). '?' . time(),
                            'name'  => implode(' ', $name) . ' (' . $this->_convert_filesize($file_size[$image], 0) . ')',
                            'type'  => 'image',
                            'path'  => substr($image, strlen($this->dir_image_path)),
                            'href'  => $server . $this->dir_image . substr($image, strlen($this->dir_image_path)) . '?' . time(),
                        ];
                        break;
                    case "pdf":
                        $data['images'][] = [
                            'thumb' => '',
                            'name'  => implode(' ', $name) . ' (' . $this->_convert_filesize($file_size[$image], 0) . ')',
                            'type'  => 'file',
                            'path'  => substr($image, strlen($this->dir_image_path)),
                            'class' => 'far fa-file-pdf text-danger fa-5x',
                            'href'  => $server . $this->dir_image . substr($image, strlen($this->dir_image_path)),
                        ];
                        break;
                    case "html":
                    case "php":
                    case "js":
                    case "css":
                    case "txt":
                    case "md":
                    case "asp":
                    case "tpl":
                    case "aspx":
                    case "jsp":
                    case "py":
                        $data['images'][] = [
                            'thumb' => '',
                            'name'  => implode(' ', $name) . ' (' . $this->_convert_filesize($file_size[$image], 0) . ')',
                            'type'  => 'file',
                            'path'  => substr($image, strlen($this->dir_image_path)),
                            'class' => 'far fa-file text-dark fa-5x',
                            'href'  => $server . $this->dir_image . substr($image, strlen($this->dir_image_path)),
                        ];
                        break;
                    case "apk":
                        $data['images'][] = [
                            'thumb' => '',
                            'name'  => implode(' ', $name) . ' (' . $this->_convert_filesize($file_size[$image], 0) . ')',
                            'type'  => 'file',
                            'path'  => substr($image, strlen($this->dir_image_path)),
                            'class' => 'fab fa-android text-warning fa-5x',
                            'href'  => $server . $this->dir_image . substr($image, strlen($this->dir_image_path)),
                        ];
                        break;
                    case "mp4":
                        $data['images'][] = [
                            'thumb' => '',
                            'name'  => implode(' ', $name) . ' (' . $this->_convert_filesize($file_size[$image], 0) . ')',
                            'type'  => 'video',
                            'path'  => substr($image, strlen($this->dir_image_path)),
                            'href'  => $server . $this->dir_image . substr($image, strlen($this->dir_image_path)),
                        ];
                        break;
                    default:
                        $data['images'][] = [
                            'thumb' => '',
                            'name'  => implode(' ', $name) . ' (' . $this->_convert_filesize($file_size[$image], 0) . ')',
                            'type'  => 'file',
                            'path'  => substr($image, strlen($this->dir_image_path)),
                            'class' => 'fas fa-download text-secondary fa-5x',
                            'href'  => $server . $this->dir_image . substr($image, strlen($this->dir_image_path)),
                        ];
                        break;
                }
            }
        }

        $data['heading_title'] = lang('heading_title');

        $data['text_no_results'] = lang('text_no_results');
        $data['text_confirm']    = lang('text_confirm');

        $data['entry_search'] = lang('entry_search');
        $data['entry_folder'] = lang('entry_folder');

        $data['button_parent']  = lang('button_parent');
        $data['button_refresh'] = lang('button_refresh');
        $data['button_upload']  = lang('button_upload');
        $data['button_folder']  = lang('button_folder');
        $data['button_delete']  = lang('button_delete');
        $data['button_search']  = lang('button_search');

        $data['error_folder_null'] = lang('error_folder_null');
        $data['error_file_null']   = lang('error_file_null');
        $data['error_search_null'] = lang('error_search_null');

        //$data['token'] = 'token';

        $directory = $this->input->get('directory');
        if (isset($directory)) {
            $data['directory'] = urlencode($directory);
        } else {
            $data['directory'] = '';
        }

        $filter_name = $this->input->get('filter_name');
        if (!empty($filter_name)) {
            $data['filter_name'] = $filter_name;
        } else {
            $data['filter_name'] = '';
        }

        // Return the target ID for the file manager to set the value
        $target = $this->input->get('target');
        if (isset($target)) {
            $data['target'] = $target;
        } else {
            $data['target'] = '';
        }

        // Return the thumbnail for the file manager to show a thumbnail
        $thumb = $this->input->get('thumb');
        if (isset($thumb)) {
            $data['thumb'] = $thumb;
        } else {
            $data['thumb'] = '';
        }

        // Parent
        $url = '';

        $directory = $this->input->get('directory');
        if (isset($directory)) {
            $pos = strrpos($directory, '/');

            if ($pos) {
                $url .= '&directory=' . urlencode(substr($directory, 0, $pos));
            }
        }

        $target = $this->input->get('target');
        if (isset($target)) {
            $url .= '&target=' . $target;
        }

        $thumb = $this->input->get('thumb');
        if (isset($thumb)) {
            $url .= '&thumb=' . $thumb;
        }

        $is_show_lightbox = $this->input->get('is_show_lightbox');
        if (isset($is_show_lightbox)) {
            $data['is_show_lightbox'] = 1;
            $url .= '&is_show_lightbox=1';
        }

        $data['parent'] = site_url('common/filemanager').'?'. $url;

        // Refresh
        $url = '';

        $directory = $this->input->get('directory');
        if (isset($directory)) {
            $url .= '&directory=' . urlencode($directory);
        }

        $target = $this->input->get('target');
        if (isset($target)) {
            $url .= '&target=' . $target;
        }

        $thumb = $this->input->get('thumb');
        if (isset($thumb)) {
            $url .= '&thumb=' . $thumb;
        }

        $is_show_lightbox = $this->input->get('is_show_lightbox');
        if (isset($is_show_lightbox)) {
            $url .= '&is_show_lightbox=1';
        }

        $data['refresh'] = site_url('common/filemanager').'?'.$url;

        $url = '';

        $directory = $this->input->get('directory');
        if (isset($directory)) {
            $url .= '&directory=' . urlencode(html_entity_decode($directory, ENT_QUOTES, 'UTF-8'));
        }

        $filter_name = $this->input->get('filter_name');
        if (isset($_GET['filter_name'])) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($filter_name, ENT_QUOTES, 'UTF-8'));
        }
        $target = $this->input->get('target');
        if (isset($target)) {
            $url .= '&target=' . $target;
        }
        $thumb = $this->input->get('thumb');
        if (isset($thumb)) {
            $url .= '&thumb=' . $thumb;
        }

        $is_show_lightbox = $this->input->get('is_show_lightbox');
        if (isset($is_show_lightbox)) {
            $url .= '&is_show_lightbox=1';
        }

        $config['base_url']   = site_url('common/filemanager');
        $config['total_rows'] = $image_total;
        $config['per_page']   = self::FILE_PAGE_LIMIT;
        $config['page']       = $page;
        $config['url']        = $url;

        $data['pagination'] = $this->pagination($config);

        if ($this->input->is_ajax_request()) {
            $data['is_ajax'] = true;
            theme_view('filemanager', $data);
        } else {
            $data['is_ajax'] = false;
            $this->theme->theme(config_item('theme_admin'))
                ->add_partial('header')
                ->add_partial('footer')
                ->add_partial('sidebar')
                ->load('filemanager', $data);
        }
    }

    public function upload()
    {
        //phai full quyen
        if (!$this->acl->check_acl()) {
            json_output(['error' => lang('error_permission_execute')]);
        }

        $json = [];

        // create folder
        if (!is_dir($this->dir_image_path . self::PATH_SUB_NAME)) {
            mkdir($this->dir_image_path . self::PATH_SUB_NAME, 0777, true);
        }

        $directory = $this->input->get('directory');
        if (isset($directory)) {
            $directory = rtrim($this->dir_image_path . self::PATH_SUB_NAME . '/' . $directory, '/');
        } else {
            $directory = $this->dir_image_path . self::PATH_SUB_NAME;
        }

        $config = [
            'upload_path'   => $directory,
            'allowed_types' => $this->upload_type,
            'max_size'      => !empty(config_item('file_max_size')) ? config_item('file_max_size') : 0,
            'max_width'     => !empty(config_item('file_max_width')) ? config_item('file_max_width') : 0,
            'max_height'    => !empty(config_item('file_max_height')) ? config_item('file_max_height') : 0,
            'encrypt_name'  => !empty(config_item('file_encrypt_name')) ? config_item('file_encrypt_name') : FALSE,
            'overwrite'     => FALSE,
        ];

        $this->load->library('upload');

        //xoa file neu da expired sau 3 thang
        //delete_file_upload_tmp('cache', 86400*30*3);

        $files = $_FILES;
        if (empty($files)) {
            json_output(['error' => lang('error_upload_4')]);
        }

        $total = count($files['file']['name']);
        unset($_FILES);

        for($i=0; $i< $total; $i++)
        {
            $_FILES['file']['name']     = $files['file']['name'][$i];
            $_FILES['file']['type']     = $files['file']['type'][$i];
            $_FILES['file']['tmp_name'] = $files['file']['tmp_name'][$i];
            $_FILES['file']['error']    = $files['file']['error'][$i];
            $_FILES['file']['size']     = $files['file']['size'][$i];

            $this->upload->initialize($config);
            if ( ! $this->upload->do_upload('file')) {
                $json['error'] = $this->upload->display_errors();
            } elseif (!empty(config_item('enable_resize_image'))) {
                $data_upload = $this->upload->data();
                upload_resize($data_upload);
            }
            sleep(1);
        }

        if(empty($json['error'])){
            $json['success'] = lang('text_uploaded');
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    public function folder()
    {
        $json = [];

        //$json['server'] = $this->input->server('REQUEST_METHOD');

        //phai full quyen hoac duoc cap nhat
        if (!$this->acl->check_acl()) {
            $json['error'] = lang('error_permission_execute');
        }

        // Make sure we have the correct directory
        $directory = $this->input->get('directory');
        if (isset($directory)) {
            $directory = rtrim($this->dir_image_path . self::PATH_SUB_NAME . '/' . $directory, '/');
        } else {
            $directory = $this->dir_image_path . self::PATH_SUB_NAME;
        }

        // Check its a directory
        if (!is_dir($directory) || substr(str_replace('\\', '/', realpath($directory)), 0, strlen($this->dir_image_path . self::PATH_SUB_NAME)) != $this->dir_image_path . self::PATH_SUB_NAME) {
            $json['error'] = lang('error_directory');
        }


        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            // Sanitize the folder name
            $folder = basename(html_entity_decode($this->input->post('folder'), ENT_QUOTES, 'UTF-8'));

            $json['folder'] = $folder;
            // Validate the filename length
            if ((strlen($folder) < 3) || (strlen($folder) > 128)) {
                $json['error'] = lang('error_folder');
            }

            // Check if directory already exists or not
            if (is_dir($directory . '/' . $folder)) {
                $json['error'] = lang('error_exists');
            }
        }

        if (!isset($json['error'])) {
            mkdir($directory . '/' . $folder, 0777);
            chmod($directory . '/' . $folder, 0777);

            @touch($directory . '/' . $folder . '/' . 'index.html');

            $json['success'] = lang('text_directory');
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    public function delete()
    {
        $json = [];

        //phai full quyen hoac duoc cap nhat
        if (!$this->acl->check_acl()) {
            $json['error'] = lang('error_permission_execute');
        }

        $path = $this->input->post('path');
        if (isset($path)) {
            $paths = $path;
        } else {
            $paths = [];
        }

        // Loop through each path to run validations
        foreach ($paths as $path) {
            // Check path exsists
            if ($path == $this->dir_image_path . self::PATH_SUB_NAME || substr(str_replace('\\', '/', realpath($this->dir_image_path . $path)), 0, strlen($this->dir_image_path . self::PATH_SUB_NAME)) != $this->dir_image_path . self::PATH_SUB_NAME) {
                $json['error'] = lang('error_delete');

                break;
            }
        }

        if (!$json) {
            // Loop through each path
            foreach ($paths as $path) {
                $path = rtrim($this->dir_image_path . $path, '/');

                // If path is just a file delete it
                if (is_file($path)) {
                    unlink($path);

                // If path is a directory beging deleting each file and sub folder
                } elseif (is_dir($path)) {
                    $files = [];

                    // Make path into an array
                    $path = [$path . '*'];

                    // While the path array is still populated keep looping through
                    while (count($path) != 0) {
                        $next = array_shift($path);

                        foreach (glob($next) as $file) {
                            // If directory add to path array
                            if (is_dir($file)) {
                                $path[] = $file . '/*';
                            }

                            // Add the file to the files to be deleted array
                            $files[] = $file;
                        }
                    }

                    // Reverse sort the file array
                    rsort($files);

                    foreach ($files as $file) {
                        // If file just delete
                        if (is_file($file)) {
                            unlink($file);

                        // If directory use the remove directory function
                        } elseif (is_dir($file)) {
                            rmdir($file);
                        }
                    }
                }
            }

            $json['success'] = lang('text_delete');
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    public function rotation($type = '90')
    {
        $json = [];

        //phai full quyen hoac duoc cap nhat
        if (!$this->acl->check_acl()) {
            $json['error'] = lang('error_permission_execute');
        }

        $path = $this->input->post('path');
        // Check path exsists
        if (!is_file($this->dir_image_path . $path)) {
            $json['error'] = lang('error_rotation');
        }

        if (!$json) {
            // Loop through each path
            $image = $this->image_tool->rotation($path, $type);

            if (!empty($image)) {
                $json['success'] = lang('text_rotation');
                $json['image'] = image_url($image);
            } else {
                $json['error'] = lang('error_rotation');
            }
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    public function pagination($data)
    {
        $base_url = $data['base_url'];
        $total    = $data['total_rows'];
        $per_page = $data['per_page'];
        $page     = $data['page'];
        $url      = $data['url'];
        $pages    = intval($total/$per_page); if($total%$per_page != 0){$pages++;}
        $p        = "";

        if ($pages > 1) {
            for($i=1; $i<= $pages; $i++){
                $p .= '<li class="page-item numlink"><a class="page-link directory" href="' . $base_url . '?page=' . $i . $url . '" >' . $i . '</a></li>';
            }
        }

        return $p;
    }

    private function _convert_filesize($bytes, $decimals = 2)
    {
        $size   = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }
}
