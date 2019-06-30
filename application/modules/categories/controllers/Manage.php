<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends Admin_Controller
{
    public $config_form = [];

    public $data = [];

    public function __construct()
    {
        parent::__construct();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('categories', $this->_site_lang);

        $this->load->model("categories/CategoryManager");
        $this->theme->theme('admin')
            ->title('Admin Panel')
            ->add_partial('header')
            ->add_partial('footer')
            ->add_partial('sidebar');

        //check validation
        $this->config_form = [
            'title' => [
                'field' => 'title',
                'label' => lang('title_label'),
                'rules' => 'trim|required',
                'errors' => [
                    'required' => sprintf(lang('category_validation_label'), lang('title_label')),
                ],
            ],
            'slug' => [
                'field' => 'slug',
                'label' => lang('slug_label'),
                'rules' => 'trim|required',
                'errors' => [
                    'required' => sprintf(lang('category_validation_label'), lang('slug_label')),
                ],
            ],
            'description' => [
                'field' => 'description',
                'label' => lang('description_label'),
                'rules' => 'trim|required',
                'errors' => [
                    'required' => sprintf(lang('category_validation_label'), lang('description_label')),
                ],
            ],
            'context' => [
                'field' => 'context',
                'label' => lang('context_label'),
                'rules' => 'trim',
            ],
            'precedence' => [
                'field' => 'precedence',
                'label' => lang('precedence_label'),
                'rules' => 'trim|is_natural',
                'errors' => [
                    'is_natural' => sprintf(lang('category_validation_number_label'), lang('precedence_label')),
                ],
            ],
            'parent_id' => [
                'field' => 'parent_id',
                'label' => lang('parent_label'),
                'rules' => 'trim|is_natural',
                'errors' => [
                    'is_natural' => sprintf(lang('category_validation_number_label'), lang('parent_label')),
                ],
            ],
            'published' => [
                'field' => 'published',
                'label' => lang('published_lable'),
                'rules' => 'trim|is_natural',
                'errors' => [
                    'required' => sprintf(lang('category_validation_label'), lang('published_lable')),
                    'is_natural' => sprintf(lang('category_validation_number_label'), lang('published_lable')),

                ],
            ],
        ];

        //set form input
        $this->data = [
            'title' => [
                'name' => 'title',
                'id' => 'title',
                'type' => 'text',
                'class' => 'form-control',
                'placeholder' => sprintf(lang('category_placeholder_label'), lang('title_label')),
                'oninvalid' => sprintf("this.setCustomValidity('%s')", sprintf(lang('category_placeholder_label'), lang('title_label'))),
                'required' => 'required',
            ],
            'slug' => [
                'name' => 'slug',
                'id' => 'slug',
                'type' => 'text',
                'class' => 'form-control',
            ],
            'description' => [
                'name' => 'description',
                'id' => 'description',
                'type' => 'textarea',
                'rows' => 5,
                'class' => 'form-control',
            ],
            'context' => [
                'name' => 'context',
                'id' => 'context',
                'type' => 'text',
                'class' => 'form-control',
            ],
            'precedence' => [
                'name' => 'precedence',
                'id' => 'precedence',
                'type' => 'number',
                'min' => 0,
                'class' => 'form-control',
            ],
            'parent_id' => [
                'name' => 'parent_id',
                'id' => 'parent_id',
                'type' => 'dropdown',
                'class' => 'form-control',
            ],
            'published' => [
                'name' => 'published',
                'id' => 'published',
                'type' => 'checkbox',
                'checked' => true,
            ],
        ];
    }

    /**
     * Redirect if needed, otherwise display the user list
     */
    public function index()
    {
        $this->data['title'] = lang('index_heading');

        //list
        $list = $this->CategoryManager->findAll();

        $this->data['list'] = $list;

        $this->theme->load('list', $this->data);
    }

    public function create_table()
    {
        $this->CategoryManager->install();

        exit('done');
    }

    public function add()
    {
        $this->data['title_heading'] = lang('add_heading');

        //set rule form
        $this->form_validation->set_rules($this->config_form);

        if ($this->form_validation->run() === TRUE) {
            $additional_data = [
                'title'       => $this->input->post('title'),
                'slug'        => $this->input->post('slug'),
                'description' => $this->input->post('description'),
                'context'     => $this->input->post('context'),
                'language'    => $this->input->post('language'),
                'precedence'  => $this->input->post('precedence'),
                'parent_id'   => $this->input->post('parent_id'),
                'published'   => isset($_POST['published']) ? true : false,
                'language'    => isset($_POST['language']) ? $_POST['language'] : $this->_site_lang,
            ];

            if ($this->CategoryManager->create($additional_data)) {
                set_alert(lang('add_successful'), ALERT_SUCCESS);
                redirect("categories/manage", 'refresh');
            }
        }

        // display the create user form
        // set the flash data error message if there is one
        set_alert((validation_errors() ? validation_errors() : null), ALERT_ERROR);

        $list_category = $this->CategoryManager->findAll();

        foreach ($list_category as $key => $val) {
            $list_category[$val['id']] = $val['title'];
            unset($list_category[$key]);
        }

        $this->data['title']['value']       = $this->form_validation->set_value('title');
        $this->data['slug']['value']        = $this->form_validation->set_value('slug');
        $this->data['description']['value'] = $this->form_validation->set_value('description');
        $this->data['context']['value']     = $this->form_validation->set_value('context');
        $this->data['precedence']['value']  = $this->form_validation->set_value('precedence');

        $this->data['published']['value']   = $this->form_validation->set_value('published');
        $this->data['published']['checked'] = isset($_POST['published']) ? true : false;

        $this->data['parent_id']['options']  = $list_category;
        $this->data['parent_id']['selected'] = $this->form_validation->set_value('parent_id');

        $this->theme->load('add', $this->data);
    }

    public function edit($id = null)
    {
        $this->data['title_heading'] = lang('edit_heading');

        if (empty($id)) {
            show_error(lang('error_csrf'));
        }

        $item_edit = $this->CategoryManager->findById($id);
        if (empty($item_edit)) {
            show_error(lang('error_csrf'));
        }

        //set rule form
        $this->form_validation->set_rules($this->config_form);

        if (isset($_POST) && !empty($_POST)) {
            // do we have a valid request?
            if ($this->valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
                show_error(lang('error_csrf'));
            }

            if ($this->form_validation->run() === TRUE) {
                $additional_data = [
                    'title'       => $this->input->post('title'),
                    'slug'        => $this->input->post('slug'),
                    'description' => $this->input->post('description'),
                    'context'     => $this->input->post('context'),
                    'language'    => $this->input->post('language'),
                    'precedence'  => $this->input->post('precedence'),
                    'parent_id'   => $this->input->post('parent_id'),
                    'published'   => isset($_POST['published']) ? true : false,
                    'language'    => isset($_POST['language']) ? $_POST['language'] : $this->_site_lang,
                ];

                if ($this->CategoryManager->create($additional_data, $id)) {
                    set_alert(lang('add_successful'), ALERT_SUCCESS);
                    redirect("categories/manage", 'refresh');
                }
            }
        }

        // display the create user form
        // set the flash data error message if there is one
        set_alert((validation_errors() ? validation_errors() : null), ALERT_ERROR);

        // display the edit user form
        $this->data['csrf']      = $this->get_csrf_nonce();
        $this->data['item_edit'] = $item_edit;

        $this->data['title']['value']       = $this->form_validation->set_value('title', $item_edit['title']);
        $this->data['slug']['value']        = $this->form_validation->set_value('slug', $item_edit['slug']);
        $this->data['description']['value'] = $this->form_validation->set_value('description', $item_edit['description']);
        $this->data['context']['value']     = $this->form_validation->set_value('context', $item_edit['context']);
        $this->data['precedence']['value']  = $this->form_validation->set_value('precedence', $item_edit['precedence']);
        $this->data['parent_id']['value']   = $this->form_validation->set_value('parent_id', $item_edit['parent_id']);
        $this->data['published']['value']   = $this->form_validation->set_value('published', $item_edit['published']);
        $this->data['published']['checked'] = $item_edit['published'];

        $this->theme->load('edit', $this->data);
    }
    public function get_csrf_nonce()
    {

        $this->load->helper('string');

        $key   = random_string('alnum', 8);
        $value = random_string('alnum', 20);

        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return [$key => $value];
    }
    public function valid_csrf_nonce(){
echo "<pre>";
        print_r($this->session->flashdata('csrfkey'));
print_r($_POST);
die;
        $csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
        if ($csrfkey && $csrfkey == $this->session->flashdata('csrfvalue'))
        {
            return TRUE;
        }print_r($this->session->flashdata('csrfkey'));
        return FALSE;
    }
    public function valid_csrf_nonce_()
    {echo "<pre>";
        print_r($this->session->flashdata('csrfvalue'));
        die;
        $csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
        if ($csrfkey && $csrfkey === $this->session->flashdata('csrfvalue')) {
            return TRUE;
        }

        return FALSE;
    }
}
