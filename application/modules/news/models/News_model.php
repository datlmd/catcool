<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'core/MY_Farm.php');

class News_model extends MY_Farm
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'news';
        $this->primary_key = 'news_id';

        $this->fillable = [
            'news_id',
            'name',
            'slug',
            'description',
            'content',
            'meta_title',
            'meta_description',
            'meta_keyword',
            'language_id',
            'category_ids',
            'publish_date',
            'is_comment',
            'images',
            'categories',
            'tags',
            'author',
            'source',
            'sort_order',
            'user_id',
            'user_ip',
            'counter_view',
            'counter_comment',
            'counter_like',
            'published',
            'is_deleted',
            'ctime',
            'mtime',
        ];

        $this->get_table_name_year();//get table current
    }

    /**
     * Get list all
     *
     * @param null $filter
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function get_all_by_filter($filter = null, $limit = 0, $offset = 0, $order = null)
    {
        $filter['name LIKE'] = empty($filter['name']) ? '%%' : '%' . $filter['name'] . '%';

        unset($filter['name']);

        $total = $this->count_rows($filter);

        $order = empty($order) ? ['news_id' => 'DESC'] : $order;

        if (!empty($limit) && isset($offset)) {
            $result = $this->limit($limit,$offset)->order_by($order)->get_all($filter);
        } else {
            $result = $this->order_by($order)->get_all($filter);
        }

        if (empty($result)) {
            return [false, 0];
        }

        return [$result, $total];
    }

    public function robot_get_news($attribute, $is_insert = true)
    {
        $this->load->library('robot');

        $domain         = $attribute['domain'];
        $url_domain     = $attribute['url_domain'];
        $domain_id      = $attribute['domain_id'];
        $attribute_cate = $attribute['attribute_cate'];
        $list_menu      = $attribute['attribute_menu'];

        foreach ($list_menu as $key => $menu) {
            if (stripos($menu['href'], "https://") !== false || stripos($menu['href'], "http://") !== false) {
                $url = $menu['href'];
            } else {
                $url = $url_domain . str_replace(md5($url_domain), $url_domain, $menu['href']);
            }

            $list_news = $this->robot->get_list_news($attribute_cate, $url_domain , $menu['title'], $url, $domain, 8);
            if (empty($list_news)) {
                continue;
            }

            foreach ($list_news as $news_key => $news) {
                if (stripos($news['href'], "https://") !== false || stripos($news['href'], "http://") !== false) {
                    $url_detail = $news['href'];
                } else {
                    $url_detail = $url_domain . $news['href'];
                }

                $meta = $this->robot->get_meta($attribute['attribute_meta'], $url_detail);
                $list_news[$news_key]['meta_description'] = !empty($meta['description']) ? $meta['description'] : '';
                $list_news[$news_key]['meta_keyword']     = !empty($meta['keywords']) ? $meta['keywords'] : '';
                $list_news[$news_key]['image_fb']         = !empty($meta['image_fb']) ? $meta['image_fb'] : '';

                $detail = $this->robot->get_detail($attribute['attribute_detail'], $url_detail, $url_domain);

                $content = "";
                if (!empty($detail['content'])) {
                    $content = $this->robot->convert_image_to_base($detail['content']);
                    if (!empty($attribute['attribute_remove'])) {
                        $content = $this->robot->remove_content_html($content, $attribute['attribute_remove']);
                    }
                }
                $list_news[$news_key]['content'] = $content;

                $list_news[$news_key]['category_id'] = $menu['id'];
                $list_news[$news_key]['href']        = $url_detail;

                $list_tags = $this->robot->get_tags($attribute['attribute_tags'], $detail['html']);
                $list_news[$news_key]['tags'] = implode(",", $list_tags);

                if ($news_key % 20 == 0) {
                    sleep(1);
                }
            }

            $list_menu[$key]['list_news'] = $list_news;
        }

        if ($is_insert === true) {
            krsort($list_news);
            foreach ($list_menu as $key => $menu) {
                foreach ($list_news as $news_key => $news) {
                    $this->robot_save($news);
                    sleep(1);
                }
            }
        }

        return $list_menu;
    }

    public function robot_save($data)
    {
        if (empty($data['title']) || empty($data['note']) || empty($data['content'])) {
            return false;
        }

        $this->reset_connection();

        $filter['source'] = $data['href'];
        $check_list = $this->get_all($filter);
        if (!empty($check_list)) {
            return false;
        }

        $image = "";
        if (!empty($data['image'])) {
            $image = save_image_from_url($data['image'], 'news');
        }
        $image_fb = "";
        if (!empty($data['image_fb'])) {
            $image_fb = save_image_from_url($data['image_fb'], 'news');
        }

        $image_list = [
            //'root'   => '', duong dan hinh tren server
            'robot'    => $image,
            'robot_fb' => $image_fb,
        ];
        $date_now = get_date();

        if (!empty($data['tags'])) {
            $tags = is_array($data['tags']) ? implode(",", $data['tags']) : $data['tags'];
        } else {
            $tags = "";
        }

        $add_data = [
            'name'             => !empty($data['title']) ? $data['title'] : "",
            'slug'             => !empty($data['title']) ? slugify($data['title']) : "",
            'description'      => !empty($data['note']) ? $data['note'] : "",
            'content'          => !empty($data['content']) ? $data['content'] : "",
            'meta_title'       => !empty($data['title']) ? $data['title'] : "",
            'meta_description' => !empty($data['meta_description']) ? $data['meta_description'] : "",
            'meta_keyword'     => !empty($data['meta_keyword']) ? $data['meta_keyword'] : "",
            'language_id'      => get_lang_id(),
            'category_ids'     => !empty($data['category_id']) ? json_encode($data['category_id']) : "",
            'publish_date'     => $date_now,
            'images'           => json_encode($image_list),
            'tags'             => $tags,
            'author'           => !empty($data['author']) ? $data['author'] : "",
            'source'           => !empty($data['href']) ? $data['href'] : "",
            'user_ip'          => get_client_ip(),
            'user_id'          => 0,
            'is_comment'       => COMMENT_STATUS_ON,
            'published'        => STATUS_ON,
            'is_deleted'       => STATUS_OFF,
            'sort_order'       => 0,
            'ctime'            => $date_now,
        ];

        $id = $this->insert($add_data);

        return true;
    }
}
