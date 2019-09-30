<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends Admin_Controller
{
    public $config_form = [];
    public $data        = [];

    CONST MANAGE_NAME       = 'photos/albums';
    CONST MANAGE_URL        = 'photos/albums/manage';
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

        $this->lang->load('albums_manage', $this->_site_lang);

        //load model manage
        $this->load->model("photos/Photo_album_manager", 'Manager');
        $this->load->model("photos/Photo_manager", 'Photo');

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
                'label' => lang('title_label'),
                'rules' => 'trim|required',
                'errors' => [
                    'required' => sprintf(lang('manage_validation_label'), lang('title_label')),
                ],
            ],
            'description' => [
                'field' => 'description',
                'label' => lang('description_label'),
                'rules' => 'trim',
            ],
            'is_comment' => [
                'field' => 'is_comment',
                'label' => lang('is_comment_label'),
                'rules' => 'trim',
            ],
            'precedence' => [
                'field' => 'precedence',
                'label' => lang('precedence_label'),
                'rules' => 'trim|is_natural',
                'errors' => [
                    'is_natural' => sprintf(lang('manage_validation_number_label'), lang('precedence_label')),
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
            'description' => [
                'name' => 'description',
                'id' => 'description',
                'type' => 'textarea',
                'rows' => 5,
                'class' => 'form-control',
            ],
            'is_comment' => [
                'name' => 'is_comment',
                'id' => 'is_comment',
                'type' => 'checkbox',
                'checked' => true,
            ],
            'precedence' => [
                'name' => 'precedence',
                'id' => 'precedence',
                'type' => 'number',
                'min' => 0,
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

        $filter_name  = $this->input->get('filter_name', true);
        $filter_limit = $this->input->get('filter_limit', true);

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

        set_last_url();

        if ($is_ajax) {
            echo json_encode(['status' => 'ok', 'view' => theme_view('albums/list', $this->data, true)]);
            return;
        }

        theme_load('albums/list', $this->data);
    }

    public function add()
    {
        $is_ajax = $this->input->is_ajax_request();
        if ($is_ajax) {
            header('content-type: application/json; charset=utf8');
        }

        //phai full quyen hoac duoc them moi
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_add'), ALERT_ERROR);
            if ($is_ajax) {
                echo json_encode(['status' => 'redirect', 'url' => 'permissions/not_allowed']);
                return;
            }

            redirect('permissions/not_allowed');
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
                    if ($is_ajax) {
                        echo json_encode(['status' => 'ng', 'msg' => lang('add_album_empty_photo')]);
                        return;
                    }

                    set_alert(lang('add_album_empty_photo'), ALERT_ERROR);
                    redirect(self::MANAGE_URL . '/add');
                }

                $additional_data = [
                    'title'       => $this->input->post('title', true),
                    'description' => $this->input->post('description', true),
                    'is_comment'  => (isset($_POST['is_comment']) && $_POST['is_comment'] == true) ? STATUS_ON : STATUS_OFF,
                    'user_id'     => $this->get_user_id(),
                    'user_ip'     => get_client_ip(),
                    'published'   => (isset($_POST['published']) && $_POST['published'] == true) ? STATUS_ON : STATUS_OFF,
                    'ctime'       => get_date(),
                ];

                $id = $this->Manager->insert($additional_data);
                if ($id === FALSE) {
                    if ($is_ajax) {
                        echo json_encode(['status' => 'ng', 'msg' => lang('error')]);
                        return;
                    }

                    set_alert(lang('error'), ALERT_ERROR);
                    redirect(self::MANAGE_URL . '/add');
                }

                $album_image = '';
                foreach ($photo_urls as $key => $value) {
                    $photo = move_file_tmp($value);
                    if($photo === FALSE) {
                        continue;
                    }

                    if (empty($album_image)) {
                        $album_image = $photo;
                    }

                    $photo_title = $this->input->post($key, true);
                    $add_photo = [
                        'title'    => $photo_title,
                        'image'    => $photo,
                        'album_id' => $id,
                        'user_id'  => $this->get_user_id(),
                        'user_ip'  => get_client_ip(),
                        'ctime'    => get_date(),
                    ];
                    $this->Photo->insert($add_photo);
                }

                $this->Manager->update(['image' => $album_image], $id);

                if ($is_ajax) {
                    echo json_encode(['status' => 'ok', 'msg' => lang('edit_success'), 'id' => $id]);
                    return;
                }

                set_alert(lang('add_success'), ALERT_SUCCESS);
                redirect(self::MANAGE_URL);
            } elseif ($is_ajax) {
                echo json_encode(['status' => 'ng', 'msg' => validation_errors()]);
                return;
            }
        }

        // display the create user form
        // set the flash data error message if there is one
        set_alert((validation_errors() ? validation_errors() : null), ALERT_ERROR);

        $this->data['title']['value']       = $this->form_validation->set_value('title');
        $this->data['description']['value'] = $this->form_validation->set_value('description');
        $this->data['published']['value']   = $this->form_validation->set_value('published', STATUS_ON);
        $this->data['published']['checked'] = true;

        $this->data['is_comment']['value']   = $this->form_validation->set_value('is_comment', STATUS_ON);
        $this->data['is_comment']['checked'] = true;

        if ($is_ajax) {
            echo json_encode(['status' => 'ok', 'view' => theme_view('albums/add', $this->data, true)]);
            return;
        }

        theme_load('albums/add', $this->data);
    }

    private function _load_css_js()
    {
        $this->theme->add_js(js_url('js/admin/photos/photos', 'common'));

        //add dropdrap upload
        add_style(css_url('js/dropzone/dropdrap', 'common'));

        //add lightbox
        add_style(css_url('js/lightbox/lightbox', 'common'));
        $this->theme->add_js(js_url('js/lightbox/lightbox', 'common'));

        $this->theme->add_js(js_url('vendor/shortable-nestable/jquery.nestable', 'common'));
        $this->theme->add_js(js_url('vendor/shortable-nestable/Sortable.min', 'common'));

    }

    public function edit($id = null)
    {
        $is_ajax = $this->input->is_ajax_request();
        if ($is_ajax) {
            header('content-type: application/json; charset=utf8');
        }

        //phai full quyen hoac duoc cap nhat
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_edit'), ALERT_ERROR);

            if ($is_ajax) {
                echo json_encode(['status' => 'redirect', 'url' => 'permissions/not_allowed']);
                return;
            }

            redirect('permissions/not_allowed');
        }

        $this->_load_css_js();

        $this->data['title_heading'] = lang('edit_heading');

        if (empty($id)) {
            set_alert(lang('error_empty'), ALERT_ERROR);

            if ($is_ajax) {
                echo json_encode(['status' => 'redirect', 'url' => self::MANAGE_URL]);
                return;
            }

            redirect(self::MANAGE_URL);
        }

        $item_edit = $this->Manager->get($id);
        if (empty($item_edit)) {
            set_alert(lang('error_empty'), ALERT_ERROR);

            if ($is_ajax) {
                echo json_encode(['status' => 'redirect', 'url' => self::MANAGE_URL]);
                return;
            }

            redirect(self::MANAGE_URL);
        }

        $this->breadcrumb->add(lang('edit_heading'), base_url(self::MANAGE_URL . '/edit/' . $id));

        //set rule form
        $this->form_validation->set_rules($this->config_form);

        $list_photo = $this->Photo->get_phot_by_album($id, ['precedence' => 'ASC']);

        if (isset($_POST) && !empty($_POST)) {
            // do we have a valid request?
            if (valid_token() === FALSE || $id != $this->input->post('id')) {
                set_alert(lang('error_token'), ALERT_ERROR);
                if ($is_ajax) {
                    echo json_encode(['status' => 'redirect', 'url' => self::MANAGE_URL]);
                    return;
                }

                redirect(self::MANAGE_URL);
            }

            if ($this->form_validation->run() === TRUE) {

                $photo_urls = $this->input->post('photo_url', true);

                $sort_images = [];
                $sort_step  = 1;
                foreach ($photo_urls as $key => $value) {
                    $sort_images[$key] = $sort_step;
                    $sort_step++;
                }

                $list_photo_delete = $list_photo;
                $list_photo_update = [];
                $album_image       = '';

                foreach ($list_photo as $key => $value) {
                    //check hinh da ton tai trong db ko
                    if (isset($photo_urls[$value['id']])) {
                        unset($photo_urls[$value['id']]);
                        unset($list_photo_delete[$key]);

                        $list_photo_update[] = $value;
                    }
                }

                foreach ($photo_urls as $key => $value) {
                    $photo = move_file_tmp($value);
                    if($photo === FALSE) {
                        continue;
                    }

                    //add hinh dau tien cho album
                    if (empty($album_image) && $sort_images[$key] == 1) {
                        $album_image = $photo;
                    }

                    $photo_title = $this->input->post($key, true);
                    $add_photo = [
                        'title'      => $photo_title,
                        'image'      => $photo,
                        'album_id'   => $id,
                        'precedence' => $sort_images[$key],
                        'user_id'    => $this->get_user_id(),
                        'user_ip'    => get_client_ip(),
                        'ctime'      => get_date(),
                    ];
                    $this->Photo->insert($add_photo);
                }

                if (!empty($list_photo_update)) {
                    foreach($list_photo_update as $key => $value) {
                        $photo_title = $this->input->post($value['id'], true);
                        $edit_photo = [
                            'title'      => $photo_title,
                            'precedence' => $sort_images[$value['id']],
                            'user_id'    => $this->get_user_id(),
                            'user_ip'    => get_client_ip(),
                        ];
                        $this->Photo->update($edit_photo, $value['id']);

                        //add hinh dau tien cho album
                        if (empty($album_image) && $sort_images[$value['id']] == 1) {
                            $album_image = $value['image'];
                        }
                    }
                }

                // xoa hinh khong ton tai trong db
                if (!empty($list_photo_delete)) {
                    foreach($list_photo_delete as $value) {
                        $this->Photo->delete($value['id']);
                        delete_file_upload($value['image']);
                    }
                }

                $edit_data = [
                    'title'       => $this->input->post('title', true),
                    'description' => $this->input->post('description', true),
                    'image'       => $album_image,
                    'is_comment'  => (isset($_POST['is_comment']) && $_POST['is_comment'] == true) ? STATUS_ON : STATUS_OFF,
                    'user_id'     => $this->get_user_id(),
                    'user_ip'     => get_client_ip(),
                    'published'   => (isset($_POST['published']) && $_POST['published'] == true) ? STATUS_ON : STATUS_OFF,
                ];

                if ($this->Manager->update($edit_data, $id) === FALSE) {
                    if ($is_ajax) {
                        echo json_encode(['status' => 'ng', 'msg' => lang('error')]);
                        return;
                    }

                    set_alert(lang('error'), ALERT_ERROR);
                }

                if ($is_ajax) {
                    echo json_encode(['status' => 'ok', 'msg' => lang('edit_success'), 'id' => $id]);
                    return;
                }

                redirect(self::MANAGE_URL . '/edit/' . $id);
            } elseif ($is_ajax) {
                echo json_encode(['status' => 'ng', 'msg' => validation_errors()]);
                return;
            }
        }

        // display the create user form
        // set the flash data error message if there is one
        set_alert((validation_errors() ? validation_errors() : null), ALERT_ERROR);

        $this->data['list_photo'] = $list_photo;

        // display the edit user form
        $this->data['csrf']      = create_token();
        $this->data['item_edit'] = $item_edit;

        $this->data['title']['value']       = $this->form_validation->set_value('title', $item_edit['title']);
        $this->data['description']['value'] = $this->form_validation->set_value('description', $item_edit['description']);
        $this->data['published']['value']   = $this->form_validation->set_value('published', $item_edit['published']);
        $this->data['published']['checked'] = ($item_edit['published'] == STATUS_ON) ? true : false;

        $this->data['is_comment']['value']   = $this->form_validation->set_value('is_comment', $item_edit['is_comment']);
        $this->data['is_comment']['checked'] = ($item_edit['is_comment'] == STATUS_ON) ? true : false;

        if ($is_ajax) {
            echo json_encode(['status' => 'ok', 'view' => theme_view('albums/edit', $this->data, true)]);
            return;
        }

        theme_load('albums/edit', $this->data);
    }

    public function delete($id = null)
    {
        $is_ajax = $this->input->is_ajax_request();
        if ($is_ajax) {
            header('content-type: application/json; charset=utf8');
        }

        $this->_load_css_js();
        Events::register('enqueue_scripts', array($this, 'scripts'));

        //phai full quyen hoac duowc xoa
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_delete'), ALERT_ERROR);
            if ($is_ajax) {
                echo json_encode(['status' => 'redirect', 'url' => 'permissions/not_allowed']);
                return;
            }
            redirect('permissions/not_allowed');
        }

        $this->breadcrumb->add(lang('delete_heading'), base_url(self::MANAGE_URL . 'delete'));

        $this->data['title_heading'] = lang('delete_heading');

        //delete
        if (isset($_POST['is_delete']) && isset($_POST['ids']) && !empty($_POST['ids'])) {
            if (valid_token() == FALSE) {
                set_alert(lang('error_token'), ALERT_ERROR);
                if ($is_ajax) {
                    echo json_encode(['status' => 'redirect', 'url' => get_last_url(self::MANAGE_URL)]);
                    return;
                }
                redirect(get_last_url(self::MANAGE_URL));
            }

            $ids = $this->input->post('ids', true);
            $ids = (is_array($ids)) ? $ids : explode(",", $ids);

            $list_delete = $this->Manager->where('id', $ids)->get_all();
            if (empty($list_delete)) {
                set_alert(lang('error_empty'), ALERT_ERROR);
                if ($is_ajax) {
                    echo json_encode(['status' => 'redirect', 'url' => self::MANAGE_URL]);
                    return;
                }
                redirect(get_last_url(self::MANAGE_URL));
            }

            try {
                foreach($list_delete as $value){
                    $this->Manager->delete($value['id']);
                }

                set_alert(lang('delete_success'), ALERT_SUCCESS);
            } catch (Exception $e) {
                set_alert($e->getMessage(), ALERT_ERROR);
            }

            if ($is_ajax) {
                echo json_encode(['status' => 'redirect', 'url' => get_last_url(self::MANAGE_URL)]);
                return;
            }

            redirect(get_last_url(self::MANAGE_URL));
        }

        $delete_ids = $id;

        //truong hop chon xoa nhieu muc
        if (isset($_POST['delete_ids']) && !empty($_POST['delete_ids'])) {
            $delete_ids = $this->input->post('delete_ids', true);
        }

        if (empty($delete_ids)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            if ($is_ajax) {
                echo json_encode(['status' => 'redirect', 'url' => self::MANAGE_URL]);
                return;
            }
            redirect(self::MANAGE_URL);
        }

        $delete_ids  = is_array($delete_ids) ? $delete_ids : explode(',', $delete_ids);
        $list_delete = $this->Manager->where('id', $delete_ids)->get_all();

        if (empty($list_delete)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            if ($is_ajax) {
                echo json_encode(['status' => 'redirect', 'url' => self::MANAGE_URL]);
                return;
            }
            redirect(self::MANAGE_URL);
        }

        $this->data['csrf']        = create_token();
        $this->data['list_delete'] = $list_delete;
        $this->data['ids']         = $delete_ids;

        if ($is_ajax) {
            echo json_encode(['status' => 'ok', 'view' => theme_view('albums/delete', $this->data, true)]);
            return;
        }

        theme_load('albums/delete', $this->data);
    }
}
