<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends Admin_Controller
{
    public $config_form = [];
    public $data        = [];

    CONST MANAGE_NAME       = 'photos';
    CONST MANAGE_URL        = 'photos/manage';
    CONST MANAGE_PAGE_LIMIT = PAGINATION_DEFAULF_LIMIT;

    private $_display  = [
        DISPLAY_LIST => DISPLAY_LIST,
        DISPLAY_GRID => DISPLAY_GRID,
    ];

    public function __construct()
    {
        parent::__construct();

        //set theme
        $this->theme->theme(config_item('theme_admin'))
            ->add_partial('header')
            ->add_partial('footer')
            ->add_partial('sidebar');

        $this->theme->title(config_item('site_name'))
            ->description(config_item('site_description'))
            ->keywords(config_item('site_keywords'));

        $this->lang->load('photos_manage', $this->_site_lang);

        //load model manage
        $this->load->model("photos/Photo_manager", 'Manager');
        $this->load->model("photos/Photo_album_manager", 'Album');

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_name', self::MANAGE_NAME);

        //add breadcrumb
        $this->breadcrumb->add(lang('catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('list_heading'), base_url(self::MANAGE_URL));

        //check validation
        $this->config_form = [
            'title' => [
                'field' => 'title',
                'label' => lang('text_title'),
                'rules' => 'trim|required',
                'errors' => [
                    'required' => sprintf(lang('manage_validation_label'), lang('text_title')),
                ],
            ],
            'tags' => [
                'field' => 'tags',
                'label' => lang('tags_label'),
                'rules' => 'trim',
            ],
            'is_comment' => [
                'field' => 'is_comment',
                'label' => lang('is_comment_label'),
                'rules' => 'trim',
            ],
            'album_id' => [
                'field' => 'album_id',
                'label' => lang('album_id'),
                'rules' => 'is_natural',
                'errors' => [
                    'is_natural' => sprintf(lang('manage_validation_number_label'), 'Album'),
                ],
            ],
            'sort_order' => [
                'field' => 'sort_order',
                'label' => lang('sort_order_label'),
                'rules' => 'trim|is_natural',
                'errors' => [
                    'is_natural' => sprintf(lang('manage_validation_number_label'), lang('sort_order_label')),
                ],
            ],
            'published' => [
                'field' => 'published',
                'label' => lang('published_label'),
                'rules' => 'trim',
            ],
        ];

        //set form input
        $this->data = [
            'title' => [
                'name' => 'title',
                'id' => 'title',
                'type' => 'text',
                'class' => 'form-control',
            ],
            'is_comment' => [
                'name' => 'is_comment',
                'id' => 'is_comment',
                'type' => 'checkbox',
                'checked' => true,
            ],
            'tags' => [
                'name' => 'tags',
                'id' => 'tags',
                'type' => 'text',
                'class' => 'form-control',
                'data-role' => 'tagsinput',
            ],
            'album_id' => [
                'name'  => 'album_id',
                'id'    => 'album_id',
                'type'  => 'dropdown',
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

    public function index()
    {
        $is_ajax = $this->input->is_ajax_request();
        if ($is_ajax) {
            header('content-type: application/json; charset=utf8');
        }

        //phai full quyen hoac chi duoc doc
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_read'), ALERT_ERROR);
            if ($is_ajax) {
                echo json_encode(['status' => 'redirect', 'url' => 'permissions/not_allowed']);
                return;
            }
            redirect('permissions/not_allowed');
        }

        $this->_load_css_js();

        $this->data          = [];
        $this->data['title'] = lang('list_heading');

        $filter = [];

        $filter_name     = $this->input->get('filter_name', true);
        $filter_limit    = $this->input->get('filter_limit', true);

        if (!empty($filter_name)) {
            $filter['title']   = $filter_name;
        }

        $limit         = empty($filter_limit) ? self::MANAGE_PAGE_LIMIT : $filter_limit;
        $start_index   = (isset($_GET['page']) && is_numeric($_GET['page'])) ? ($_GET['page'] - 1) : 0;
        $total_records = 0;

        //list
        list($list, $total_records) = $this->Manager->get_all_by_filter($filter, $limit, $start_index);

        $display  = $this->input->get('display', true);
        if (!empty($display) && isset($this->_display[$display])) {
            $this->data['display'] = $display;
        } else {
            $this->data['display'] = DISPLAY_GRID;
        }

        $this->data['list']   = $list;
        $this->data['paging'] = $this->get_paging_admin(base_url(self::MANAGE_URL), $total_records, $limit, $start_index);

        $list_album = $this->Album->fields('id, title')->order_by('id', 'desc')->as_dropdown('title')->get_all();
        $this->data['list_album']   = $list_album;

        if ($is_ajax) {
            echo json_encode(['status' => 'ok', 'view' => theme_view('list', $this->data, true)]);
            return;
        }

        theme_load('list', $this->data);
    }

    private function _load_css_js()
    {
        $this->theme->add_js(js_url('js/admin/photos/photos', 'common'));

        //add dropdrap upload
        add_style(css_url('js/dropzone/dropdrap', 'common'));

        //add lightbox
        add_style(css_url('js/lightbox/lightbox', 'common'));
        $this->theme->add_js(js_url('js/lightbox/lightbox', 'common'));

        //add tags
        add_style(css_url('js/tags/tagsinput', 'common'));
        $this->theme->add_js(js_url('js/tags/tagsinput', 'common'));

        $this->theme->add_js(js_url('js/image/common', 'common'));
    }

    public function add()
    {
        $is_ajax = $this->input->is_ajax_request();
        if ($is_ajax) {
            header('content-type: application/json; charset=utf8');
        } else {
            redirect(self::MANAGE_URL);
        }

        //phai full quyen hoac duoc them moi
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_add'), ALERT_ERROR);
            if ($is_ajax) {
                echo json_encode(['status' => 'redirect', 'url' => 'permissions/not_allowed']);
                return;
            }
        }

        $this->_load_css_js();

        $this->breadcrumb->add(lang('add_heading'), base_url(self::MANAGE_URL . '/add'));

        $this->data['title_heading'] = lang('add_heading');

        //set rule form
        $this->form_validation->set_rules($this->config_form);

        if (isset($_POST) && !empty($_POST)) {
            if ($this->form_validation->run() === TRUE) {
                $photo_urls = $this->input->post('photo_url', true);
                if (empty($photo_urls)) {
                    echo json_encode(['status' => 'ng', 'msg' => lang('add_album_empty_photo')]);
                    return;
                }

                foreach ($photo_urls as $key => $value) {
                    $photo = move_file_tmp($value);
                    break;
                }

                $additional_data = [
                    'title'      => $this->input->post('title', true),
                    'image'      => $photo,
                    'tags'       => $this->input->post('tags', true),
                    'album_id'   => $this->input->post('album_id', true),
                    'is_comment' => (isset($_POST['is_comment'])) ? STATUS_ON : STATUS_OFF,
                    'published'  => (isset($_POST['published']) && $_POST['published'] == true) ? STATUS_ON : STATUS_OFF,
                    'user_ip'    => get_client_ip(),
                    'user_id'    => $this->get_user_id(),
                    'ctime'      => get_date(),
                ];

                $id = $this->Manager->insert($additional_data);
                if ($id === FALSE) {
                    echo json_encode(['status' => 'ng', 'msg' => lang('error')]);
                } else {
                    echo json_encode(['status' => 'ok', 'msg' => lang('add_success'), 'id' => $id]);
                }
                return;
            } elseif ($is_ajax) {
                echo json_encode(['status' => 'ng', 'msg' => validation_errors()]);
                return;
            }
        }

        // display the create user form
        // set the flash data error message if there is one
        set_alert((validation_errors() ? validation_errors() : null), ALERT_ERROR);

        $this->data['title']['value']       = $this->form_validation->set_value('title');
        $this->data['tags']['value'] = $this->form_validation->set_value('tags');

        $this->data['published']['value']   = $this->form_validation->set_value('published', STATUS_ON);
        $this->data['published']['checked'] = true;
        $this->data['is_comment']['value']   = $this->form_validation->set_value('is_comment', STATUS_ON);
        $this->data['is_comment']['checked'] = true;

        $list_album = $this->Album->fields('id, title')->order_by('id', 'desc')->as_dropdown('title')->get_all();
        $this->data['list_album'] = $list_album;

        echo json_encode(['status' => 'ok', 'view' => theme_view('add', $this->data, true)]);
        return;
    }

    public function edit($id = null)
    {
        $is_ajax = $this->input->is_ajax_request();
        if ($is_ajax) {
            header('content-type: application/json; charset=utf8');
        } else {
            redirect(self::MANAGE_URL);
        }

        //phai full quyen hoac duoc cap nhat
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_edit'), ALERT_ERROR);
            if ($is_ajax) {
                echo json_encode(['status' => 'redirect', 'url' => 'permissions/not_allowed']);
                return;
            }
        }

        $this->data['title_heading'] = lang('edit_heading');

        if (empty($id)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL);
        }

        $item_edit = $this->Manager->get($id);
        if (empty($item_edit)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL);
        }

        $this->breadcrumb->add(lang('edit_heading'), base_url(self::MANAGE_URL . '/edit/' . $id));

        //set rule form
        $this->form_validation->set_rules($this->config_form);

        if (isset($_POST) && !empty($_POST)) {
            // do we have a valid request?
            if (valid_token() === FALSE || $id != $this->input->post('id')) {
                set_alert(lang('error_token'), ALERT_ERROR);
                if ($is_ajax) {
                    echo json_encode(['status' => 'redirect', 'url' => self::MANAGE_URL]);
                    return;
                }
            }

            $photo_urls = $this->input->post('photo_url', true);
            if (empty($photo_urls)) {
                echo json_encode(['status' => 'ng', 'msg' => lang('add_album_empty_photo')]);
                return;
            }
            foreach ($photo_urls as $key => $value) {
                $photo = isset($photo_urls[$id]) ? $value : move_file_tmp($value);
                break;
            }

            if ($this->form_validation->run() === TRUE) {
                $edit_data = [
                    'title'      => $this->input->post('title', true),
                    'image'      => $photo,
                    'tags'       => $this->input->post('tags', true),
                    'album_id'   => $this->input->post('album_id', true),
                    'is_comment' => (isset($_POST['is_comment'])) ? STATUS_ON : STATUS_OFF,
                    'published'  => (isset($_POST['published']) && $_POST['published'] == true) ? STATUS_ON : STATUS_OFF,
                    'user_ip'    => get_client_ip(),
                    'user_id'    => $this->get_user_id(),
                ];

                if ($this->Manager->update($edit_data, $id) !== FALSE) {
                    echo json_encode(['status' => 'ok', 'msg' => lang('edit_success')]);
                } else {
                    set_alert(lang('error'), ALERT_ERROR);
                    echo json_encode(['status' => 'ng', 'msg' => lang('error')]);
                }
                return;
            }
        }

        // display the create user form
        // set the flash data error message if there is one
        set_alert((validation_errors() ? validation_errors() : null), ALERT_ERROR);

        // display the edit user form
        $this->data['csrf']      = create_token();
        $this->data['item_edit'] = $item_edit;

        $this->data['title']['value']       = $this->form_validation->set_value('title', $item_edit['title']);
        $this->data['tags']['value'] = $this->form_validation->set_value('tags', $item_edit['tags']);

        $this->data['published']['value']   = $this->form_validation->set_value('published', $item_edit['published']);
        $this->data['published']['checked'] = ($item_edit['published'] == STATUS_ON) ? true : false;
        $this->data['is_comment']['value']   = $this->form_validation->set_value('is_comment', $item_edit['is_comment']);
        $this->data['is_comment']['checked'] = ($item_edit['is_comment'] == STATUS_ON) ? true : false;

        $list_album = $this->Album->fields('id, title')->order_by('id', 'desc')->as_dropdown('title')->get_all();
        $this->data['list_album'] = $list_album;

        echo json_encode(['status' => 'ok', 'view' => theme_view('edit', $this->data, true)]);
        return;
    }

    public function delete($id = null)
    {
        //phai full quyen hoac duowc xoa
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_delete'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }

        $this->breadcrumb->add(lang('delete_heading'), base_url(self::MANAGE_URL . 'delete'));

        $this->data['title_heading'] = lang('delete_heading');

        //delete
        if (isset($_POST['is_delete']) && isset($_POST['ids']) && !empty($_POST['ids'])) {
            if (valid_token() == FALSE) {
                set_alert(lang('error_token'), ALERT_ERROR);
                redirect(self::MANAGE_URL);
            }

            $ids = $this->input->post('ids', true);
            $ids = (is_array($ids)) ? $ids : explode(",", $ids);

            $list_delete = $this->Manager->where('id', $ids)->get_all();
            if (empty($list_delete)) {
                set_alert(lang('error_empty'), ALERT_ERROR);
                redirect(self::MANAGE_URL);
            }

            try {
                foreach($ids as $id){
                    $this->Manager->delete($id);
                }

                set_alert(lang('delete_success'), ALERT_SUCCESS);
            } catch (Exception $e) {
                set_alert($e->getMessage(), ALERT_ERROR);
            }

            redirect(self::MANAGE_URL);
        }

        $delete_ids = $id;

        //truong hop chon xoa nhieu muc
        if (isset($_POST['delete_ids']) && !empty($_POST['delete_ids'])) {
            $delete_ids = $this->input->post('delete_ids', true);
        }

        if (empty($delete_ids)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL);
        }

        $delete_ids  = is_array($delete_ids) ? $delete_ids : explode(',', $delete_ids);
        $list_delete = $this->Manager->where('id', $delete_ids)->get_all();

        if (empty($list_delete)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL);
        }

        $this->data['csrf']        = create_token();
        $this->data['list_delete'] = $list_delete;
        $this->data['ids']         = $delete_ids;

        theme_load('delete', $this->data);
    }

    public function do_upload()
    {
        header('content-type: application/json; charset=utf8');

        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $uploads = [];
        // Count total files

        if (!isset($_FILES) && empty($_FILES['files'])) {
            echo json_encode(['status' => 'ng', 'msg' => lang('error_empty')]);
            return;
        }

        $this->load->helper('string');

        $is_multi = false;
        if (isset($_POST['is_multi']) && $_POST['is_multi'] == true) {
            $is_multi = true;
        }

        $countfiles = count($_FILES['files']['name']);

        // Looping all files
        for ($i = 0; $i < $countfiles; $i++) {
            if (!empty($_FILES['files']['name'][$i])) {

                // Define new $_FILES array - $_FILES['file']
                $_FILES['file']['name']     = $_FILES['files']['name'][$i];
                $_FILES['file']['type']     = $_FILES['files']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                $_FILES['file']['error']    = $_FILES['files']['error'][$i];
                $_FILES['file']['size']     = $_FILES['files']['size'][$i];

                $upload_tmp           = upload_file('file', 'tmp/photos');
                $upload_tmp['key_id'] = time() . '_' . random_string('alnum', 4) . '_' . $i;

                //luu tmp truoc, khi insert data thi move file va delete no
                $uploads[] = $upload_tmp;

                if($is_multi == false) {
                    break;
                }
            }
        }

        $data['uploads'] = $uploads;

        $data['is_multi'] = $is_multi;

        $return = $this->theme->view('inc/list_image_upload', $data , true);

        echo json_encode(['image' => $return]);
        return;
    }
}
