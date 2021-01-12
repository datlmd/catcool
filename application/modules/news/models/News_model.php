<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'core/MY_Farm.php');

class News_model extends MY_Farm
{
    const FORMAT_NEWS_ID = '%sC%s';

    const HOME_TYPE_SLIDE = 'slide';
    const HOME_TYPE_CATEGORY = 'category';
    const HOME_TYPE_CATEGORY_HOME = 'category_home';

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

        $ctime = !empty($filter['ctime']) ? $filter['ctime'] : '';
        $this->get_table_name_year($ctime);//set table
        unset($filter['ctime']);

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

        foreach ($result as $key => $value) {
            $result[$key] = $this->get_format_json_detail($value);
            $result[$key]['news_id'] = $this->format_news_id($value);
        }

        return [$result, $total];
    }

    /**
     * Get list: new, category, slide
     *
     * @param string $type
     * @param int $limit
     * @return array|false|mixed
     */
    public function get_list_home($type = self::HOME_TYPE_CATEGORY_HOME, $limit = 200, $attribute = null)
    {
        $this->load->model("news/News_category", 'News_category');

        // TODO chua luu cache category
        $category_list = $this->News_category->get_list_by_publish();

        $where = [
            'published' => STATUS_ON,
            'is_deleted' => STATUS_OFF,
            'publish_date <=' => get_date(),
        ];

        $this->get_table_name_year();//set table

        //->set_cache(self::CURRENCY_CACHE_FILE_NAME, 86400*30)
        $list = $this->limit($limit)->order_by(['publish_date' => 'DESC'])->get_all($where);

        switch ($type) {
            case self::HOME_TYPE_SLIDE:
                $slides = [];
                foreach ($list as $key_news => $value) {
                    if ($key_news > 3) {
                        break;
                    }
                    $value['news_id'] = $this->format_news_id($value);
                    $slides[] = $this->get_format_json_detail($value);
                }
                return $slides;
            case self::HOME_TYPE_CATEGORY_HOME:
                foreach ($category_list as $key => $category) {
                    foreach ($list as $key_news => $value) {
                        if ($key_news <=3) {
                            continue;
                        }
                        $value['news_id'] = $this->format_news_id($value);
                        $value            = $this->get_format_json_detail($value);

                        if (in_array($category['category_id'], $value['category_ids'])) {
                            $category_list[$key]['list'][] = $value;
                            if (count($category_list[$key]['list']) >= 5) {
                                break;
                            }
                        }
                    }
                }

                return $category_list;
            case self::HOME_TYPE_CATEGORY:
                $category_list_tmp = [];
                foreach ($category_list as $key => $category) {
                    $category_list_tmp[$category['category_id']] = $category;
                    foreach ($list as $key_news => $value) {
                        $value['news_id'] = $this->format_news_id($value);
                        $value            = $this->get_format_json_detail($value);

                        if (in_array($category['category_id'], $value['category_ids'])) {
                            $category_list_tmp[$category['category_id']]['list'][] = $value;
                            if (count($category_list_tmp[$category['category_id']]['list']) >= 5) {
                                break;
                            }
                        }
                    }
                }

                return $category_list_tmp;

            default:
                break;
        }

        return $list;
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

                $meta   = $this->robot->get_meta($attribute['attribute_meta'], $url_detail);
                $detail = $this->robot->get_detail($attribute['attribute_detail'], $url_detail, $url_domain);

                $content  = "";
                if (!empty($detail['content'])) {
                    $content = $detail['content'];
                    //$content = $this->robot->convert_image_to_base($detail['content']);
                    if (!empty($attribute['attribute_remove'])) {
                        $content = $this->robot->remove_content_html($content, $attribute['attribute_remove']);
                    }
                }
                //lay hing dau tien trong noi dung
                $image_first = $this->robot->get_image_first($content);

                $list_news[$news_key]['content']          = $content;
                $list_news[$news_key]['meta_description'] = !empty($meta['description']) ? $meta['description'] : '';
                $list_news[$news_key]['meta_keyword']     = !empty($meta['keywords']) ? $meta['keywords'] : '';
                $list_news[$news_key]['image']            = !empty($news['image']) ? $news['image'] : $image_first;
                $list_news[$news_key]['image_fb']         = !empty($meta['image_fb']) ? $meta['image_fb'] : $image_first;
                $list_news[$news_key]['category_id']      = $menu['id'];
                $list_news[$news_key]['href']             = $url_detail;

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

        //reset table
        $this->get_table_name_year();

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
            'category_ids'     => !empty($data['category_id']) ? json_encode($data['category_id'], JSON_FORCE_OBJECT) : "",
            'publish_date'     => $date_now,
            'images'           => json_encode($this->format_image_list($image, $image_fb), JSON_FORCE_OBJECT),
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

    public function format_image_list($image_robot = null, $image_robot_fb = null, $image_root = null)
    {
        return [
            'robot'    => $image_robot,
            'robot_fb' => $image_robot_fb,
            'root'     => $image_root, //duong dan hinh tren server
        ];
    }

    public function format_news_id($data)
    {
        if (empty($data['news_id']) || empty($data['ctime'])) {
            return false;
        }

        return sprintf(self::FORMAT_NEWS_ID, $data['news_id'], strtotime($data['ctime']));
    }

    public function get_format_news_id($news_id)
    {
        if (empty($news_id)) {
            return false;
        }

        $ids = explode("C", $news_id);
        if (count($ids) != 2) {
            return $news_id;
        }

        return $ids;
    }

    public function get_detail($news_id, $ctime = null)
    {
        if (empty($ctime)) {
            list($news_id, $ctime) = $this->get_format_news_id($news_id);
        }

        //reset table
        $this->get_table_name_year($ctime);

        $detail = $this->News_model->get($news_id);
        if (empty($detail)) {
            return  false;
        }

        return $this->get_format_json_detail($detail);
    }

    public function get_format_json_detail($data)
    {
        if (empty($data)) {
            return $data;
        }

        $data['images']       = json_decode($data['images'], true);
        $data['category_ids'] = json_decode($data['category_ids'], true);

        return $data;
    }

    public function save($data, $news_id, $ctime = null)
    {
        if (empty($data)) {
            return false;
        }
        if (!empty($news_id)) {
            if (empty($ctime)) {
                list($news_id, $ctime) = $this->get_format_news_id($news_id);
            }

            //reset table
            $this->get_table_name_year($ctime);

            if ($this->News_model->update($data, $news_id) === FALSE) {
                return false;
            }
        } else if ($this->News_model->insert($data) === FALSE){
            return false;
        }

        return true;
    }

    public function get_list_multi_detail_by_ids($ids)
    {
        if (empty($ids)) {
            return false;
        }

        $list = [];

        $ids = is_array($ids) ? $ids : explode(',', $ids);
        foreach ($ids as $id) {
            list($news_id, $ctime) = $this->get_format_news_id($id);
            if (empty($news_id) || empty($ctime)) {
                continue;
            }

            //reset table
            $this->get_table_name_year($ctime);

            $list[] = $this->News_model->get($news_id);
        }


        return $list;
    }

    public function delete_item($id)
    {
        if (empty($id)) {
            return false;
        }
        list($news_id, $ctime) = $this->get_format_news_id($id);
        if (empty($news_id) || empty($ctime)) {
            return false;
        }

        //reset table
        $this->get_table_name_year($ctime);

        return $this->News_model->delete($news_id);
    }
}
