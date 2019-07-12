<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Builder extends Admin_Controller
{
    public $config_form = [];
    public $data        = [];

    CONST MANAGE_NAME       = 'catcool';
    CONST MANAGE_URL        = self::MANAGE_NAME . '/builder';

    public function __construct()
    {
        parent::__construct();

        $this->lang->load('builder', $this->_site_lang);

        $this->load->helper('file');

        $this->theme->theme('admin')
            ->title('Admin Panel')
            ->add_partial('header')
            ->add_partial('footer')
            ->add_partial('sidebar');

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_name', self::MANAGE_NAME);

        //add breadcrumb
        $this->breadcrumb->add('Dashboard', base_url());
        $this->breadcrumb->add(lang('module_subheading'), base_url(self::MANAGE_URL));

        //check validation
        $this->config_form = [
            'module_name' => [
                'field' => 'module_name',
                'label' => lang('module_name'),
                'rules' => 'trim|required',
                'errors' => [
                    'required' => sprintf(lang('manage_validation_label'), lang('module_name')),
                ],
            ],
            'controller_name' => [
                'field' => 'controller_name',
                'label' => lang('controller_name'),
                'rules' => 'trim|required',
                'errors' => [
                    'required' => sprintf(lang('manage_validation_label'), lang('controller_name')),
                ],
            ],
            'model_name' => [
                'field' => 'model_name',
                'label' => lang('model_name'),
                'rules' => 'trim|required',
                'errors' => [
                    'required' => sprintf(lang('manage_validation_label'), lang('model_name')),
                ],
            ],
        ];
    }

    public function index()
    {
        $this->data          = [];
        $this->data['title'] = lang('module_heading');

        //set rule form
        $this->form_validation->set_rules($this->config_form);

        if (isset($_POST) && !empty($_POST)) {
            if ($this->form_validation->run() === TRUE) {
                // get data from form
                $module_name     = strtolower($this->input->post('module_name', true));
                $controller_name = strtolower($this->input->post('controller_name', true));
                $model_name      = strtolower($this->input->post('model_name', true));

                if (empty($module_name) || empty($controller_name) || empty($model_name)) {
                    set_alert(lang('error'), ALERT_ERROR);
                    redirect(self::MANAGE_URL, 'refresh');
                }
                $controller_name_class = ucfirst($controller_name);
                $model_name_class      = ucfirst($model_name);

                // create module
                if (!is_dir(APPPATH . "modules/" . $module_name)) {
                    @mkdir(APPPATH . 'modules/'. $module_name . '/controllers', 0775, true);
                    @mkdir(APPPATH . 'modules/'. $module_name . '/models', 0775, true);
                    @mkdir(APPPATH . 'modules/'. $module_name . '/views/manage', 0775, true);
                    @mkdir(APPPATH . 'modules/'. $module_name . '/sql', 0775, true);
                    @mkdir(APPPATH . 'modules/'. $module_name . '/language/vn', 0775, true);
                    @mkdir(APPPATH . 'modules/'. $module_name . '/language/english', 0775, true);
                }

                //write language
                $string_language = read_file(APPPATH . 'modules/dummy/language/vn/dummy_lang.php');
                $string_language = str_replace('Dummy', $controller_name_class, $string_language);

                if (!is_file(APPPATH . 'modules/' . $module_name . '/language/vn/' . $model_name . '_lang.php')) {
                    write_file(APPPATH . 'modules/' . $module_name . '/language/vn/' . $model_name . '_lang.php', $string_language);
                } else {
                    set_alert(sprintf(lang('file_created'), $model_name . '_lang.php'), ALERT_ERROR);
                }

                if (!is_file(APPPATH . 'modules/' . $module_name . '/language/english/' . $model_name . '_lang.php')) {
                    write_file(APPPATH . 'modules/' . $module_name . '/language/english/' . $model_name . '_lang.php', $string_language);
                } else {
                    set_alert(sprintf(lang('file_created'), $model_name . '_lang.php'), ALERT_ERROR);
                }

                $string_sql = read_file(APPPATH . 'modules/dummy/sql/dummy_table.sql');
                $string_sql = str_replace('dummy', $model_name, $string_sql);

                if (!is_file(APPPATH . 'modules/' . $module_name . '/sql/' . $model_name . '_table.sql')) {
                    write_file(APPPATH . 'modules/' . $module_name . '/sql/' . $model_name . '_table.sql', $string_sql);
                } else {
                    set_alert(sprintf(lang('file_created'), $model_name . '_table.sql'), ALERT_ERROR);
                }

                $manage_path = '';
                $manage_name_controller = $module_name;
                // neu la controller con cua module
                if ($module_name != $controller_name && $controller_name == $model_name) {
                    $manage_path = $controller_name . '/';
                    $manage_name_controller = $module_name . '/' . $controller_name;

                    if (!is_dir(APPPATH . 'modules/'. $module_name . '/views/' . $controller_name . '/manage')) {
                        @mkdir(APPPATH . 'modules/'. $module_name . '/views/' . $controller_name . '/manage', 0775, true);
                    } else {
                        set_alert(sprintf(lang('folder_created'), $controller_name . '/manage'), ALERT_ERROR);
                    }
                }

                //write class controller
                $string_controller = read_file(APPPATH . 'modules/dummy/controllers/Manage.php');

                $string_controller_from = ["dummy';", "load('dummy", "dummy/DummyManager", "manage/list", "manage/add", "manage/edit", "manage/delete"];
                $string_controller_to   = [$manage_name_controller . "';", "load('" . $model_name, $module_name . "/" . $model_name_class . "Manager", $manage_path . "manage/list", $manage_path . "manage/add", $manage_path . "manage/edit", $manage_path . "manage/delete"];
                $string_controller      = str_replace($string_controller_from, $string_controller_to, $string_controller);

                if (empty($manage_path)) {
                    if (!is_file(APPPATH . 'modules/' . $module_name . '/controllers/Manage.php')) {
                        write_file(APPPATH . 'modules/' . $module_name . '/controllers/Manage.php', $string_controller);
                    } else {
                        set_alert(sprintf(lang('file_created'), '/controllers/Manage.php'), ALERT_ERROR);
                    }
                } else {
                    if (!is_dir(APPPATH . 'modules/'. $module_name . '/controllers/' . $controller_name)) {
                        @mkdir(APPPATH . 'modules/'. $module_name . '/controllers/' . $controller_name, 0775, true);
                    } else {
                        set_alert(sprintf(lang('folder_created'), controllers/' . $controller_name'), ALERT_ERROR);
                    }
                    if (!is_file(APPPATH . 'modules/' . $module_name . '/controllers/' . $controller_name . '/Manage.php')) {
                        write_file(APPPATH . 'modules/' . $module_name . '/controllers/' . $controller_name . '/Manage.php', $string_controller);
                    } else {
                        set_alert(sprintf(lang('file_created'), $controller_name . '/Manage.php'), ALERT_ERROR);
                    }
                }

                $string_list_tpl = read_file(APPPATH . 'modules/dummy/views/manage/list.tpl');
                $string_add_tpl = read_file(APPPATH . 'modules/dummy/views/manage/add.tpl');
                $string_edit_tpl = read_file(APPPATH . 'modules/dummy/views/manage/edit.tpl');
                $string_delete_tpl = read_file(APPPATH . 'modules/dummy/views/manage/delete.tpl');

                if (empty($manage_path)) {
                    if (!is_file(APPPATH . 'modules/' . $module_name . '/views/manage/list.tpl')) {
                        write_file(APPPATH . 'modules/' . $module_name . '/views/manage/list.tpl', $string_list_tpl);
                    } else {
                        set_alert(sprintf(lang('file_created'), 'manage/list.tpl'), ALERT_ERROR);
                    }
                    if (!is_file(APPPATH . 'modules/' . $module_name . '/views/manage/add.tpl')) {
                        write_file(APPPATH . 'modules/' . $module_name . '/views/manage/add.tpl', $string_add_tpl);
                    } else {
                        set_alert(sprintf(lang('file_created'), 'manage/add.tpl'), ALERT_ERROR);
                    }
                    if (!is_file(APPPATH . 'modules/' . $module_name . '/views/manage/edit.tpl')) {
                        write_file(APPPATH . 'modules/' . $module_name . '/views/manage/edit.tpl', $string_edit_tpl);
                    } else {
                        set_alert(sprintf(lang('file_created'), 'manage/edit.tpl'), ALERT_ERROR);
                    }
                    if (!is_file(APPPATH . 'modules/' . $module_name . '/views/manage/delete.tpl')) {
                        write_file(APPPATH . 'modules/' . $module_name . '/views/manage/delete.tpl', $string_delete_tpl);
                    } else {
                        set_alert(sprintf(lang('file_created'), 'manage/delete.tpl'), ALERT_ERROR);
                    }
                } else {
                    if (!is_file(APPPATH . 'modules/' . $module_name . '/views/' . $controller_name . '/manage/list.tpl')) {
                        write_file(APPPATH . 'modules/' . $module_name . '/views/' . $controller_name . '/manage/list.tpl', $string_list_tpl);
                    } else {
                        set_alert(sprintf(lang('file_created'), $controller_name . 'manage/list.tpl'), ALERT_ERROR);
                    }
                    if (!is_file(APPPATH . 'modules/' . $module_name . '/views/' . $controller_name . '/manage/add.tpl')) {
                        write_file(APPPATH . 'modules/' . $module_name . '/views/' . $controller_name . '/manage/add.tpl', $string_add_tpl);
                    } else {
                        set_alert(sprintf(lang('file_created'), $controller_name . 'manage/add.tpl'), ALERT_ERROR);
                    }
                    if (!is_file(APPPATH . 'modules/' . $module_name . '/views/' . $controller_name . '/manage/edit.tpl')) {
                        write_file(APPPATH . 'modules/' . $module_name . '/views/' . $controller_name . '/manage/edit.tpl', $string_edit_tpl);
                    } else {
                        set_alert(sprintf(lang('file_created'), $controller_name . 'manage/edit.tpl'), ALERT_ERROR);
                    }
                    if (!is_file(APPPATH . 'modules/' . $module_name . '/views/' . $controller_name . '/manage/delete.tpl')) {
                        write_file(APPPATH . 'modules/' . $module_name . '/views/' . $controller_name . '/manage/delete.tpl', $string_delete_tpl);
                    } else {
                        set_alert(sprintf(lang('file_created'), $controller_name . 'manage/delete.tpl'), ALERT_ERROR);
                    }
                }

                $string_model_entity = read_file(APPPATH . 'modules/dummy/models/Dummy.php');
                $string_model_entity = str_replace(["dummy\\models", 'name="dummy', "Dummy"], [$module_name . "\\models", 'name="' . $model_name, $model_name_class], $string_model_entity);
                if (!is_file(APPPATH . 'modules/' . $module_name . '/models/' . $model_name_class . '.php')) {
                    write_file(APPPATH . 'modules/' . $module_name . '/models/' . $model_name_class . '.php', $string_model_entity);
                } else {
                    set_alert(sprintf(lang('file_created'), '/models/' . $model_name_class . '.php'), ALERT_ERROR);
                }

                $string_model_manager = read_file(APPPATH . 'modules/dummy/models/DummyManager.php');
                $string_model_manager = str_replace(["dummy\\models\\Dummy", "DummyManager", "new Dummy"], [$module_name . '\\models\\' . $model_name_class, $model_name_class . 'Manager', 'new ' . $model_name_class], $string_model_manager);
                if (!is_file(APPPATH . 'modules/' . $module_name . '/models/' . $model_name_class . 'Manager.php')) {
                    write_file(APPPATH . 'modules/' . $module_name . '/models/' . $model_name_class . 'Manager.php', $string_model_manager);
                } else {
                    set_alert(sprintf(lang('file_created'), '/models/' . $model_name_class . 'Manager.php'), ALERT_ERROR);
                }

                set_alert(lang('created_success'), ALERT_SUCCESS);
            }
        }

//        $string_list_tpl = read_file(APPPATH . 'modules/dummy/views/manage/list.tpl');
//        echo "<pre>";
//        print_r($string_list_tpl);die;


        $this->theme->load('builder/index', $this->data);
    }
}
