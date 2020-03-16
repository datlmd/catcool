<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends Admin_Controller
{
    public $config_form = [];
    public $data        = [];

    CONST MANAGE_NAME       = 'utilities';
    CONST MANAGE_URL        = 'utilities/manage';
    CONST MANAGE_PAGE_LIMIT = PAGINATION_DEFAULF_LIMIT;

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

        $this->lang->load('utilities_manage', $this->_site_lang);


        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_name', self::MANAGE_NAME);

        //add breadcrumb
        $this->breadcrumb->add(lang('catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('heading_title'), base_url(self::MANAGE_URL));

        //check validation
        $this->config_form = [];

        //set form input
        $this->data = [];
    }

    public function index()
    {
        //phai full quyen hoac chi duoc doc
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_read'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }

        $this->data          = [];
        $this->data['title'] = lang('heading_title');

        $filter = [];

        $filter_module = $this->input->get('filter_module', true);
        $filter_name   = $this->input->get('filter_name', true);

        if (!empty($filter_name)) {
            $filter['lang_key']   = $filter_name;
            $filter['lang_value'] = $filter_name;
        }

        $module_id = $this->input->get('module_id');
        if (!empty($filter_module)) {
            $module_id = $filter_module;
        }

        if (empty($module_id) && empty($filter_module)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect('modules/manage');
        }

        $module = $this->Module->get($module_id);
        if (empty($module)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect('modules/manage');
        }

        $filter['module_id'] = $module_id;

        //list lang
        $list_lang = $this->Language->get_list_by_publish();

        list($list, $total_records) = $this->Manager->get_all_by_filter($filter);
        if (!empty($list)) {
            foreach ($list as $key => $value) {
                $list[$value['lang_key']][$value['lang_id']] = $value;
                unset($list[$key]);
            }
        }

        list($list_module, $total_module) = $this->Module->get_all_by_filter();

        $this->data['list']        = $list;
        $this->data['list_lang']   = $list_lang;
        $this->data['list_module'] = $list_module;
        $this->data['module']      = $module;

        theme_load('list', $this->data);
    }

    public function php_info()
    {
        $data['title'] = lang('heading_title');
        $data['info_list'] = $this->_parse_phpinfo();

        theme_load('php_info', $data);
    }

    private function _parse_phpinfo() {
        ob_start(); phpinfo(INFO_MODULES); $s = ob_get_contents(); ob_end_clean();
        $s = strip_tags($s, '<h2><th><td>');
        $s = preg_replace('/<th[^>]*>([^<]+)<\/th>/', '<info>\1</info>', $s);
        $s = preg_replace('/<td[^>]*>([^<]+)<\/td>/', '<info>\1</info>', $s);
        $t = preg_split('/(<h2[^>]*>[^<]+<\/h2>)/', $s, -1, PREG_SPLIT_DELIM_CAPTURE);
        $r = array(); $count = count($t);
        $p1 = '<info>([^<]+)<\/info>';
        $p2 = '/'.$p1.'\s*'.$p1.'\s*'.$p1.'/';
        $p3 = '/'.$p1.'\s*'.$p1.'/';
        for ($i = 1; $i < $count; $i++) {
            if (preg_match('/<h2[^>]*>([^<]+)<\/h2>/', $t[$i], $matchs)) {
                $name = trim($matchs[1]);
                $vals = explode("\n", $t[$i + 1]);
                foreach ($vals AS $val) {
                    if (preg_match($p2, $val, $matchs)) { // 3cols
                        $r[$name][trim($matchs[1])] = array(trim($matchs[2]), trim($matchs[3]));
                    } elseif (preg_match($p3, $val, $matchs)) { // 2cols
                        $r[$name][trim($matchs[1])] = trim($matchs[2]);
                    }
                }
            }
        }
        return $r;
    }
}
