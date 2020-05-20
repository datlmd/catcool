<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'menu';
        $this->primary_key = 'menu_id';

        //khoa ngoai
        $this->has_one['detail'] = [
            'foreign_model' => 'menus/Menu_description',
            'foreign_table' => 'menu_description',
            'foreign_key'   => 'menu_id',
            'local_key'     => 'menu_id',
        ];
        $this->has_many['details'] = [
            'foreign_model' => 'menus/Menu_description',
            'foreign_table' => 'menu_description',
            'foreign_key'   => 'menu_id',
            'local_key'     => 'menu_id',
        ];

        $this->fillable = [
            'menu_id',
            'slug',
            'icon',
            'context',
            'nav_key',
            'label',
            'attributes',
            'selected',
            'language',
            'sort_order',
            'user_id',
            'parent_id',
            'is_admin',
            'hidden',
            'published',
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
    public function get_all_by_filter($filter = null, $limit = 0, $offset = 0)
    {
        $filter_root = [];
        if (isset($filter['is_admin'])) {
            $filter_root[] = ['is_admin', $filter['is_admin']];
        }

        if (empty($filter['language_id'])) {
            $filter['language_id'] = get_lang_id();
        }

        $filter_detail  = sprintf('where:language_id=%d', $filter['language_id']);

        $total = $this->count_rows($filter_root);
        if (!empty($limit) && isset($offset)) {
            $result = $this->limit($limit,$offset)->order_by(['menu_id' => 'DESC'])->where($filter_root)->with_detail($filter_detail)->get_all();
        } else {
            $result = $this->order_by(['sort_order' => 'DESC'])->where($filter_root)->with_detail($filter_detail)->get_all();
        }

        if (empty($result)) {
            return [false, 0];
        }

        return [$result, $total];
    }

    public function get_list_full_detail($ids)
    {
        if (empty($ids)) {
            return false;
        }

        $ids           = is_array($ids) ? $ids : explode(',', $ids);
        $filter_detail = sprintf('where:language_id=%d', get_lang_id());
        $result        = $this->where('menu_id', $ids)->with_detail($filter_detail)->get_all();

        return $result;
    }

    public function get_menu_active($filter = null, $expire_time = 3600, $is_cache = true)
    {
        $cache_name = SET_CACHE_NAME_MENU;

        $filter['published'] = isset($filter['published']) ? $filter['published'] : STATUS_ON;
        $filter['hidden']    = isset($filter['hidden']) ? $filter['hidden'] : STATUS_ON;
        $filter['is_admin']  = isset($filter['is_admin']) ? $filter['is_admin'] : STATUS_OFF;

        if (!empty($filter['is_admin'])) {
            $cache_name = $cache_name . '_admin';
        } else {
            $cache_name = $cache_name . '_frontend';
            $cache_name = (!empty($filter['context'])) ?  $cache_name . '_' . $filter['context'] : $cache_name;
        }

        $this->load->driver('cache', ['adapter' => 'file', 'key_prefix' => '']);

        $result = $this->cache->get($cache_name);
        if (empty($result)) {
            $result = $this->order_by(['sort_order' => 'DESC'])->where($filter)->with_detail('where:language_id=' . get_lang_id())->get_all();
            if (empty($result)) {
                return false;
            }

            // Save into the cache for 1hour
            $this->cache->save($cache_name, $result, $expire_time);
        }

        return $result;
    }

    public function delete_cache($cache_name = null)
    {
        $this->load->driver('cache', ['adapter' => 'file', 'key_prefix' => '']);
        if (!empty($cache_name) && !empty($this->cache->get($cache_name))) {
            $this->cache->save($cache_name, [], 0);
            return true;
        }

        //clear cache all
        $list_name = [
            SET_CACHE_NAME_MENU . '_admin',
            SET_CACHE_NAME_MENU . '_frontend',
            SET_CACHE_NAME_MENU . '_frontend_' . MENU_POSITION_MAIN,
            SET_CACHE_NAME_MENU . '_frontend_' . MENU_POSITION_FOOTER,
            SET_CACHE_NAME_MENU . '_frontend_' . MENU_POSITION_TOP,
            SET_CACHE_NAME_MENU . '_frontend_' . MENU_POSITION_BOTTOM,
            SET_CACHE_NAME_MENU . '_frontend_' . MENU_POSITION_OTHER,
        ];

        foreach ($list_name as $name) {
            if (empty($this->cache->get($name))) {
                continue;
            }
            $this->cache->save($name, [], 0);
        }

        return true;
    }
}
