<?php defined('BASEPATH') OR exit('No direct script access allowed');

class News extends MY_Controller
{
    CONST FRONTEND_NAME = 'news';

    public function __construct()
    {
        parent::__construct();

        //set theme
        $this->theme->theme(config_item('theme_frontend'))
            ->add_partial('header_top')
            ->add_partial('header_bottom')
            ->add_partial('breadcumb')
            ->add_partial('footer_bottom');

        $this->lang->load('news', $this->_site_lang);

        //load model manage
        //$this->load->model("news/News", 'News');
        //$this->load->model("news/News_description", 'News_description');

        //add breadcrumb
        $this->breadcrumb->openTag(config_item('breadcrumb_open'));
        $this->breadcrumb->closeTag(config_item('breadcrumb_close'));
        $this->breadcrumb->itemOpenTag(config_item('breadcrumb_item_open'));
        $this->breadcrumb->itemCloseTage(config_item('breadcrumb_item_close'));

        $this->breadcrumb->add(lang('frontend_heading'), base_url());
    }

    public function index()
    {
        $data['title'] = lang('frontend_heading');

        $limit             = empty($this->input->get('filter_limit', true)) ? 10 : $this->input->get('filter_limit', true);
        $start_index       = (isset($_GET['page']) && is_numeric($_GET['page'])) ? ($_GET['page'] - 1) * $limit : 0;
        list($list, $tota) = $this->News->get_list_published([], $limit, $start_index);

        $data = [
            'list'   => $list,
            'paging' => $this->get_paging(base_url(), 50, $limit, $this->input->get('page')),
        ];

        theme_load('list', $data);
    }

    public function test()
    {
        $this->load->library('robot');

        $info_domain = $this->get_attribute();

        $domain = $info_domain['domain'];
        $url_domain = $info_domain['url_domain'];
        $domain_id = $info_domain['domain_id'];

        $attribute_menu = $info_domain['attribute_menu'];
        $attribute_cate = $info_domain['attribute_cate'];

       // $list_menu = $this->robot->get_menu($attribute_menu, $url_domain, $domain_id);

        $list_menu = [
            [
                'href' => 'https://kenh14.vn/star.chn',
                'title' => 'Sao'
            ],
        ];
        foreach ($list_menu as $key => $menu) {
            if (stripos($menu['href'], "https://") !== false) {
                $url =  $menu['href'];
            } else {
                $url = $url_domain . str_replace(md5($url_domain), $url_domain, $menu['href']);
            }

            $list_news = $this->robot->get_list_news($attribute_cate, $url_domain , $menu['title'], $url, $domain);
            $list_menu[$key]['list_news'] = $list_news;
        }
        cc_debug($list_menu);

        $data['list_menu'] = $list_menu;
        $data['domain_id'] = $domain_id;

        $slide_home = $info_domain['slide_home'];
        $data['slide_home'] = $slide_home;

        $data['news_rand'] = array_rand($list_menu, 4);


        $this->load->view('inc/header', $data);
        $this->load->view('news/index', $data);
        $this->load->view('inc/footer');
    }

