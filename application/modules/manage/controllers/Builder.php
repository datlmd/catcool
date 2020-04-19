<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Builder extends Admin_Controller
{
    CONST MANAGE_ROOT = 'manage/builder';
    CONST MANAGE_URL  = 'manage/builder';

    public function __construct()
    {
        parent::__construct();

        //set theme
        $this->theme->theme(config_item('theme_admin'))
            ->add_partial('header')
            ->add_partial('footer')
            ->add_partial('sidebar');

        $this->lang->load('builder', $this->_site_lang);

        $this->load->helper('file');

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('heading_title'), base_url(self::MANAGE_URL));
    }

    public function index()
    {
        //phai full quyen
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_execute'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }
        $this->theme->title(lang('heading_title'));

        $data = [];

        $error_created = [];
        //set rule form
        $config_form = [
            'module_name' => [
                'field' => 'module_name',
                'label' => lang('module_name'),
                'rules' => 'trim|required',
                'errors' => [
                    'required' => sprintf(lang('text_manage_validation'), lang('module_name')),
                ],
            ],
            'controller_name' => [
                'field' => 'controller_name',
                'label' => lang('controller_name'),
                'rules' => 'trim|required',
                'errors' => [
                    'required' => sprintf(lang('text_manage_validation'), lang('controller_name')),
                ],
            ],
            'model_name' => [
                'field' => 'model_name',
                'label' => lang('model_name'),
                'rules' => 'trim|required',
                'errors' => [
                    'required' => sprintf(lang('text_manage_validation'), lang('model_name')),
                ],
            ],
            'table_name' => [
                'field' => 'table_name',
                'label' => lang('table_name'),
                'rules' => 'trim',
            ],
        ];
        $this->form_validation->set_rules($config_form);

        if (isset($_POST) && !empty($_POST)) {
            if ($this->form_validation->run() === TRUE) {
                // get data from form
                $module_name     = strtolower($this->input->post('module_name', true));
                $controller_name = strtolower($this->input->post('controller_name', true));
                $model_name      = strtolower($this->input->post('model_name', true));
                $table_name      = strtolower($this->input->post('table_name', true));

                if (empty($module_name) || empty($controller_name) || empty($model_name)) {
                    set_alert(lang('error'), ALERT_ERROR);
                    redirect(self::MANAGE_URL);
                }

//                if ($module_name == $controller_name && $controller_name != $model_name) {
//                    set_alert(lang('error_name_module'), ALERT_ERROR);
//                    redirect(self::MANAGE_URL);
//                }
//
//                if ($module_name != $controller_name && $controller_name != $model_name) {
//                    set_alert(lang('error_name_module'), ALERT_ERROR);
//                    redirect(self::MANAGE_URL);
//                }

                if ($controller_name == "manage") {
                    $controller_name = $module_name;
                }
                $controller_name_class = ucfirst($controller_name);
                $model_name_class      = ucfirst($model_name);

                // create module
                if (!is_dir(APPPATH . "modules/" . $module_name)) {
                    mkdir(APPPATH . 'modules/'. $module_name, 0777, true);
                    mkdir(APPPATH . 'modules/'. $module_name . '/controllers', 0777, true);
                    mkdir(APPPATH . 'modules/'. $module_name . '/models', 0777, true);
                    mkdir(APPPATH . 'modules/'. $module_name . '/sql', 0777, true);
                    mkdir(APPPATH . 'modules/'. $module_name . '/views', 0777, true);
                    mkdir(APPPATH . 'modules/'. $module_name . '/language/vn', 0777, true);
                    mkdir(APPPATH . 'modules/'. $module_name . '/language/english', 0777, true);
                }

                //write language
                $string_language_vn = file_get_contents(APPPATH . 'modules/dummy/language/vn/dummy_lang.php');
                $string_language_en = file_get_contents(APPPATH . 'modules/dummy/language/english/dummy_lang.php');

                $string_language_vn = str_replace('Dummy', $controller_name_class, $string_language_vn);
                $string_language_en = str_replace('Dummy', $controller_name_class, $string_language_en);

                if (!is_file(APPPATH . 'modules/' . $module_name . '/language/vn/' . $controller_name . '_manage_lang.php')) {
                    write_file(APPPATH . 'modules/' . $module_name . '/language/vn/' . $controller_name . '_manage_lang.php', $string_language_vn);
                } else {
                    $error_created[] = sprintf(lang('file_created'), 'vn/' . $controller_name . '_manage_lang.php');
                }

                if (!is_file(APPPATH . 'modules/' . $module_name . '/language/english/' . $controller_name . '_manage_lang.php')) {
                    write_file(APPPATH . 'modules/' . $module_name . '/language/english/' . $controller_name . '_manage_lang.php', $string_language_en);
                } else {
                    $error_created[] = sprintf(lang('file_created'), 'english' .  $controller_name . '_manage_lang.php');
                }

                $string_sql = file_get_contents(APPPATH . 'modules/dummy/sql/dummy_table.sql');
                $string_sql = str_replace('dummy', $model_name, $string_sql);

                if (!is_file(APPPATH . 'modules/' . $module_name . '/sql/' . $model_name . '_table.sql')) {
                    write_file(APPPATH . 'modules/' . $module_name . '/sql/' . $model_name . '_table.sql', $string_sql);
                } else {
                    $error_created[] = sprintf(lang('file_created'), $model_name . '_table.sql');
                }

                $manage_path = '';
                $manage_name_controller = $module_name;
                // neu la controller con cua module
                if ($module_name != $controller_name) {
                    $manage_path = $controller_name . '/';
                    $manage_name_controller = $module_name . '/' . $controller_name;

                    if (!is_dir(APPPATH . 'modules/'. $module_name . '/views/' . $controller_name)) {
                        mkdir(APPPATH . 'modules/'. $module_name . '/views/' . $controller_name, 0777, true);
                    } else {
                        $error_created[] = sprintf(lang('folder_created'), $controller_name );
                    }
                }

                //neu ten table khong tai thi su sung ten model lam table
                if (empty($table_name)) {
                    $table_name = $model_name;
                }
                $table_name_description = $table_name . '_description';

                //templat su dung cho tpl add va edit
                $template_field_root = "
                    <div class=\"form-group\">
                        {lang('text_%s')}
                        <input type=\"text\" name=\"%s\" value=\"{set_value('%s', \$edit_data.%s)}\" id=\"%s\" class=\"form-control\">
                    </div>";
                $template_field_description = "
                    <div class=\"form-group row\">
                        <label class=\"col-12 col-sm-3 col-form-label text-sm-right\">
                            {lang('text_%s')}
                        </label>
                        <div class=\"col-12 col-sm-8 col-lg-7\">
                            <input type=\"text\" name=\"manager_description[{\$language.id}][%s]\" value='{set_value(\"manager_description[`\$language.id`][%s]\", \$edit_data.details[\$language.id].%s)}' id=\"input_%s[{\$language.id}]\" class=\"form-control\">
                        </div>
                    </div>";

                //template khi post data khi add va edit
                $template_add_post_root = "
                    '%s' => \$this->input->post('%s', true),";

                $template_replace_root        = ""; // : {*TPL_DUMMY_ROOT*}
                $template_replace_description = ""; // : {*TPL_DUMMY_DESCRIPTION*}
                $template_add_post_replace_root = ""; // : //ADD_DUMMY_ROOT

                $field_root = ""; // : //FIELD_ROOT
                $field_description = ""; // : //FIELD_DESCRIPTION


                // get data field root
                if ($this->db->table_exists($table_name) ) {
                    $fields = $this->db->field_data($table_name);
                    if (!empty($fields)) {
                        $list_not_add = [$table_name . '_id', 'sort_order', 'published', 'user_id', 'ctime', 'mtime'];
                        foreach ($fields as $field) {
                            if (in_array($field->name, $list_not_add)) {
                                continue;
                            }
                            $field_root .= '"' . $field->name . '",' . PHP_EOL;

                            //them field cho tpl add va edit
                            $template_replace_root .= sprintf($template_field_root, $field->name, $field->name, $field->name, $field->name, $field->name);
                            //them field khi submit trong manage
                            $template_add_post_replace_root .= sprintf($template_add_post_root, $field->name, $field->name);
                        }
                    }
                }
                // get data field description
                if ($this->db->table_exists($table_name_description) ) {
                    $fields = $this->db->field_data($table_name_description);
                    if (!empty($fields)) {
                        $list_not_add = [$table_name . '_id', 'name', 'description', 'language_id'];
                        foreach ($fields as $field) {
                            if (in_array($field->name, $list_not_add)) {
                                continue;
                            }
                            $field_description .= '"' . $field->name . '",' . PHP_EOL;

                            //them field cho tpl add va edit
                            $template_replace_description .= sprintf($template_field_description, $field->name, $field->name, $field->name, $field->name, $field->name);
                        }
                    }
                }

                //write class controller
                $string_controller = file_get_contents(APPPATH . 'modules/dummy/controllers/Manage.php');

                $string_controller_from = [
                    "dummy/manage", //MANAGE_ROOT & MANAGE_URL
                    "load('dummy",
                    "dummy/Dummy_manager",
                    "dummy/Dummy_description_manager",
                    "manage/list",
                    "manage/form",
                    "manage/delete",
                    "dummy_id",
                    "//ADD_DUMMY_ROOT"
                ];
                $string_controller_to = [
                    $manage_name_controller . "/manage",
                    "load('" . $controller_name . '_manage',
                    $module_name . "/" . $model_name_class . "_manager",
                    $module_name . "/" . $model_name_class . "_description_manager",
                    $manage_path . "list",
                    $manage_path . "form",
                    $manage_path . "delete",
                    $table_name . "_id",
                    $template_add_post_replace_root
                ];
                $string_controller = str_replace($string_controller_from, $string_controller_to, $string_controller);

                if (empty($manage_path)) {
                    if (!is_file(APPPATH . 'modules/' . $module_name . '/controllers/Manage.php')) {
                        write_file(APPPATH . 'modules/' . $module_name . '/controllers/Manage.php', $string_controller);
                    } else {
                        $error_created[] = sprintf(lang('file_created'), '/controllers/Manage.php');
                    }
                } else {
                    if (!is_dir(APPPATH . 'modules/'. $module_name . '/controllers/' . $controller_name)) {
                        mkdir(APPPATH . 'modules/'. $module_name . '/controllers/' . $controller_name, 0777, true);
                    } else {
                        $error_created[] = sprintf(lang('folder_created'), 'controllers/' . $controller_name);
                    }
                    if (!is_file(APPPATH . 'modules/' . $module_name . '/controllers/' . $controller_name . '/Manage.php')) {
                        write_file(APPPATH . 'modules/' . $module_name . '/controllers/' . $controller_name . '/Manage.php', $string_controller);
                    } else {
                        $error_created[] = sprintf(lang('file_created'), $controller_name . '/Manage.php');
                    }
                }

                $string_list_tpl   = file_get_contents(APPPATH . 'modules/dummy/views/manage/list.tpl');
                $string_form_tpl   = file_get_contents(APPPATH . 'modules/dummy/views/manage/form.tpl');
                $string_delete_tpl = file_get_contents(APPPATH . 'modules/dummy/views/manage/delete.tpl');

                $string_list_tpl   = str_replace("dummy_id", $table_name . "_id", $string_list_tpl);
                $string_form_tpl   = str_replace(["dummy_id", "{*TPL_DUMMY_ROOT*}", "{*TPL_DUMMY_DESCRIPTION*}"], [$table_name . "_id", $template_replace_root, $template_replace_description], $string_form_tpl);
                $string_delete_tpl = str_replace("dummy_id", $table_name . "_id", $string_delete_tpl);

                if (empty($manage_path)) {
                    if (!is_file(APPPATH . 'modules/' . $module_name . '/views/list.tpl')) {
                        write_file(APPPATH . 'modules/' . $module_name . '/views/list.tpl', $string_list_tpl);
                    } else {
                        $error_created[] = sprintf(lang('file_created'), '/list.tpl');
                    }
                    if (!is_file(APPPATH . 'modules/' . $module_name . '/views/form.tpl')) {
                        write_file(APPPATH . 'modules/' . $module_name . '/views/form.tpl', $string_form_tpl);
                    } else {
                        $error_created[] = sprintf(lang('file_created'), '/form.tpl');
                    }
                    if (!is_file(APPPATH . 'modules/' . $module_name . '/views/delete.tpl')) {
                        write_file(APPPATH . 'modules/' . $module_name . '/views/delete.tpl', $string_delete_tpl);
                    } else {
                        $error_created[] = sprintf(lang('file_created'), '/delete.tpl');
                    }
                } else {
                    if (!is_file(APPPATH . 'modules/' . $module_name . '/views/' . $controller_name . '/list.tpl')) {
                        write_file(APPPATH . 'modules/' . $module_name . '/views/' . $controller_name . '/list.tpl', $string_list_tpl);
                    } else {
                        $error_created[] = sprintf(lang('file_created'), $controller_name . '/list.tpl');
                    }
                    if (!is_file(APPPATH . 'modules/' . $module_name . '/views/' . $controller_name . '/form.tpl')) {
                        write_file(APPPATH . 'modules/' . $module_name . '/views/' . $controller_name . '/form.tpl', $string_form_tpl);
                    } else {
                        $error_created[] = sprintf(lang('file_created'), $controller_name . '/form.tpl');
                    }
                    if (!is_file(APPPATH . 'modules/' . $module_name . '/views/' . $controller_name . '/delete.tpl')) {
                        write_file(APPPATH . 'modules/' . $module_name . '/views/' . $controller_name . '/delete.tpl', $string_delete_tpl);
                    } else {
                        $error_created[] = sprintf(lang('file_created'), $controller_name . '/delete.tpl');
                    }
                }

                $string_model_manager             = file_get_contents(APPPATH . 'modules/dummy/models/Dummy_manager.php');
                $string_model_description_manager = file_get_contents(APPPATH . 'modules/dummy/models/Dummy_description_manager.php');

                $string_model_manager = str_replace(
                    ["Dummy_manager", 'dummy";', "dummy/Dummy_description_manager", "dummy_description", "dummy_id", "//FIELD_ROOT"],
                    [$model_name_class . "_manager",  $table_name . '";', $module_name . "/" . $model_name_class . "_description_manager", $table_name_description, $table_name . "_id", $field_root],
                    $string_model_manager
                );

                if (!is_file(APPPATH . 'modules/' . $module_name . '/models/' . $model_name_class . '_manager.php')) {
                    write_file(APPPATH . 'modules/' . $module_name . '/models/' . $model_name_class . '_manager.php', $string_model_manager);
                } else {
                    $error_created[] = sprintf(lang('file_created'), '/models/' . $model_name_class . '_manager.php');
                }

                $string_model_description_manager = str_replace(
                    ["Dummy_description_manager", 'dummy_description";', "dummy/Dummy_manager", 'dummy"', "dummy_id", "//FIELD_DESCRIPTION"],
                    [$model_name_class . "_description_manager",  $table_name_description . '";', $module_name . "/" . $model_name_class . "_manager", $table_name . '"', $table_name . "_id", $field_description],
                    $string_model_description_manager
                );

                if (!is_file(APPPATH . 'modules/' . $module_name . '/models/' . $model_name_class . '_description_manager.php')) {
                    write_file(APPPATH . 'modules/' . $module_name . '/models/' . $model_name_class . '_description_manager.php', $string_model_description_manager);
                } else {
                    $error_created[] = sprintf(lang('file_created'), '/models/' . $model_name_class . '_description_manager.php');
                }

                if (empty($error_created)) {
                    set_alert(lang('created_success'), ALERT_SUCCESS);
                }
            }
        }

        $data['error_created'] = $error_created;

        theme_load('builder', $data);
    }
}
