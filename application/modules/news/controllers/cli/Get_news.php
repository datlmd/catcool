<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Get_news extends MY_Controller
{
    CONST FRONTEND_NAME = 'news';

    public function __construct()
    {
        parent::__construct();

        //load model manage
        //$this->load->model("news/News", 'News');
        //$this->load->model("news/News_description", 'News_description');
    }

    public function index()
    {
//        if (!is_cli()) {
//            show_error('Không thể gọi bằng url!');
//        }

        $this->load->model("news/News_model", 'News_model');

        $this->config->load('config_robot');

        $attribute_kenh14 = config_item('kenh14');

        $list_menu = $this->News_model->robot_get_news($attribute_kenh14);

        cc_debug($list_menu);
    }

    public function detail($domain_id, $category = '', $url_root = null)
    {
        $id_cate = $category;

        if (empty($url_root)) {
            redirect(base_url());
        }
        $url_root = str_replace('_', '/', $url_root);
        $get_domain = $this->get_domain($url_root, $domain_id);

        $is_match = explode('#', $url_root);
        if (isset($_GET['t'])) {
            $url = $_GET['t'] . $url_root;
        } else {
            $url = $get_domain['url'];
        }

        $info_domain = $this->get_attribute($get_domain['domain_name']);

        $domain = $info_domain['domain'];
        $url_domain = $info_domain['url_domain'];
        $domain_id = $info_domain['domain_id'];

        $attribute_menu = $info_domain['attribute_menu'];
        $attribute_cate = $info_domain['attribute_cate'];
        $attribute_detail = $info_domain['attribute_detail'];
        $attribute_meta = $info_domain['attribute_meta'];

        $detail = $this->robot->get_detail($attribute_detail, $url, $url_domain, base_url($get_domain['domain_id'] . '/' . $id_cate));
// echo "<pre>";
// 		print_r($attribute_detail);
// 		die;
        $cate_detail = array();
        $list_menu = $this->robot->get_menu($attribute_menu, $url_domain, $domain_id);
        foreach ($list_menu as $key => $menu) {
            if (stripos($menu['href'], "http://") !== false) {
                $url_mn =  $menu['href'];
            } else {
                $url_mn = $url_domain . str_replace(md5($url_domain), $url_domain, $menu['href']);
            }
            $list_news = $this->robot->get_list_news($attribute_cate, $url_domain , $menu['title'], $url_mn, $domain, 8);
            $list_menu[$key]['list_news'] = $list_news;
            if ($menu['id'] == $id_cate) {
                $cate_detail = $list_menu[$key];
            }
        }

        $data['source'] = $url;
        $data['domain'] = $domain;
        $data['detail'] = $detail;
        $data['list_menu'] = $list_menu;
        $data['cate_detail'] = $cate_detail;
        $data['news_rand'] = array_rand($list_menu, 4);

        $meta = $this->robot->get_meta($attribute_meta, $url);
        $meta['title'] = $detail['title'];
        $meta['url'] = $this->current_url();

        if ($domain == 'Zing') {
            $image_fb = '';
            preg_match('/src=\"(.*?)\"/', $detail['content'], $matches);
            if ($matches) {
                $image_fb = strip_tags(trim($matches[1]));
            }
            if (!empty($image_fb)) {
                $meta['image_fb'] = $image_fb;
            }
        }

        $data['meta'] = $meta;
//		echo "<pre>";
//		print_r($meta);
//		die;
        $data['url_detail'] = $this->current_url();

        $this->load->view('inc/header', $data);
        $this->load->view('news/detail', $data);
        $this->load->view('inc/footer');
    }

    public function get_attribute_zing() {
        $data['domain'] = 'Zing';
        $data['domain_id'] = 1;
        $data['url_domain'] = 'http://news.zing.vn/';
        $data['slide_home'] = array(8,9,10);

        $data['attribute_menu'] = array(
            //'content' => 'div.navbar',
            'start' => 'li class="parent',
            'end' => '/a',
            'title' => '/html\">(.*?)</',
            'href' => '/href=\"(.*?)\"/',
        );

        $data['attribute_cate'] = array(
            'attribute_cate_1' => array(
                'start' => '<article',
                'end' => '</article',
                'title' => '/title=\"(.*?)\"/',
                'note' => '/class=\"summary\">(.*?)</',
                'datetime' => '/datetime=\"(.*?)\">(.*?)</',
                'image' => '/src=\"(.*?)\"/',
                'href' => '/href=\"(.*?)\"/',
            ),
        );

        $data['attribute_detail'] = array (
            'attribute_detail_1' => array (
                'title' 		=> '/h1 class=\"the-article-title cms-title\">(.*?)</',
                'note' 			=> '/meta id=\"metaDescription\" name=\"description\" content=\"(.*?)\"/',
                'content'		=> 'div.the-article-body',
                'datetime'		=> '/article:published_time\" content=\"(.*?)\"/',
                'author' 		=> '/class="author">(.*?)</',
            ),
            'attribute_detail_2' => array (
                'title' 		=> 'h2.video-title',
                'note' 			=> '/meta id=\"metaDescription\" name=\"description\" content=\"(.*?)\"/',
                'content'		=> 'div.video-player',
                'datetime'		=> '/article:published_time\" content=\"(.*?)\"/',
                'author' 		=> 'p.video-author',
            ),
        );

        $data['attribute_meta'] = array (
            'description'		=> '/name=\"description\" content=\"(.*?)\"/',
            'keywords'		=> '/name=\"keywords\" content=\"(.*?)\"/',
            'image_fb'		=> '/property=\"og:image:url\" content=\"(.*?)\"/',
        );

        return $data;
    }

    public function get_attribute_kenh14() {
        $data['domain'] = 'Kênh 14';
        $data['domain_id'] = 2;
        $data['url_domain'] = 'http://kenh14.vn/';
        $data['slide_home'] = array(0,2,4);

        $data['attribute_menu'] = array(
            //'content' => 'div.navbar',
            'start' => 'li class="kmli',
            'end' => '/a',
            'title' => '/title=\"(.*?)\"/',
            'href' => '/href=\"(.*?)\"/',
        );

        $data['attribute_cate'] = array(
            'attribute_cate_1' => array(
                'start' => 'li class="ktncli"',
                'end' => '</li',
                'title' => '/title=\"(.*?)\"/',
                'note' => '/span class=\"ktncli-sapo\">(.*?)</',
                //'datetime' => '/span class=\"kscliw-time\"(.*?)title=\"(.*?)\"/',
                'image' => '/src=\"(.*?)\"/',
                'href' => '/href=\"(.*?)\"/',
            ),
            'attribute_cate_2' => array(
                'start' => 'knswli-left fl',
                'end' => '</li',
                'title' => '/title=\'(.*?)\'/',
                'note' => '/span class=\'knswli-sapo sapo-need-trim\'>(.*?)</',
                //'datetime' => '/span class=\'kscliw-time\'(.*?)title=\'(.*?)\'/',
                'image' => '/src=\"(.*?)\"/',
                'href' => '/href=\'(.*?)\'/',
            ),
        );

        $data['attribute_detail'] = array (
            'attribute_detail_1' => array (
                'title' => '/h1 class=\"kbwc-title\">(.*?)</',
                'note' => '/h2 class=\"knc-sapo\<\/h2/"
(.*?)/',
                'content' => 'div.knc-content',
                'datetime'	=> 'span.kbwcm-time',
                //'author' 		=> '/class="author">(.*?)</',
            ),
        );

        $data['attribute_meta'] = array (
            'description'		=> '/name=\"description\" content=\"(.*?)\"/',
            'keywords'		=> '/name=\"keywords\" content=\"(.*?)\"/',
            'image_fb'		=> '/property=\"og:image\" content=\"(.*?)\"/',
        );

        return $data;
    }

    public function get_attribute_vnexpress() {
        $data['domain'] = 'VnExpress';
        $data['domain_id'] = 3;
        $data['url_domain'] = 'http://vnexpress.net/';
        $data['slide_home'] = array(5,1,7);

        $data['attribute_menu'] = array(
            'content' => 'div#header_main',
            'start' => '<li',
            'end' => '/li',
            'title' => '/\">(.*?)</',
            'href' => '/href=\"(.*?)\"/',
            'replace_from' => array('http://', '.vnexpress.net/','.vnexpress.net','/tin-tuc/'),
            'replace_to' => array('','','',''),
            'not_show' => 'Video,Góc nhìn,Kinh doanh,Khoa học,Xe,Số hóa',
        );

        $data['attribute_cate'] = array(
            'attribute_cate_1' => array(
                'replace_content' => array('box_hot_news', 'src="https://s.vnecdn.net/','data-mobile-href="(.*?)"'),
                'replace_content_to' => array('block_image_news','src-no="https://s.vnecdn.net/',''),
                'start' => 'block_image_news',
                'end' => '</li',
                'title' => '/jpg\" alt=\"(.*?)\"/',
                'note' => 'div.news_lead',
                'datetime' => '/span class=\"kscliw-time\"(.*?)title=\"(.*?)\"/',
                'image' => '/src=\"(.*?)\"/',
                'href' => '/href=\"(.*?)\"/',
                'replace_href' => array('http://video.vnexpress.net/', 'http://kinhdoanh.vnexpress.net/', 'http://startup.vnexpress.net/', 'http://giaitri.vnexpress.net/', 'http://thethao.vnexpress.net/', 'http://suckhoe.vnexpress.net/', 'http://giadinh.vnexpress.net/', 'http://dulich.vnexpress.net/', 'http://sohoa.vnexpress.net/'),
                'replace_href_to' => array('','','','','','','','',''),
            ),
        );

        $data['attribute_detail'] = array (
            'attribute_detail_1' => array (
                'title' 		=> 'div.title_news h1',
                'note' 			=> '/h3 class=\"short_intro txt_666\">(.*?)</',
                'content'		=> 'div.fck_detail',
                'datetime'		=> '/div class=\"block_timer left txt_666\">(.*?)<\/d/',
                //'author' 		=> '/class="author">(.*?)</',
            ),
//			'attribute_detail_2' => array (
//				'title' 		=> '/h1 class=\"title_detail\">(.*?)</',
//				'note' 			=> '/h2 class=\"lead_detail\">(.*?)</',
//				'content'		=> 'div.fck_detail',
//				'datetime'		=> '/span class=\"right timestamp\">(.*?)<\/span/',
//				//'author' 		=> '/class="author">(.*?)</',
//			),
        );

        $data['attribute_meta'] = array (
            'description'		=> '/name=\"description\" content=\"(.*?)\"/',
            'keywords'		=> '/name=\"keywords\" content=\"(.*?)\"/',
            'image_fb'		=> '/meta content=\"(.*?)\" itemprop=\"thumbnailUrl\" property=\"og:image\"/',
        );

        return $data;
    }
    public function list_domain()
    {
        $data = array(
            0 => array(
                'id' => 1,
                'name' => 'zing',
                'url' => 'http://news.zing.vn/'
            ),
            1 => array(
                'id' => 2,
                'name' => 'kenh14',
                'url' => 'http://kenh14.vn/'
            ),
            2 => array(
                'id' => 3,
                'name' => 'vnexpress',
                'url' => 'http://vnexpress.net/'
            ),
        );
        return $data;
    }

    public function get_domain($url_root, $id_domain)
    {
        $list_domain = $this->list_domain();
        $data = array();
        foreach ($list_domain as $key => $v) {
            if($v['id'] == $id_domain) {
                $domain_md5 = md5($v['url']);
                $data['url'] = $v['url'] . str_replace($domain_md5, $v['url'], $url_root);
                $data['domain_md5'] = $domain_md5;
                $data['domain_url'] = $v['url'];
                $data['domain_name'] = $v['name'];
                $data['domain_id'] = $id_domain;
                break;
            }
        }
        return $data;
    }

    public function get_attribute($name = null)
    {
        $domain_name = 'kenh14';//$this->input->cookie('domain_kenhtraitim', true);

        if (!empty($name) && $domain_name != $name) {
            $domain_name = $name;
            $cookie= array(
                'name'   => 'domain_kenhtraitim',
                'value'  => $domain_name,
                'expire' => '86500',
            );
            $this->input->set_cookie($cookie);
        }

        switch ($domain_name) {
            case 'zing':
                $attribute = $this->get_attribute_zing();
                break;
            case 'kenh14':
                $attribute = $this->get_attribute_kenh14();
                break;
            case 'vnexpress':
                $attribute = $this->get_attribute_vnexpress();
                break;
            default:
                $attribute = $this->get_attribute_kenh14();
        }

        return $attribute;
    }

    function current_url()
    {
        $CI =& get_instance();

        $url = $CI->config->site_url($CI->uri->uri_string());
        return $_SERVER['QUERY_STRING'] ? $url.'?'.$_SERVER['QUERY_STRING'] : $url;
    }
}
