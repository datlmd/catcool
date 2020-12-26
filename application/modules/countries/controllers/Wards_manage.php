<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Wards_manage extends Admin_Controller
{
    protected $errors = [];

    CONST MANAGE_ROOT = 'countries/wards_manage';
    CONST MANAGE_URL  = 'countries/wards_manage';

    public function __construct()
    {
        parent::__construct();

        //set theme
        $this->theme->theme(config_item('theme_admin'))
            ->add_partial('header')
            ->add_partial('footer')
            ->add_partial('sidebar');

        $this->lang->load('countries_wards_manage', $this->_site_lang);

        //load model manage
        $this->load->model("countries/Ward", 'Ward');

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('text_country'), base_url('countries/manage'));
        $this->breadcrumb->add(lang('text_province'), base_url('countries/provinces_manage'));
        $this->breadcrumb->add(lang('text_district'), base_url('countries/districts_manage'));
        $this->breadcrumb->add(lang('heading_title'), base_url(self::MANAGE_URL));
    }

    public function index()
    {
        $this->theme->title(lang("heading_title"));

        //phai full quyen hoac chi duoc doc
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_read'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }

        $filter = $this->input->get('filter');
        if (!empty($filter)) {
            $data['filter_active'] = true;
        }

        $limit              = empty($this->input->get('filter_limit', true)) ? get_pagination_limit(true) : $this->input->get('filter_limit', true);
        $start_index        = (isset($_GET['page']) && is_numeric($_GET['page'])) ? ($_GET['page'] - 1) * $limit : 0;
        list($list, $total) = $this->Ward->get_all_by_filter($filter, $limit, $start_index);

        $data['list']   = $list;
        $data['paging'] = $this->get_paging_admin(base_url(self::MANAGE_URL), $total, $limit, $this->input->get('page'));

        set_last_url();

        $this->load->model("countries/District", "District");
        $district_list = $this->District->order_by(['sort_order' => 'ASC'])->get_all();
        $data['district_list'] = format_dropdown($district_list, 'district_id');

        theme_load('wards/list', $data);
    }

    public function add()
    {
        //phai full quyen hoac duoc them moi
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_add'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }

        if (isset($_POST) && !empty($_POST) && $this->validate_form() !== FALSE) {
            $additional_data = [
                'name'           => $this->input->post('name', true),
                'type'           => $this->input->post('type', true),
                'lati_long_tude' => $this->input->post('lati_long_tude', true),
                'district_id'    => $this->input->post('district_id', true),
                'sort_order'     => $this->input->post('sort_order', true),
                'published'      => (isset($_POST['published'])) ? STATUS_ON : STATUS_OFF,
                'is_deleted'     => STATUS_OFF,
            ];

            if ($this->Ward->insert($additional_data) !== FALSE) {
                set_alert(lang('text_add_success'), ALERT_SUCCESS);
                redirect(self::MANAGE_URL);
            } else {
                set_alert(lang('error'), ALERT_ERROR);
                redirect(self::MANAGE_URL . '/add');
            }
        }

        $this->get_form();
    }

    public function edit($id = null)
    {
        //phai full quyen hoac duoc cap nhat
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_edit'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }

        if (empty($id)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL);
        }

        if (isset($_POST) && !empty($_POST) && $this->validate_form() !== FALSE) {
            // do we have a valid request?
            if (valid_token() === FALSE || $id != $this->input->post('id')) {
                set_alert(lang('error_token'), ALERT_ERROR);
                redirect(self::MANAGE_URL);
            }

            $edit_data = [
                'name'           => $this->input->post('name', true),
                'type'           => $this->input->post('type', true),
                'lati_long_tude' => $this->input->post('lati_long_tude', true),
                'district_id'    => $this->input->post('district_id', true),
                'sort_order'     => $this->input->post('sort_order', true),
                'published'      => (isset($_POST['published'])) ? STATUS_ON : STATUS_OFF,
            ];

            if ($this->Ward->update($edit_data, $id) !== FALSE) {
                set_alert(lang('text_edit_success'), ALERT_SUCCESS);
            } else {
                set_alert(lang('error'), ALERT_ERROR);
            }
            redirect(self::MANAGE_URL . '/edit/' . $id);
        }

        $this->get_form($id);
    }

    public function delete($id = null)
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        //phai full quyen hoac duowc xoa
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_delete'), ALERT_ERROR);
            json_output(['status' => 'redirect', 'url' => 'permissions/not_allowed']);
        }

        //delete
        if (isset($_POST['is_delete']) && isset($_POST['ids']) && !empty($_POST['ids'])) {
            if (valid_token() == FALSE) {
                json_output(['status' => 'ng', 'msg' => lang('error_token')]);
            }

            $ids = $this->input->post('ids', true);
            $ids = (is_array($ids)) ? $ids : explode(",", $ids);

            $list_delete = $this->Ward->where('ward_id', $ids)->get_all();
            if (empty($list_delete)) {
                json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
            }

            try {
                foreach($list_delete as $value) {
                    $this->Ward->delete($value['ward_id']);
                }

                set_alert(lang('text_delete_success'), ALERT_SUCCESS);
            } catch (Exception $e) {
                set_alert($e->getMessage(), ALERT_ERROR);
            }

            json_output(['status' => 'redirect', 'url' => self::MANAGE_URL]);
        }

        $delete_ids = $id;

        //truong hop chon xoa nhieu muc
        if (isset($_POST['delete_ids']) && !empty($_POST['delete_ids'])) {
            $delete_ids = $this->input->post('delete_ids', true);
        }

        if (empty($delete_ids)) {
            json_output(['status' => 'ng', 'msg' => lang('error_token')]);
        }

        $delete_ids  = is_array($delete_ids) ? $delete_ids : explode(',', $delete_ids);
        $list_delete = $this->Ward->where('ward_id', $delete_ids)->get_all();
        if (empty($list_delete)) {
            json_output(['status' => 'ng', 'msg' => lang('error_token')]);
        }

        $data['csrf']        = create_token();
        $data['list_delete'] = $list_delete;
        $data['ids']         = $delete_ids;

        json_output(['data' => theme_view('wards/delete', $data, true)]);
    }

    protected function get_form($id = null)
    {
        prepend_script(js_url('js/country/load', 'common'));

        $this->load->model("countries/Country", "Country");
        $country_list = $this->Country->order_by(['sort_order' => 'ASC'])->get_all();
        $data['country_list'] = format_dropdown($country_list, 'country_id');

        //edit
        if (!empty($id) && is_numeric($id)) {
            $data['text_form']   = lang('text_edit');
            $data['text_submit'] = lang('button_save');

            $data_form = $this->Ward->get($id);
            if (empty($data_form)) {
                set_alert(lang('error_empty'), ALERT_ERROR);
                redirect(self::MANAGE_URL);
            }

            $this->load->model("countries/District", "District");
            $district_data = $this->District->get($data_form['district_id']);
            if (!empty($district_data)) {
                $district_list = $this->District->order_by(['sort_order' => 'ASC'])->get_all(['province_id' => $district_data['province_id']]);
                $data['district_list'] = format_dropdown($district_list, 'district_id');

                $data_form['province_id'] = $district_data['province_id'];
            }

            $this->load->model("countries/Province", "Province");
            $province_data = $this->Province->get($district_data['province_id']);
            if (!empty($province_data)) {
                $province_list = $this->Province->order_by(['sort_order' => 'ASC'])->get_all(['country_id' => $province_data['country_id']]);
                $data['province_list'] = format_dropdown($province_list, 'province_id');

                $data_form['country_id'] = $province_data['country_id'];
            }

            // display the edit user form
            $data['csrf']      = create_token();
            $data['edit_data'] = $data_form;
        } else {
            $data['text_form']   = lang('text_add');
            $data['text_submit'] = lang('button_add');
        }

        $data['text_cancel']   = lang('text_cancel');
        $data['button_cancel'] = base_url(self::MANAGE_URL.http_get_query());

        if (!empty($this->errors)) {
            $data['errors'] = $this->errors;
        }

        $this->theme->title($data['text_form']);
        $this->breadcrumb->add($data['text_form'], base_url(self::MANAGE_URL));

        theme_load('wards/form', $data);
    }

    protected function validate_form()
    {
        $this->form_validation->set_rules('name', lang('text_name'), 'trim|required');
        $this->form_validation->set_rules('district_id', lang('text_province'), 'trim|required');

        $is_validation = $this->form_validation->run();
        $this->errors  = $this->form_validation->error_array();

        return $is_validation;
    }

    public function publish()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        //phai full quyen hoac duoc cap nhat
        if (!$this->acl->check_acl()) {
            json_output(['status' => 'ng', 'msg' => lang('error_permission_edit')]);
        }

        if (empty($_POST)) {
            json_output(['status' => 'ng', 'msg' => lang('error_json')]);
        }

        $id        = $this->input->post('id');
        $item_edit = $this->Ward->get($id);
        if (empty($item_edit)) {
            json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
        }

        $item_edit['published'] = !empty($_POST['published']) ? STATUS_ON : STATUS_OFF;
        if (!$this->Ward->update($item_edit, $id)) {
            $data = ['status' => 'ng', 'msg' => lang('error_json')];
        } else {
            $data = ['status' => 'ok', 'msg' => lang('text_published_success')];
        }

        json_output($data);
    }
}