    public function rss_fb()
    {
        $info_domain = $this->get_attribute();

        $domain = $info_domain['domain'];
        $url_domain = $info_domain['url_domain'];
        $domain_id = $info_domain['domain_id'];

        $attribute_menu = $info_domain['attribute_menu'];
        $attribute_cate = $info_domain['attribute_cate'];

        $list_menu = $this->robot->get_menu($attribute_menu, $url_domain, $domain_id);

        foreach ($list_menu as $key => $menu) {
            if (stripos($menu['href'], "http://") !== false) {
                $url =  $menu['href'];
            } else {
                $url = $url_domain . str_replace(md5($url_domain), $url_domain, $menu['href']);
            }

            $list_news = $this->robot->get_list_news($attribute_cate, $url_domain , $menu['title'], $url, $domain);
            $list_menu[$key]['list_news'] = $list_news;
        }

        $data['list_menu'] = $list_menu;
        //header("Content-Type: application/rss+xml");
        header("Content-type: text/xml; charset=utf-8");
        $this->load->view('news/rss_fb', $data);
// 		$this->output
//             ->set_content_type('application/rss+xml') // This is the standard MIME type
//             ->set_output($data); // set the output




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

    public function detail_old()
    {
        $url_root = $_GET['u'];
        $id_cate = $_GET['c'];

        if (empty($url_root)) {
            redirect(base_url());
        }

        $list_domain = $this->list_domain();
        $data = array();
        foreach ($list_domain as $key => $v) {
            $domain_md5 = md5($v['url']);
            if (strpos($url_root, $domain_md5) !== false ) {
                $domain_md5 = md5($v['url']);
                $data['url'] = str_replace($domain_md5, '', $url_root);
                $data['domain_md5'] = $domain_md5;
                $data['domain_url'] = $v['url'];
                $data['domain_name'] = $v['name'];
                $data['domain_id'] = $v['id'];
                break;
            }
        }

        $info_domain = $this->get_attribute($data['domain_name']);
        $attribute_menu = $info_domain['attribute_menu'];

        $list_menu = $this->robot->get_menu($attribute_menu, $data['domain_url']);

        foreach ($list_menu as $key => $menu) {
            $url_mn = $data['domain_url'] . str_replace(md5($data['domain_url']), '', $menu['href']);

            if ($id_cate == md5($url_mn)) {
                $id_cate = $menu['id'];
                break;
            }
        }
        if ($id_cate < 1) {
            $id_cate = 1;
        }

        redirect(base_url($data['domain_id'] . '/' . $id_cate . '/' . $data['url']));
    }

    public function categories($domain_id, $id, $cate_url)
    {
        if (empty($cate_url) || empty($domain_id)) {
            redirect(base_url());
        }

        $get_domain = $this->get_domain($cate_url, $domain_id);
        $cate =  $get_domain['url'];

        $info_domain = $this->get_attribute($get_domain['domain_name']);

        $domain = $info_domain['domain'];
        $url_domain = $info_domain['url_domain'];
        $domain_id = $info_domain['domain_id'];

        $attribute_menu = $info_domain['attribute_menu'];
        $attribute_cate =$info_domain['attribute_cate'];
        $attribute_meta = $info_domain['attribute_meta'];

        $list_menu = $this->robot->get_menu($attribute_menu, $url_domain, $domain_id);

        $list_cate = array();
        $info_cate = array();
        foreach ($list_menu as $key => $menu) {
            if (stripos($menu['href'], "http://") !== false) {
                $url =  $menu['href'];
            } else {
                $url = $url_domain . str_replace(md5($url_domain), $url_domain, $menu['href']);
            }

            if ($menu['id'] == $id) {
                $id_cate = $menu['id'];
                $info_cate = $menu;
                $list_news = $this->robot->get_list_news($attribute_cate, $url_domain , $menu['title'], $url, $domain);
                $list_cate = array_merge($list_cate, $list_news);

                $list_menu[$key]['list_news'] = $list_news;
                //break;
            } else {
                $list_news = $this->robot->get_list_news($attribute_cate, $url_domain , $menu['title'], $url, $domain, 8);
                $list_menu[$key]['list_news'] = $list_news;
            }
        }

        $meta = $this->robot->get_meta($attribute_meta, $url);
        $meta['url'] = $this->current_url();
        $meta['title'] = $info_cate['title'];
        $data['meta'] = $meta;

        $data['news_rand'] = array_rand($list_menu, 4);
        $data['id_cate'] = $id_cate;
        $data['list_menu'] = $list_menu;
        $data['list_cate'] = $list_cate;
        $data['info_cate'] = $info_cate;

        $this->load->view('inc/header', $data);
        $this->load->view('news/categories', $data);
        $this->load->view('inc/footer');
    }

    public function ny($your_name = '')
    {
        $info_domain = $this->get_attribute();

        $domain = $info_domain['domain'];
        $url_domain = $info_domain['url_domain'];

        $attribute_menu = $info_domain['attribute_menu'];
        $attribute_cate = $info_domain['attribute_cate'];

        $list_menu = $this->robot->get_menu($attribute_menu, $url_domain);

        foreach ($list_menu as $key => $menu) {
            $url =  str_replace(md5($url_domain), $url_domain, $menu['href']);
            $list_news = $this->robot->get_list_news($attribute_cate, $url_domain , $menu['title'], $url, $domain, 5);
            $list_menu[$key]['list_news'] = $list_news;
            if ($key == 4) {
                break;
            }
        }

        //echo '<pre>'; print_r($list_menu);die;

        $data['list_menu'] = $list_menu;

        $slide_home = $info_domain['slide_home'];
        $data['slide_home'] = $slide_home;

        $data['news_rand'] = array_rand($list_menu, 4);


        $arr_name = array('Cao Phương', 'Tú Nguyễn', 'Lê Hoàng Kha', 'Phạm Toàn',
            'Thánh Sò',
            'Nguyễn Hoàng Tú',
            'Huỳnh Diên Minh',
            'Nguyễn Đình Khiết Du',
            'Nguyễn Anh Đức',
            'Đức Vương',
            'Lee Phạm',
            'Ivan Đỗ',
            'Tùng Sơn',
            'Tùng Sơn',
            'Nguyễn Thanh Quang',
            'Chu Khả Hiếu',
            'Nguyễn Minh Đức',
            'Cao Bảo',
            'Bùi Văn Bắc',
            'Đinh Công Đạt',
            'Đinh Võ Hoài Phương',
            'Nguyễn Bảo Châu',
            'Đoàn Thế Minh',
            'Kun Sịp Vàng',
            'Kun Sịp Vàng',
            'Tùng Sơn',
            'Tùng Sơn',
            'Noo Phước Thịnh',
            'Soobin Hoàng Sơn',
            'Kenny Sang',
            'Kenny Sang',
            'Thánh Sò',
            'Võ Đức Trí',
            'La Thành Duy Phương',
            'Hùng Đức Phạm',
            'Bùi Quang Huy',
            'Trấn Thành',
            'Tú Hảo',
            'Hồ Ngọc Hà',
            'Trương Minh Phát',
            'Lan Khuê',
            'Minh Tú',
            'Hoàng Thuỳ',
            'Sơn Tùng MTP',
            'Linda',
            'Linda',
            'Hót Girl Bella',
            'Hót Girl Bella',
            'Mai Ngô',
            'Huỳnh Lê',
            'Sơn Lê',
            'An Nguyễn',
        );
        $arr_img = array('cao_phuong.jpg', 'tu_nguyen.jpg', 'le_hoang_kha.jpg', 'pham_toan_1.jpg',
            'thanh_so.jpg',
            'nguyen_hoang_tu.jpg',
            'huynh_duyen_minh.jpg',
            'ndkd.jpg',
            'nguyen_anh_duc.jpg',
            'duc_.jpg',
            'lee_pham.jpg',
            'ivan_do.jpg',
            'tung_son.jpg',
            'tung_son.jpg',
            'nguyen_thanh_quang.jpg',
            'chu_kha_hieu.jpg',
            'nguyen_minh_duc.jpg',
            'cao_bao.jpg',
            'bui_van_bac.jpg',
            'dinh_cong_dat.jpg',
            'dinh_vo_hoai_phuong.jpg',
            'ng_bao_chau.jpg',
            'doan_the_.jpg',
            'kun_sip_vang.jpg',
            'kun_sip_vang.jpg',
            'tung_son.jpg',
            'tung_son.jpg',
            'noo_phuoc_thinh.jpg',
            'soobin.jpg',
            'kenny_sang.jpg',
            'kenny_sang.jpg',
            'thanh_so.jpg',
            'vo_duc_tri.jpg',
            'la_thanh_phuong_duy.jpg',
            'hung_duc_pham.jpg',
            'bui_quang_huy.jpg',
            'tran_thanh.jpg',
            'tu_hao.jpg',
            'ho_ngoc_ha.jpg',
            'truong_minh_phat.jpg',
            'lan_khue.jpg',
            'minh_tu.jpg',
            'hoang_thuy.jpg',
            'son_tung_mtp.jpg',
            'linda.jpg',
            'linda.jpg',
            'bella.jpg',
            'bella.jpg',
            'mai_ngo.jpg',
            'huynh_le.jpg',
            'son_le.jpg',
            'an_nguyen.jpg',
        );

        $key_name = array_rand($arr_name,1);
        $name = $arr_name[$key_name];
        $img_name = $arr_img[$key_name];
        var_dump($name);
        var_dump($img_name);
        var_dump($key_name);

        if ($your_name == 'ten_ban') {
            $your_name = 'ban';
        }

        $meta['title'] = $name . ' là người yêu tương lai của ' . strtoupper($your_name) . ' đấy <3';
        $meta['image_fb'] = base_url() . 'images/fb/' . $img_name;
        $meta['description'] = 'kenhtraitim.com/ny/ten_ban - gõ lên trường hoặc comment để biết người yêu tương lai của bạn là ai???';
        $meta['url'] = base_url('ny/' . $your_name);
        $data['meta'] = $meta;
        var_dump($data['meta']);

        $this->load->view('inc/header', $data);
        $this->load->view('news/index', $data);
        $this->load->view('inc/footer');
    }

    public function change_domain()
    {
        $list_domain = $this->list_domain();
        $cate = $_GET['k'];
        if (!empty($cate)) {
            foreach ($list_domain as $key => $v) {
                if ($v['name'] == $cate) {
                    $cookie = array(
                        'name' => 'domain_kenhtraitim',
                        'value' => $cate,
                        'expire' => '86500',
                    );
                    $this->input->set_cookie($cookie);
                    break;
                }
            }
        }
        //$this->output->delete_cache(base_url());
        redirect(base_url());
    }

    public function video()
    {
        $video = $_GET['u'];

        echo $this->robot->runBrowser($video);
        die;
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
