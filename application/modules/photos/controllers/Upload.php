<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends Admin_Controller
{
    public $config_form = [];
    public $data        = [];

    CONST MANAGE_NAME       = 'upload';
    CONST MANAGE_URL        = 'upload/manage';
    CONST MANAGE_PAGE_LIMIT = PAGINATION_DEFAULF_LIMIT;

    public function __construct()
    {
        parent::__construct();

        $this->lang->load('photos_manage', $this->_site_lang);

        //load model manage
        $this->load->model("photos/Photo_manager", 'Photo');
    }

    public function index()
    {

        return;
    }

    public function do_upload()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $uploads = [];

        // Count total files
        $countfiles = count($_FILES['file']['name']);

        if ($countfiles == 1) {
            $uploads = upload_file('files', 'article');
        } else {
            // Looping all files
            for ($i = 0; $i < $countfiles; $i++) {
                if (!empty($_FILES['files']['name'][$i])) {
                    // Define new $_FILES array - $_FILES['file']
                    $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                    $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                    $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                    $_FILES['file']['size'] = $_FILES['files']['size'][$i];

                    $uploads[] = upload_file('file', 'article');
                }
            }
        }

        json_output($uploads);
    }

    public function do_delete()
    {
        $this->load->helper('file');

        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        if (empty($_POST)) {
            json_output(['status' => 'ng', 'msg' => lang('error_json')]);
        }

        $image_url = $this->input->post('image_url', true);
        try {
            $dir = get_upload_path() . $image_url;

            if (is_file($dir)) {
                delete_files(unlink($dir));
            } else {
                json_output(['status' => 'ng', 'msg' => lang('file_not_found')]);
            }
        } catch (Exception $e) {
            json_output(['status' => 'ng', 'msg' => $e->getMessage()]);
        }

        $data = ['status' => 'ok', 'msg' => lang('text_delete_file_success')];

        json_output($data);
    }
}
