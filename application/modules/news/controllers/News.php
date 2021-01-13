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
            //->add_partial('breadcumb')
            ->add_partial('footer_bottom');

        $this->lang->load('news', $this->_site_lang);

        //load model manage
        $this->load->model("news/News_model", 'News_model');

    }

    public function index()
    {
        set_meta_seo();

        $data = [
            'category_list' => $this->News_model->get_list_home(),
            'slide_list' => $this->News_model->get_list_home(News_model::HOME_TYPE_SLIDE),
        ];

        theme_load('index', $data);
    }

    public function category()
    {
        $this->theme->add_partial('content_right');
        $data = [];

        theme_load('category', $data);
    }

    public function detail($slug, $id, $ctime)
    {
        if (empty($slug) || empty($id) || empty($ctime)) {
            show_404();
        }

        $this->theme->add_partial('content_right');

        $news = $this->News_model->get_detail($id, $ctime);
        if (empty($news)) {
            show_404();
        }

        $image_url = (!empty($news['images']['robot_fb'])) ? $news['images']['robot_fb'] : (!empty($news['images']['robot']) ? $news['images']['robot'] : images['image']['root']);
        $data_seo = [
            'title'       => $news['meta_title'],
            'description' => $news['meta_description'],
            'keywords'    => $news['meta_keyword'],
            'url'         => base_url($news['slug'] . '.' . $this->News_model->format_news_id($news)),
            'image'       => image_url($image_url),
        ];
        set_meta_seo($data_seo);

        $this->load->library('robot');
        //convert image
        $news['content'] = $this->robot->convert_image_to_base($news['content']);

        //update count view
        $update_count['counter_view'] = $news['counter_view'] + 1;
        $this->News_model->save($update_count, $id, $ctime);

        //lay danh sach cung the loai
        $news_category_list = [];
        $category_list = $this->News_model->get_list_home(News_model::HOME_TYPE_CATEGORY);
        if (!empty($category_list) && !empty($news['category_ids'])) {
            foreach ($news['category_ids'] as $category_id) {
                if (isset($category_list[$category_id])) {
                    $news_category_list = array_merge($news_category_list, $category_list[$category_id]['list']);
                }
            }
        }
        shuffle($news_category_list);

        $this->load->model("news/News_category", 'News_category');

        // @TODO chua luu cache category
        $category_list = $this->News_category->get_list_by_publish();

        $data = [
            'detail' => $news,
            'news_category_list' => $news_category_list,
        ];

        theme_load('detail', $data);
    }
}
