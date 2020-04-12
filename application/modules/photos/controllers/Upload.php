<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends Admin_Controller
{
    public $config_form = [];
    public $data        = [];

    CONST MANAGE_ROOT       = 'photos/upload';
    CONST MANAGE_URL        = 'photos/upload';
    CONST MANAGE_PAGE_LIMIT = PAGINATION_DEFAULF_LIMIT;

    public function __construct()
    {
        parent::__construct();

        $this->lang->load('photos_manage', $this->_site_lang);
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

        if (!isset($_FILES) && empty($_FILES['file'])) {
            json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
        }

        $tmp_url ='tmp/' . $this->input->post('module', true);

        //xoa file neu da expired sau 2 gio
        delete_file_upload_tmp();

        $upload = upload_file('file', $tmp_url);

        json_output($upload);
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
