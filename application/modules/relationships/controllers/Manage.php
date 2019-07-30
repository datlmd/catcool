<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends Admin_Controller
{
    public $config_form = [];
    public $data        = [];

    CONST MANAGE_NAME       = 'relationships';
    CONST MANAGE_URL        = self::MANAGE_NAME . '/manage';
    CONST MANAGE_PAGE_LIMIT = PAGINATION_DEFAULF_LIMIT;

    public function __construct()
    {
        parent::__construct();

        $this->lang->load('relationship', $this->_site_lang);

        //load model manage
        $this->load->model("relationships/RelationshipManager", 'Manager');

        $this->theme->theme('admin')
            ->title('Admin Panel')
            ->add_partial('header')
            ->add_partial('footer')
            ->add_partial('sidebar');

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_name', self::MANAGE_NAME);

        //add breadcrumb
        $this->breadcrumb->add(lang('catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('list_heading'), base_url(self::MANAGE_URL));

        //check validation
        $this->config_form = [
            'candidate_table' => [
                'field' => 'candidate_table',
                'label' => lang('candidate_table_label'),
                'rules' => 'trim|required',
                'errors' => [
                    'required' => sprintf(lang('manage_validation_label'), lang('candidate_table_label')),
                ],
            ],
            'candidate_key' => [
                'field' => 'candidate_key',
                'label' => lang('candidate_key_label'),
                'rules' => 'trim|required',
            ],
            'foreign_table' => [
                'field' => 'foreign_table',
                'label' => lang('foreign_table_label'),
                'rules' => 'trim|required',
            ],
            'foreign_key' => [
                'field' => 'foreign_key',
                'label' => lang('foreign_key_label'),
                'rules' => 'trim|required',
            ],
        ];

        //set form input
        $this->data = [
            'candidate_table' => [
                'name' => 'candidate_table',
                'id' => 'candidate_table',
                'type' => 'text',
                'class' => 'form-control',
            ],
            'candidate_key' => [
                'name' => 'candidate_key',
                'id' => 'candidate_key',
                'type' => 'text',
                'class' => 'form-control',
            ],
            'foreign_table' => [
                'name' => 'foreign_table',
                'id' => 'foreign_table',
                'type' => 'text',
                'class' => 'form-control',
            ],
            'foreign_key' => [
                'name' => 'foreign_key',
                'id' => 'foreign_key',
                'type' => 'text',
                'class' => 'form-control',
            ],
        ];
    }

    public function index()
    {
        $this->data          = [];
        $this->data['title'] = lang('list_heading');

        $filter = [];

        $filter_name     = $this->input->get('filter_name', true);
        $filter_limit    = $this->input->get('filter_limit', true);

        if (!empty($filter_name)) {
            $filter['candidate_table']   = $filter_name;
            $filter['foreign_table']   = $filter_name;
        }

        $limit         = empty($filter_limit) ? self::MANAGE_PAGE_LIMIT : $filter_limit;
        $start_index   = (isset($_GET['page']) && is_numeric($_GET['page'])) ? ($_GET['page'] - 1) : 0;
        $total_records = 0;

        //list
        list($list, $total_records) = $this->Manager->get_all_by_filter($filter, $limit, $start_index);

        //create pagination
        $settings               = $this->config->item('pagination');
        $settings['base_url']   = base_url(self::MANAGE_URL);
        $settings['total_rows'] = $total_records;
        $settings['per_page']   = $limit;

        if ($total_records > 0) {
            // use the settings to initialize the library
            $this->pagination->initialize($settings);
            // build paging links
            $this->data['pagination_links'] = $this->pagination->create_links();
        }

        $this->data['list']          = $list;
        $this->data['total_records'] = $total_records;

        $this->theme->load('manage/list', $this->data);
    }

    /**
     * Create table manage by entity
     */
    public function create_table()
    {
        try {
            $this->Manager->install();
            set_alert(lang('created_table_success'), ALERT_SUCCESS);

        } catch (Exception $e) {
            set_alert(lang('error'), ALERT_ERROR);
        }

        redirect(self::MANAGE_URL, 'refresh');
    }

    public function add()
    {
        $this->breadcrumb->add(lang('add_heading'), base_url(self::MANAGE_URL . '/add'));

        $this->data['title_heading'] = lang('add_heading');

        //set rule form
        $this->form_validation->set_rules($this->config_form);

        if ($this->form_validation->run() === TRUE) {
            $additional_data = [
                'candidate_table' => $this->input->post('candidate_table', true),
                'candidate_key'   => $this->input->post('candidate_key', true),
                'foreign_table'   => $this->input->post('foreign_table', true),
                'foreign_key'     => $this->input->post('foreign_key', true),
            ];

            if ($this->Manager->create($additional_data)) {
                set_alert(lang('add_success'), ALERT_SUCCESS);
                redirect(self::MANAGE_URL, 'refresh');
            } else {
                set_alert(lang('error'), ALERT_ERROR);
                redirect(self::MANAGE_URL . '/add', 'refresh');
            }
        }

        // display the create user form
        // set the flash data error message if there is one
        set_alert((validation_errors() ? validation_errors() : null), ALERT_ERROR);

        $this->data['candidate_table']['value'] = $this->form_validation->set_value('candidate_table');
        $this->data['candidate_key']['value']   = $this->form_validation->set_value('candidate_key');
        $this->data['foreign_table']['value']   = $this->form_validation->set_value('foreign_table');
        $this->data['foreign_key']['value']     = $this->form_validation->set_value('foreign_key');

        $this->theme->load('manage/add', $this->data);
    }

    public function edit($id = null)
    {
        $this->data['title_heading'] = lang('edit_heading');

        if (empty($id)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL, 'refresh');
        }

        $item_edit = $this->Manager->get_by_id($id);
        if (empty($item_edit)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL, 'refresh');
        }

        $this->breadcrumb->add(lang('edit_heading'), base_url(self::MANAGE_URL . '/edit/' . $id));

        //set rule form
        $this->form_validation->set_rules($this->config_form);

        if (isset($_POST) && !empty($_POST)) {
            // do we have a valid request?
//            if (valid_token() === FALSE || $id != $this->input->post('id')) {
//                set_alert(lang('error_token'), ALERT_ERROR);
//                redirect(self::MANAGE_URL, 'refresh');
//            }

            if ($this->form_validation->run() === TRUE) {
                $additional_data = [
                    'candidate_table' => $this->input->post('candidate_table', true),
                    'candidate_key'   => $this->input->post('candidate_key', true),
                    'foreign_table'   => $this->input->post('foreign_table', true),
                    'foreign_key'     => $this->input->post('foreign_key', true),
                ];

                if ($this->Manager->create($additional_data, $id)) {
                    set_alert(lang('edit_success'), ALERT_SUCCESS);
                } else {
                    set_alert(lang('error'), ALERT_ERROR);
                }
                redirect(self::MANAGE_URL . '/edit/' . $id, 'refresh');
            }
        }

        // display the create user form
        // set the flash data error message if there is one
        set_alert((validation_errors() ? validation_errors() : null), ALERT_ERROR);

        // display the edit user form
        $this->data['csrf']      = create_token();
        $this->data['item_edit'] = $item_edit;

        $this->data['candidate_table']['value'] = $this->form_validation->set_value('candidate_table', $item_edit['candidate_table']);
        $this->data['candidate_key']['value']   = $this->form_validation->set_value('candidate_key', $item_edit['candidate_key']);
        $this->data['foreign_table']['value']   = $this->form_validation->set_value('foreign_table', $item_edit['foreign_table']);
        $this->data['foreign_key']['value']     = $this->form_validation->set_value('foreign_key', $item_edit['foreign_key']);

        $this->theme->load('manage/edit', $this->data);
    }

    public function delete($id = null)
    {
        $this->breadcrumb->add(lang('delete_heading'), base_url(self::MANAGE_URL . 'delete'));

        $this->data['title_heading'] = lang('delete_heading');

        //delete
        if (isset($_POST['is_delete']) && isset($_POST['ids']) && !empty($_POST['ids'])) {
//            if (valid_token() == FALSE) {
//                set_alert(lang('error_token'), ALERT_ERROR);
//                redirect(self::MANAGE_URL, 'refresh');
//            }

            $ids         = explode(",", $this->input->post('ids', true));
            $list_delete = $this->Manager->get_list_by_ids($ids);

            if (empty($list_delete)) {
                set_alert(lang('error_empty'), ALERT_ERROR);
                redirect(self::MANAGE_URL, 'refresh');
            }

            try {
                foreach($ids as $id){
                    $this->Manager->delete($id);
                }

                set_alert(lang('delete_success'), ALERT_SUCCESS);
            } catch (Exception $e) {
                set_alert($e->getMessage(), ALERT_ERROR);
            }

            redirect(self::MANAGE_URL, 'refresh');
        }

        $delete_ids = $id;

        //truong hop chon xoa nhieu muc
        if (isset($_POST['delete_ids']) && !empty($_POST['delete_ids'])) {
            $delete_ids = $this->input->post('delete_ids', true);
        }

        if (empty($delete_ids)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL, 'refresh');
        }

        $list_delete = $this->Manager->get_list_by_ids($delete_ids);
        if (empty($list_delete)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL, 'refresh');
        }

        $this->data['csrf']        = create_token();
        $this->data['list_delete'] = $list_delete;
        $this->data['ids']         = $delete_ids;

        $this->theme->load('manage/delete', $this->data);
    }
}
