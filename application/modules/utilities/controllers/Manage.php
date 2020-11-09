<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends Admin_Controller
{
    public $config_form = [];
    public $data        = [];

    CONST MANAGE_ROOT = 'utilities/manage';
    CONST MANAGE_URL  = 'utilities/manage';

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
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

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

        theme_load('list', $this->data);
    }

    public function php_info()
    {
        //phai full quyen hoac chi duoc doc
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_read'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }

        $data['title'] = lang('heading_title');
        $data['info_list'] = $this->_parse_phpinfo();

        theme_load('php_info', $data);
    }

    private function _parse_phpinfo()
    {
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

    public function list_file()
    {
        //phai full quyen hoac chi duoc doc
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_read'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }

        $this->breadcrumb->add("File Browser", base_url(self::MANAGE_URL));

        add_style(css_url('js/codemirror/lib/codemirror', 'common'));
        add_style(css_url('js/codemirror/theme/monokai', 'common'));
        add_style(css_url('js/fba/fba', 'common'));

        $this->theme->add_js(js_url('js/codemirror/lib/codemirror', 'common'));
        $this->theme->add_js(js_url('js/codemirror/lib/xml', 'common'));
        $this->theme->add_js(js_url('js/fba/fba', 'common'));

        $dir_list = ['media', 'content/language', 'content/themes'];
        if (!empty($_GET['dir']) && in_array($_GET['dir'], $dir_list)) {
            $dir = $_GET['dir'];
        } else {
            $dir = 'content/themes';
        }

        $data = [
            "api"      => "utilities/fba?dir=" . $dir,
            "route"    => "utilities/manage/list_file?dir=" . $dir,
            "dir_list" => $dir_list,
            "dir"      => $dir,
        ];

        theme_load('list_file', $data);
    }
}
