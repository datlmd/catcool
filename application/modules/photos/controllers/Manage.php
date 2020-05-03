<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends Admin_Controller
{
    protected $errors = [];

    CONST MANAGE_ROOT       = 'photos/manage';
    CONST MANAGE_URL        = 'photos/manage';
    CONST MANAGE_PAGE_LIMIT = PAGINATION_DEFAULF_LIMIT;

    private $_display = [
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

        $this->lang->load('photos_manage', $this->_site_lang);

        //load model manage
        $this->load->model("photos/Photo", 'Photo');
        $this->load->model("photos/Photo_description", 'Photo_description');
        $this->load->model("photos/Photo_album", 'Album');
        $this->load->model("photos/Photo_album_description", 'Album_description');
        

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('heading_title'), base_url(self::MANAGE_URL));
    }

    public function index()
    {
        $this->theme->title(lang("heading_title"));

        $is_ajax = $this->input->is_ajax_request();

        //phai full quyen hoac chi duoc doc
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_read'), ALERT_ERROR);
            if ($is_ajax) {
                json_output(['status' => 'redirect', 'url' => 'permissions/not_allowed']);
            }
            redirect('permissions/not_allowed');
        }

        $this->_load_css_js();

        $filter = $this->input->get('filter');
        if (!empty($filter)) {
            $data['filter_active'] = true;
        }

        $limit       = empty($this->input->get('filter_limit', true)) ? self::MANAGE_PAGE_LIMIT : $this->input->get('filter_limit', true);
        $start_index = (isset($_GET['page']) && is_numeric($_GET['page'])) ? ($_GET['page'] - 1) * $limit : 0;

        //list
        list($list, $total_records) = $this->Photo->get_all_by_filter($filter, $limit, $start_index);

        $display = $this->input->get('display', true);
        if (!empty($display) && isset($this->_display[$display])) {
            $data['display'] = $display;
        } else {
            $data['display'] = DISPLAY_GRID;
        }

        $data['list']   = $list;
        $data['paging'] = $this->get_paging_admin(base_url(self::MANAGE_URL), $total_records, $limit, $this->input->get('page'));

        list($list_album, $total_album) = $this->Album->get_all_by_filter();
        $data['list_album'] = format_dropdown($list_album, 'album_id');

        if ($is_ajax) {
            json_output(['status' => 'ok', 'view' => theme_view('list', $data, true)]);
        }

        set_last_url();

        theme_load('list', $data);
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
    }

    public function add()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        //phai full quyen hoac duoc them moi
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_add'), ALERT_ERROR);
            json_output(['status' => 'redirect', 'url' => 'permissions/not_allowed']);
        }

        if (isset($_POST) && !empty($_POST)) {
            if ($this->validate_form() === FALSE) {
                json_output(['status' => 'ng', 'msg' => validation_errors()]);
            }
            $photo_urls = $this->input->post('photo_url', true);
            if (empty($photo_urls)) {
                json_output(['status' => 'ng', 'msg' => lang('select_photos')]);
            }

            foreach ($photo_urls as $key => $value) {
                $photo = move_file_tmp($value);
                break;
            }

            $add_data = [
                'image'      => $photo,
                'tags'       => $this->input->post('tags', true),
                'album_id'   => $this->input->post('album_id', true),
                'sort_order'   => $this->input->post('sort_order', true),
                'is_comment' => (isset($_POST['is_comment'])) ? STATUS_ON : STATUS_OFF,
                'published'  => (isset($_POST['published'])) ? STATUS_ON : STATUS_OFF,
                'user_ip'    => get_client_ip(),
                'user_id'    => $this->get_user_id(),
                'ctime'      => get_date(),
            ];

            $id = $this->Photo->insert($add_data);
            if ($id === FALSE) {
                json_output(['status' => 'ng', 'msg' => lang('error')]);
            }

            $add_data_description = $this->input->post('manager_description');
            foreach (get_list_lang() as $key => $value) {
                $add_data_description[$key]['language_id'] = $key;
                $add_data_description[$key]['photo_id']    = $id;
            }
            $this->Photo_description->insert($add_data_description);

            json_output(['status' => 'ok', 'msg' => lang('text_add_success'), 'id' => $id]);
        }

        $this->get_form();
    }

    public function edit($id = null)
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        //phai full quyen hoac duoc cap nhat
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_edit'), ALERT_ERROR);
            json_output(['status' => 'redirect', 'url' => 'permissions/not_allowed']);
        }

        if (empty($id)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            json_output(['status' => 'redirect', 'url' => self::MANAGE_URL]);
        }

        if (isset($_POST) && !empty($_POST)) {
            if ($this->validate_form() === FALSE) {
                json_output(['status' => 'ng', 'msg' => validation_errors()]);
            }
            // do we have a valid request?
            if (valid_token() === FALSE || $id != $this->input->post('photo_id')) {
                set_alert(lang('error_token'), ALERT_ERROR);
                json_output(['status' => 'redirect', 'url' => self::MANAGE_URL]);
            }

            $photo_urls = $this->input->post('photo_url', true);
            if (empty($photo_urls)) {
                json_output(['status' => 'ng', 'msg' => lang('select_photos')]);
            }
            foreach ($photo_urls as $key => $value) {
                $photo = isset($photo_urls[$id]) ? $value : move_file_tmp($value);
                break;
            }

            $edit_data = [
                'image'      => $photo,
                'tags'       => $this->input->post('tags', true),
                'album_id'   => $this->input->post('album_id', true),
                'sort_order'   => $this->input->post('sort_order', true),
                'is_comment' => (isset($_POST['is_comment'])) ? STATUS_ON : STATUS_OFF,
                'published'  => (isset($_POST['published'])) ? STATUS_ON : STATUS_OFF,
                'user_ip'    => get_client_ip(),
                'user_id'    => $this->get_user_id(),
                'mtime'      => get_date(),
            ];

            if ($this->Photo->update($edit_data, $id) === FALSE) {
                set_alert(lang('error'), ALERT_ERROR);
                json_output(['status' => 'ng', 'msg' => lang('error')]);
            }

            $edit_data_description = $this->input->post('manager_description');
            foreach (get_list_lang() as $key => $value) {
                $edit_data_description[$key]['language_id'] = $key;
                $edit_data_description[$key]['photo_id']    = $id;

                if (!empty($this->Photo_description->get(['photo_id' => $id, 'language_id' => $key]))) {
                    $this->Photo_description->where('photo_id', $id)->update($edit_data_description[$key], 'language_id');
                } else {
                    $this->Photo_description->insert($edit_data_description[$key]);
                }
            }

            json_output(['status' => 'ok', 'msg' => lang('text_edit_success'), 'token' => create_input_token(create_token())]);
        }

        $this->get_form($id);
    }

    protected function get_form($id = null)
    {
        $data['list_lang'] = get_list_lang();
        //edit
        if (!empty($id) && is_numeric($id)) {
            $data['text_form']   = lang('text_edit');
            $data['text_submit'] = lang('button_save');

            $data_form = $this->Photo->with_details()->get($id);
            if (empty($data_form)) {
                set_alert(lang('error_empty'), ALERT_ERROR);
                json_output(['status' => 'redirect', 'url' => self::MANAGE_URL]);
            }
            $data_form = format_data_lang_id($data_form);

            list($list_album, $total_album) = $this->Album->get_all_by_filter();
            $data['list_album'] = format_dropdown($list_album, 'album_id');

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

        list($list_album, $total_album) = $this->Album->get_all_by_filter();
        $data['list_album'] = format_dropdown($list_album, 'album_id');

        $this->theme->title($data['text_form']);
        $this->breadcrumb->add($data['text_form'], base_url(self::MANAGE_URL));

        json_output(['status' => 'ok', 'view' => theme_view('form', $data, true)]);
    }

    protected function validate_form()
    {
        foreach(get_list_lang() as $key => $value) {
            $this->form_validation->set_rules(sprintf('manager_description[%s][name]', $key), lang('text_name') . ' (' . $value['name']  . ')', 'trim|required');
        }
        $is_validation = $this->form_validation->run();
        $this->errors  = $this->form_validation->error_array();

        if (!empty($this->errors)) {
            return FALSE;
        }

        return $is_validation;
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

            $list_delete = $this->Photo->get_list_full_detail($ids);
            if (empty($list_delete)) {
                json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
            }

            try {
                foreach($list_delete as $value) {
                    delete_file_upload($value['image']);
                    $this->Photo->delete($value['photo_id']);
                    $this->Photo_description->delete($value['photo_id']);
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
            json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
        }

        $delete_ids  = is_array($delete_ids) ? $delete_ids : explode(',', $delete_ids);
        $list_delete = $this->Photo->get_list_full_detail($delete_ids);
        if (empty($list_delete)) {
            json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
        }

        $data['csrf']        = create_token();
        $data['list_delete'] = $list_delete;
        $data['ids']         = $delete_ids;

        json_output(['data' => theme_view('delete', $data, true)]);
    }

    public function do_upload()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        $uploads = [];

        if (!isset($_FILES) && empty($_FILES['files'])) {
            json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
        }

        $this->load->helper('string');

        //xoa file neu da expired sau 2 gio
        delete_file_upload_tmp();

        $image_url = '';
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
                    $image_url = $upload_tmp['image'];
                    break;
                }
            }
        }
        $data['uploads']  = $uploads;
        $data['is_multi'] = $is_multi;

        $return = $this->theme->view('inc/list_image_upload', $data , true);

        json_output(['image' => $return, 'image_url' => $image_url]);
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
        $item_edit = $this->Photo->get($id);
        if (empty($item_edit)) {
            json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
        }

        $item_edit['published'] = !empty($_POST['published']) ? STATUS_ON : STATUS_OFF;
        if (!$this->Photo->update($item_edit, $id)) {
            $data = ['status' => 'ng', 'msg' => lang('error_json')];
        } else {
            $data = ['status' => 'ok', 'msg' => lang('text_published_success')];
        }

        json_output($data);
    }
}
