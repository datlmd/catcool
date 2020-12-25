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

        $country_id    = $this->input->post('country_id');
        $province_list = $this->Province->order_by(['sort_order' => 'ASC'])->get_all(['country_id' => $country_id]);
        if (empty($province_list)) {
            json_output(['status' => 'ng', 'msg' => lang('text_none')]);
        }
        $province_list = format_dropdown($province_list, 'province_id');

        json_output(['status' => 'ok', 'provinces' => $province_list]);
    }
}
