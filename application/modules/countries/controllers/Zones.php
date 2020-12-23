<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Zones extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model("countries/Zone", 'Zone');
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

        $id        = $this->input->post('id');
        $zone_list = $this->Zone->order_by(['name' => 'ASC'])->get_all(['country_id' => $id]);
        if (empty($zone_list)) {
            json_output(['status' => 'ng', 'msg' => lang('text_none')]);
        }
        $zone_list = format_dropdown($zone_list, 'zone_id');

        json_output(['status' => 'ok', 'zones' => $zone_list]);
    }
}
