<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Provinces extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model("countries/Province", 'Province');
        $this->lang->load('countries', $this->_site_lang);
    }

    public function index()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        if (empty($_POST)) {
            json_output(['status' => 'ng', 'msg' => lang('text_none')]);
        }

        $id            = $this->input->post('id');
        $province_list = $this->Province->order_by(['name' => 'ASC'])->get_all(['country_id' => $id]);
        if (empty($province_list)) {
            json_output(['status' => 'ng', 'msg' => lang('text_none')]);
        }
        $province_list = format_dropdown($province_list, 'province_id');

        json_output(['status' => 'ok', 'provinces' => $province_list]);
    }
}
