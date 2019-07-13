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
        $this->breadcrumb->add(lang('catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
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
            'table_name' => [
                'field' => 'table_name',
                'label' => lang('table_name'),
                'rules' => 'trim',
            ],
        ];
    }

    public function index()
    {
        $this->data          = [];
        $this->data['title'] = lang('module_heading');

        $error_created = [];
        //set rule form
        $this->form_validation->set_rules($this->config_form);

        if (isset($_POST) && !empty($_POST)) {
            if ($this->form_validation->run() === TRUE) {
                // get data from form
                $module_name     = strtolower($this->input->post('module_name', true));
                $controller_name = strtolower($this->input->post('controller_name', true));
                $model_name      = strtolower($this->input->post('model_name', true));
                $table_name      = strtolower($this->input->post('table_name', true));

                if (empty($module_name) || empty($controller_name) || empty($model_name)) {
                    set_alert(lang('error'), ALERT_ERROR);
                    redirect(self::MANAGE_URL, 'refresh');
                }

                if ($module_name == $controller_name && $controller_name != $model_name) {
                    set_alert(lang('error_name_module'), ALERT_ERROR);
                    redirect(self::MANAGE_URL, 'refresh');
                }

                if ($module_name != $controller_name && $controller_name != $model_name) {
                    set_alert(lang('error_name_module'), ALERT_ERROR);
                    redirect(self::MANAGE_URL, 'refresh');
                }

                $controller_name_class = ucfirst($controller_name);
                $model_name_class      = ucfirst($model_name);

                // create module
                if (!is_dir(APPPATH . "modules/" . $module_name)) {
                    mkdir(APPPATH . 'modules/'. $module_name, 0775, true);
                    mkdir(APPPATH . 'modules/'. $module_name . '/controllers', 0775, true);
                    mkdir(APPPATH . 'modules/'. $module_name . '/models', 0775, true);
                    mkdir(APPPATH . 'modules/'. $module_name . '/views/manage', 0775, true);
                    mkdir(APPPATH . 'modules/'. $module_name . '/sql', 0775, true);
                    mkdir(APPPATH . 'modules/'. $module_name . '/language/vn', 0775, true);
                    mkdir(APPPATH . 'modules/'. $module_name . '/language/english', 0775, true);
                }

                //write language
                $string_language = read_file(APPPATH . 'modules/dummy/language/vn/dummy_lang.php');
                $string_language = str_replace('Dummy', $controller_name_class, $string_language);

                if (!is_file(APPPATH . 'modules/' . $module_name . '/language/vn/' . $model_name . '_lang.php')) {
                    write_file(APPPATH . 'modules/' . $module_name . '/language/vn/' . $model_name . '_lang.php', $string_language);
                } else {
                    $error_created[] = sprintf(lang('file_created'), $model_name . '_lang.php');
                }

                if (!is_file(APPPATH . 'modules/' . $module_name . '/language/english/' . $model_name . '_lang.php')) {
                    write_file(APPPATH . 'modules/' . $module_name . '/language/english/' . $model_name . '_lang.php', $string_language);
                } else {
                    $error_created[] = sprintf(lang('file_created'), $model_name . '_lang.php');
                }

                $string_sql = read_file(APPPATH . 'modules/dummy/sql/dummy_table.sql');
                $string_sql = str_replace('dummy', $model_name, $string_sql);

                if (!is_file(APPPATH . 'modules/' . $module_name . '/sql/' . $model_name . '_table.sql')) {
                    write_file(APPPATH . 'modules/' . $module_name . '/sql/' . $model_name . '_table.sql', $string_sql);
                } else {
                    $error_created[] = sprintf(lang('file_created'), $model_name . '_table.sql');
                }

                $manage_path = '';
                $manage_name_controller = $module_name;
                // neu la controller con cua module
                if ($module_name != $controller_name && $controller_name == $model_name) {
                    $manage_path = $controller_name . '/';
                    $manage_name_controller = $module_name . '/' . $controller_name;

                    if (!is_dir(APPPATH . 'modules/'. $module_name . '/views/' . $controller_name . '/manage')) {
                        mkdir(APPPATH . 'modules/'. $module_name . '/views/' . $controller_name . '/manage', 0775, true);
                    } else {
                        $error_created[] = sprintf(lang('folder_created'), $controller_name . '/manage');
                    }
                }

                //neu ten table khong tai thi su sung ten model lam table
                if (empty($table_name)) {
                    $table_name = $model_name;
                }

                //templat su dung cho tpl add va edit
                $template_field = '
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("%s_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($%s)}
                            </div>
                        </div>';

                //template su dung manage form validation
                $template_form_validation = "
                '%s' => [
                    'field' => '%s',
                    'label' => lang('%s_label'),
                    'rules' => 'trim',
                ],";

                //template su dung data input trong manage
                $template_data_input = "
                '%s' => [
                    'name' => '%s',
                    'id' => '%s',
                    'type' => 'text',
                    'class' => 'form-control',
                ],";

                //template khi post data khi add va edit
                $template_add_post = "
                '%s' => \$this->input->post('%s', true),";

                //template set value add
                $template_set_value_add = "
                \$this->data['%s']['value'] = \$this->form_validation->set_value('%s');";

                ////template set value edit
                $template_set_value_edit = "
                \$this->data['%s']['value'] = \$this->form_validation->set_value('%s', \$item_edit['%s']);";

                //template su dungthem entity khi ntao model
                $template_insert_entity_db = "
                \$entry->%s(\$data['%s']);";

                $template_replace = "";
                $template_form_validation_replace = "";
                $template_data_input_replace = "";
                $template_add_post_replace = "";
                $template_set_value_add_replace = "";
                $template_set_value_edit_replace = "";
                $template_insert_entity_db_replace = "";
                // get data field
                if ($this->db->table_exists($table_name) ) {
                    $fields = $this->db->field_data($table_name);
                    if (!empty($fields)) {
                        $list_not_add = ['id','title', 'description', 'precedence', 'published', 'language', 'ctime', 'mtime'];
                        foreach ($fields as $field) {
                            if (in_array($field->name, $list_not_add)) {
                                continue;
                            }

                            //them field cho tpl add va edit
                            $template_replace .= sprintf($template_field, $field->name, $field->name, $field->name);

                            //them field form validation trong manage
                            $template_form_validation_replace .= sprintf($template_form_validation, $field->name, $field->name, $field->name);

                            //them field data trong manage
                            $template_data_input_replace .= sprintf($template_data_input, $field->name, $field->name, $field->name);

                            //them field khi submit trong manage
                            $template_add_post_replace .= sprintf($template_add_post, $field->name, $field->name);

                            //set data field cho add trong manage
                            $template_set_value_add_replace .= sprintf($template_set_value_add, $field->name, $field->name);

                            //set data field cho edit trong manage
                            $template_set_value_edit_replace .= sprintf($template_set_value_edit, $field->name, $field->name, $field->name);

                            //set data field cho edit trong manage
                            $template_insert_entity_db_replace .= sprintf($template_insert_entity_db, $field->name, $field->name);
                        }
                    }
                }

                //write class controller
                $string_controller = read_file(APPPATH . 'modules/dummy/controllers/Manage.php');

                $string_controller_from = ["dummy';", "load('dummy", "dummy/DummyManager", "manage/list", "manage/add", "manage/edit", "manage/delete"];
                $string_controller_to   = [$manage_name_controller . "';", "load('" . $model_name, $module_name . "/" . $model_name_class . "Manager", $manage_path . "manage/list", $manage_path . "manage/add", $manage_path . "manage/edit", $manage_path . "manage/delete"];
                $string_controller      = str_replace($string_controller_from, $string_controller_to, $string_controller);

                //replace neu ton tai field moi
                $string_controller = str_replace(['//FORMVALIDATION', '//FORMDATAINPUT', '//ADDPOST', '//SETVALUEDATAADD', '//SETVALUEDATAEDIT'], [$template_form_validation_replace, $template_data_input_replace, $template_add_post_replace, $template_set_value_add_replace, $template_set_value_edit_replace], $string_controller);

                if (empty($manage_path)) {
                    if (!is_file(APPPATH . 'modules/' . $module_name . '/controllers/Manage.php')) {
                        write_file(APPPATH . 'modules/' . $module_name . '/controllers/Manage.php', $string_controller);
                    } else {
                        $error_created[] = sprintf(lang('file_created'), '/controllers/Manage.php');
                    }
                } else {
                    if (!is_dir(APPPATH . 'modules/'. $module_name . '/controllers/' . $controller_name)) {
                        mkdir(APPPATH . 'modules/'. $module_name . '/controllers/' . $controller_name, 0775, true);
                    } else {
                        $error_created[] = sprintf(lang('folder_created'), controllers/' . $controller_name');
                    }
                    if (!is_file(APPPATH . 'modules/' . $module_name . '/controllers/' . $controller_name . '/Manage.php')) {
                        write_file(APPPATH . 'modules/' . $module_name . '/controllers/' . $controller_name . '/Manage.php', $string_controller);
                    } else {
                        $error_created[] = sprintf(lang('file_created'), $controller_name . '/Manage.php');
                    }
                }

                $string_list_tpl   = read_file(APPPATH . 'modules/dummy/views/manage/list.tpl');
                $string_add_tpl    = read_file(APPPATH . 'modules/dummy/views/manage/add.tpl');
                $string_edit_tpl   = read_file(APPPATH . 'modules/dummy/views/manage/edit.tpl');
                $string_delete_tpl = read_file(APPPATH . 'modules/dummy/views/manage/delete.tpl');

                $string_add_tpl  = str_replace('{*FIELDDATA*}', $template_replace, $string_add_tpl);
                $string_edit_tpl = str_replace('{*FIELDDATA*}', $template_replace, $string_edit_tpl);

                if (empty($manage_path)) {
                    if (!is_file(APPPATH . 'modules/' . $module_name . '/views/manage/list.tpl')) {
                        write_file(APPPATH . 'modules/' . $module_name . '/views/manage/list.tpl', $string_list_tpl);
                    } else {
                        $error_created[] = sprintf(lang('file_created'), 'manage/list.tpl');
                    }
                    if (!is_file(APPPATH . 'modules/' . $module_name . '/views/manage/add.tpl')) {
                        write_file(APPPATH . 'modules/' . $module_name . '/views/manage/add.tpl', $string_add_tpl);
                    } else {
                        $error_created[] = sprintf(lang('file_created'), 'manage/add.tpl');
                    }
                    if (!is_file(APPPATH . 'modules/' . $module_name . '/views/manage/edit.tpl')) {
                        write_file(APPPATH . 'modules/' . $module_name . '/views/manage/edit.tpl', $string_edit_tpl);
                    } else {
                        $error_created[] = sprintf(lang('file_created'), 'manage/edit.tpl');
                    }
                    if (!is_file(APPPATH . 'modules/' . $module_name . '/views/manage/delete.tpl')) {
                        write_file(APPPATH . 'modules/' . $module_name . '/views/manage/delete.tpl', $string_delete_tpl);
                    } else {
                        $error_created[] = sprintf(lang('file_created'), 'manage/delete.tpl');
                    }
                } else {
                    if (!is_file(APPPATH . 'modules/' . $module_name . '/views/' . $controller_name . '/manage/list.tpl')) {
                        write_file(APPPATH . 'modules/' . $module_name . '/views/' . $controller_name . '/manage/list.tpl', $string_list_tpl);
                    } else {
                        $error_created[] = sprintf(lang('file_created'), $controller_name . 'manage/list.tpl');
                    }
                    if (!is_file(APPPATH . 'modules/' . $module_name . '/views/' . $controller_name . '/manage/add.tpl')) {
                        write_file(APPPATH . 'modules/' . $module_name . '/views/' . $controller_name . '/manage/add.tpl', $string_add_tpl);
                    } else {
                        $error_created[] = sprintf(lang('file_created'), $controller_name . 'manage/add.tpl');
                    }
                    if (!is_file(APPPATH . 'modules/' . $module_name . '/views/' . $controller_name . '/manage/edit.tpl')) {
                        write_file(APPPATH . 'modules/' . $module_name . '/views/' . $controller_name . '/manage/edit.tpl', $string_edit_tpl);
                    } else {
                        $error_created[] = sprintf(lang('file_created'), $controller_name . 'manage/edit.tpl');
                    }
                    if (!is_file(APPPATH . 'modules/' . $module_name . '/views/' . $controller_name . '/manage/delete.tpl')) {
                        write_file(APPPATH . 'modules/' . $module_name . '/views/' . $controller_name . '/manage/delete.tpl', $string_delete_tpl);
                    } else {
                        $error_created[] = sprintf(lang('file_created'), $controller_name . 'manage/delete.tpl');
                    }
                }

                $string_model_entity = read_file(APPPATH . 'modules/dummy/models/Dummy.php');
                $string_model_entity = str_replace(["dummy\\models", 'name="dummy', "Dummy"], [$module_name . "\\models", 'name="' . $table_name, $model_name_class], $string_model_entity);
                if (!is_file(APPPATH . 'modules/' . $module_name . '/models/' . $model_name_class . '.php')) {
                    write_file(APPPATH . 'modules/' . $module_name . '/models/' . $model_name_class . '.php', $string_model_entity);
                } else {
                    $error_created[] = sprintf(lang('file_created'), '/models/' . $model_name_class . '.php');
                }

                $string_model_manager = read_file(APPPATH . 'modules/dummy/models/DummyManager.php');
                $string_model_manager = str_replace(["dummy\\models\\Dummy", "DummyManager", "new Dummy"], [$module_name . '\\models\\' . $model_name_class, $model_name_class . 'Manager', 'new ' . $model_name_class], $string_model_manager);

                $string_model_manager = str_replace('//UPDATEDBFIELD', $template_insert_entity_db_replace, $string_model_manager);

                if (!is_file(APPPATH . 'modules/' . $module_name . '/models/' . $model_name_class . 'Manager.php')) {
                    write_file(APPPATH . 'modules/' . $module_name . '/models/' . $model_name_class . 'Manager.php', $string_model_manager);
                } else {
                    $error_created[] = sprintf(lang('file_created'), '/models/' . $model_name_class . 'Manager.php');
                }

                if (empty($error_created)) {
                    set_alert(lang('created_success'), ALERT_SUCCESS);
                }
            }
        }

        $this->data['error_created'] = $error_created;

        $this->theme->load('builder/index', $this->data);
    }
}
