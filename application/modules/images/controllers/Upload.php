<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends Admin_Controller
{
    public $config_form = [];
    public $data        = [];

    CONST MANAGE_NAME       = 'images';
    CONST MANAGE_URL        = self::MANAGE_NAME . '/manage';
    CONST MANAGE_PAGE_LIMIT = PAGINATION_DEFAULF_LIMIT;

    public function __construct()
    {
        parent::__construct();

        $this->lang->load('image', $this->_site_lang);

        //load model manage
        $this->load->model("images/ImageManager", 'Manager');

        $this->theme->theme('admin')
            ->title('Admin Panel')
            ->add_partial('header')
            ->add_partial('footer')
            ->add_partial('sidebar');

    }

    public function index()
    {
        header('content-type: application/json; charset=utf8');

        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $upload = upload_file('file', 'article');

        echo json_encode($upload);
        return;
    }

    public function do_delete()
    {
        header('content-type: application/json; charset=utf8');

        if (!$this->input->is_ajax_request()) {
            show_404();
        }

//        if (empty($_POST)) {
//            echo json_encode(['status' => 'ng', 'msg' => lang('error_json')]);
//            return;
//        }

        $image_url = $this->input->post('image_url', true);

        $dir = CATCOOLPATH . 'content/assets/uploads/' . $image_url;
        if (is_file($dir)) {
            delete_files($dir);
        }

        $data = ['status' => 'ok', 'msg' => lang('modify_publish_success')];

        echo json_encode($data);
        return;
    }
}
