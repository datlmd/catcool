<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Albums_manage extends Admin_Controller
{
    protected $errors = [];

    CONST MANAGE_ROOT = 'photos/albums_manage';
    CONST MANAGE_URL  = 'photos/albums_manage';

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
        $this->lang->load('photos_albums_manage', $this->_site_lang);

        //load model manage
        $this->load->model("photos/Photo_album", 'Photo_album');
        $this->load->model("photos/Photo_album_description", 'Photo_album_description');
        $this->load->model("photos/Photo", 'Photo');
        $this->load->model("photos/Photo_description", 'Photo_description');

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('module_photo'), base_url("photos/manage"));
        $this->breadcrumb->add(lang('heading_title'), base_url(self::MANAGE_URL));
    }

    public function index()
    {
        $this->theme->title(lang("heading_title"));

        //phai full quyen hoac chi duoc doc
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_read'), ALERT_ERROR);
            if ($this->input->is_ajax_request()) {
                json_output(['status' => 'redirect', 'url' => 'permissions/not_allowed']);
            }
            redirect('permissions/not_allowed');
        }

        $this->_load_css_js();

        $display = $this->input->get('display', true);
        $filter  = $this->input->get('filter');

        if (!empty($filter)) {
            $data['filter_active'] = true;
        }

        $limit              = empty($this->input->get('filter_limit', true)) ? get_pagination_limit(true) : $this->input->get('filter_limit', true);
        $start_index        = (isset($_GET['page']) && is_numeric($_GET['page'])) ? ($_GET['page'] - 1) * $limit : 0;
        list($list, $total) = $this->Photo_album->get_all_by_filter($filter, $limit, $start_index);

        $data['display'] = !empty($display) && isset($this->_display[$display]) ? $display : DISPLAY_GRID;
        $data['list']    = $list;
        $data['paging']  = $this->get_paging_admin(base_url(self::MANAGE_URL), $total, $limit, $this->input->get('page'));

        if ($this->input->is_ajax_request()) {
            json_output(['status' => 'ok', 'view' => theme_view('albums/list', $data, true)]);
        }

        set_last_url();

        theme_load('albums/list', $data);
    }

    public function add()
    {
        $is_ajax = $this->input->is_ajax_request();

        //phai full quyen hoac duoc them moi
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_add'), ALERT_ERROR);
            if ($this->input->is_ajax_request()) {
                json_output(['status' => 'redirect', 'url' => 'permissions/not_allowed']);
            }
            redirect('permissions/not_allowed');
        }

        if (isset($_POST) && !empty($_POST)) {
            if ($this->validate_form() === TRUE) {
                $photo_urls = $this->input->post('photo_url', true);
                if (empty($photo_urls)) {
                    if ($is_ajax) {
                        json_output(['status' => 'ng', 'msg' => lang('error_add_album_empty_photo')]);
                    }
                    set_alert(lang('error_add_album_empty_photo'), ALERT_ERROR);
                    redirect(self::MANAGE_URL . '/add');
                }

                $add_data = [
                    'user_id'    => $this->get_user_id(),
                    'user_ip'    => get_client_ip(),
                    'is_comment' => (isset($_POST['is_comment'])) ? STATUS_ON : STATUS_OFF,
                    'published'  => (isset($_POST['published'])) ? STATUS_ON : STATUS_OFF,
                    'sort_order' => $this->input->post('sort_order', true),
                    'ctime'      => get_date(),
                ];

                $id = $this->Photo_album->insert($add_data);
                if ($id === FALSE) {
                    if ($is_ajax) {
                        json_output(['status' => 'ng', 'msg' => lang('error')]);
                    }
                    set_alert(lang('error'), ALERT_ERROR);
                    redirect(self::MANAGE_URL . '/add');
                }

                $add_data_description = $this->input->post('manager_description');
                foreach (get_list_lang() as $key => $value) {
                    $add_data_description[$key]['language_id'] = $key;
                    $add_data_description[$key]['album_id']    = $id;
                }
                $this->Photo_album_description->insert($add_data_description);

                $album_image = '';
                foreach ($photo_urls as $key => $value) {
                    $photo = move_file_tmp($value);
                    if($photo === FALSE) {
                        continue;
                    }

                    if (empty($album_image)) {
                        $album_image = $photo;
                    }

                    $add_photo = [
                        'image'    => $photo,
                        'album_id' => $id,
                        'user_id'  => $this->get_user_id(),
                        'user_ip'  => get_client_ip(),
                        'ctime'    => get_date(),
                    ];
                    $photo_id = $this->Photo->insert($add_photo);

                    $photo_data_description = $this->input->post('manager_description');// set tam theo thong tin cua album
                    foreach (get_list_lang() as $key => $value) {
                        $photo_data_description[$key]['language_id'] = $key;
                        $photo_data_description[$key]['photo_id']    = $photo_id;
                    }
                    $this->Photo_description->insert($photo_data_description);
                }

                $this->Photo_album->update(['image' => $album_image], $id);

                if ($is_ajax) {
                    json_output(['status' => 'ok', 'msg' => lang('text_add_success'), 'id' => $id]);
                }

                set_alert(lang('text_add_success'), ALERT_SUCCESS);
                redirect(self::MANAGE_URL);
            } elseif ($is_ajax) {
                json_output(['status' => 'ng', 'msg' => validation_errors()]);
            }
        }

        $this->get_form();
    }

    private function _load_css_js()
    {
        $this->theme->add_js(js_url('js/admin/photos/photos', 'common'));

        //add dropdrap upload
        add_style(css_url('js/dropzone/dropdrap', 'common'));

        $this->theme->add_js(js_url('vendor/shortable-nestable/Sortable.min', 'common'));

        //add tags
        add_style(css_url('js/tags/tagsinput', 'common'));
        $this->theme->add_js(js_url('js/tags/tagsinput', 'common'));
    }

    public function edit($id = null)
    {
        $is_ajax = $this->input->is_ajax_request();

        //phai full quyen hoac duoc cap nhat
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_edit'), ALERT_ERROR);

            if ($is_ajax) {
                json_output(['status' => 'redirect', 'url' => 'permissions/not_allowed']);
            }
            redirect('permissions/not_allowed');
        }

        if (empty($id)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            if ($is_ajax) {
                json_output(['status' => 'redirect', 'url' => self::MANAGE_URL]);
            }
            redirect(self::MANAGE_URL);
        }

        if (isset($_POST) && !empty($_POST)) {
            if ($this->validate_form() === FALSE) {
                json_output(['status' => 'ng', 'msg' => validation_errors()]);
            }

            // do we have a valid request?
            if (valid_token() === FALSE || $id != $this->input->post('album_id')) {
                set_alert(lang('error_token'), ALERT_ERROR);
                if ($is_ajax) {
                    json_output(['status' => 'redirect', 'url' => self::MANAGE_URL]);
                }
                redirect(self::MANAGE_URL);
            }

            $photo_urls  = $this->input->post('photo_url', true);
            $sort_images = [];
            $sort_step   = 1;

            if (!empty($photo_urls)) {
                foreach ($photo_urls as $key => $value) {
                    $sort_images[$key] = $sort_step;
                    $sort_step++;
                }
            }

            $list_photo = $this->Photo->get_photo_by_album($id, ['sort_order' => 'ASC']);

            $list_photo_delete = $list_photo;
            $list_photo_update = [];
            $album_image       = '';

            if (!empty($list_photo)) {
                foreach ($list_photo as $key => $value) {
                    //check hinh da ton tai trong db ko
                    if (isset($photo_urls[$value['photo_id']])) {
                        unset($photo_urls[$value['photo_id']]);
                        unset($list_photo_delete[$key]);

                        $list_photo_update[] = $value;
                    }
                }
            }

            if (!empty($photo_urls)) {

                foreach ($photo_urls as $key => $value) {
                    $photo = move_file_tmp($value);
                    if ($photo === FALSE) {
                        continue;
                    }

                    //add hinh dau tien cho album
                    if (empty($album_image) && $sort_images[$key] == 1) {
                        $album_image = $photo;
                    }

                    $add_photo = [
                        'image' => $photo,
                        'album_id' => $id,
                        'sort_order' => $sort_images[$key],
                        'user_id' => $this->get_user_id(),
                        'user_ip' => get_client_ip(),
                        'ctime' => get_date(),
                    ];
                    $photo_id = $this->Photo->insert($add_photo);

                    $photo_data_description = $this->input->post('manager_description');// set tam theo thong tin cua album
                    foreach (get_list_lang() as $key => $value) {
                        $photo_data_description[$key]['language_id'] = $key;
                        $photo_data_description[$key]['photo_id'] = $photo_id;
                    }
                    $this->Photo_description->insert($photo_data_description);
                }
            }

            if (!empty($list_photo_update)) {
                foreach($list_photo_update as $key => $value) {
                    $edit_photo = [
                        'sort_order' => $sort_images[$value['photo_id']],
                        'user_id'    => $this->get_user_id(),
                        'user_ip'    => get_client_ip(),
                    ];
                    $this->Photo->update($edit_photo, $value['photo_id']);

                    //add hinh dau tien cho album
                    if (empty($album_image) && $sort_images[$value['photo_id']] == 1) {
                        $album_image = $value['image'];
                    }
                }
            }

            // xoa hinh khong ton tai trong db
            if (!empty($list_photo_delete)) {
                foreach($list_photo_delete as $value) {
                    $this->Photo->delete($value['photo_id']);
                    delete_file_upload($value['image']);
                }
            }

            $edit_data = [
                'image'      => $album_image,
                'sort_order' => $this->input->post('sort_order', true),
                'is_comment' => (isset($_POST['is_comment'])) ? STATUS_ON : STATUS_OFF,
                'user_id'    => $this->get_user_id(),
                'user_ip'    => get_client_ip(),
                'published'  => (isset($_POST['published'])) ? STATUS_ON : STATUS_OFF,
                'mtime'      => get_date(),
            ];
            if ($this->Photo_album->update($edit_data, $id) === FALSE) {
                if ($is_ajax) {
                    json_output(['status' => 'ng', 'msg' => lang('error')]);
                }
                set_alert(lang('error'), ALERT_ERROR);
            }

            $edit_data_description = $this->input->post('manager_description');
            foreach (get_list_lang() as $key => $value) {
                $edit_data_description[$key]['language_id'] = $key;
                $edit_data_description[$key]['album_id']    = $id;

                if (!empty($this->Photo_album_description->get(['album_id' => $id, 'language_id' => $key]))) {
                    $this->Photo_album_description->where('album_id', $id)->update($edit_data_description[$key], 'language_id');
                } else {
                    $this->Photo_album_description->insert($edit_data_description[$key]);
                }
            }

            if ($is_ajax) {
                json_output(['status' => 'ok', 'msg' => lang('text_edit_success'), 'id' => $id, 'token' => create_input_token(create_token())]);
            }

            set_alert(lang('text_edit_success'), ALERT_SUCCESS);
            redirect(self::MANAGE_URL . '/edit/' . $id);
        }

        $this->get_form($id);
    }

    protected function get_form($id = null)
    {
        $this->_load_css_js();
        $data['list_lang'] = get_list_lang();
        $data['is_ajax']   = $this->input->is_ajax_request();

        //edit
        if (!empty($id) && is_numeric($id)) {
            $data['text_form']   = lang('text_edit');
            $data['text_submit'] = lang('button_save');

            $data_form = $this->Photo_album->with_details()->get($id);
            if (empty($data_form)) {
                set_alert(lang('error_empty'), ALERT_ERROR);
                if ($this->input->is_ajax_request()) {
                    json_output(['status' => 'redirect', 'url' => self::MANAGE_URL]);
                }
                redirect(self::MANAGE_URL);
            }
            $data_form = format_data_lang_id($data_form);

            $list_photo = $this->Photo->get_photo_by_album($id, ['sort_order' => 'ASC']);
            $data['list_photo'] = $list_photo;

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
        if ($this->input->is_ajax_request()) {
            json_output(['status' => 'ok', 'view' => theme_view('albums/form', $data, true)]);
        }

        $this->theme->title($data['text_form']);
        $this->breadcrumb->add($data['text_form'], base_url(self::MANAGE_URL));

        theme_load('albums/form', $data);
    }

    protected function validate_form()
    {
        foreach(get_list_lang() as $key => $value) {
            $this->form_validation->set_rules(sprintf('manager_description[%s][name]', $key), lang('text_name') . ' (' . $value['name']  . ')', 'trim|required');
        }
        $is_validation = $this->form_validation->run();
        $this->errors  = $this->form_validation->error_array();

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
                set_alert(lang('error_token'), ALERT_ERROR);
                json_output(['status' => 'ng', 'msg' => lang('error_token')]);
            }

            $ids = $this->input->post('ids', true);
            $ids = (is_array($ids)) ? $ids : explode(",", $ids);

            $list_delete = $this->Photo_album->get_list_full_detail($ids);
            if (empty($list_delete)) {
                json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
            }

            try {
                foreach($list_delete as $value){
                    delete_file_upload($value['image']);
                    $this->Photo_album->delete($value['album_id']);
                    $this->Photo_album_description->delete($value['album_id']);
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
        $list_delete = $this->Photo_album->get_list_full_detail($delete_ids);
        if (empty($list_delete)) {
            json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
        }

        $data['csrf']        = create_token();
        $data['list_delete'] = $list_delete;
        $data['ids']         = $delete_ids;

        json_output(['data' => theme_view('albums/delete', $data, true)]);
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
        $item_edit = $this->Photo_album->get($id);
        if (empty($item_edit)) {
            json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
        }

        $item_edit['published'] = !empty($_POST['published']) ? STATUS_ON : STATUS_OFF;
        if (!$this->Photo_album->update($item_edit, $id)) {
            $data = ['status' => 'ng', 'msg' => lang('error_json')];
        } else {
            $data = ['status' => 'ok', 'msg' => lang('text_published_success')];
        }

        json_output($data);
    }
}
