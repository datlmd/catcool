<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_manager extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'menu';
        $this->primary_key = 'menu_id';

        //khoa ngoai
        $this->has_one['detail'] = [
            'foreign_model' =>'Menu_description_manager',
            'foreign_table' =>'Menu_manager',
            'foreign_key'   =>'menu_id',
            'local_key'     =>'menu_id',
        ];
        $this->has_many['details'] = [
            'foreign_model' =>'Menu_description_manager',
            'foreign_table' =>'Menu_manager',
            'foreign_key'   =>'menu_id',
            'local_key'     =>'menu_id',
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
        if (isset($filter['is_admin']) && is_numeric($filter['is_admin'])) {
            $filter_root[] = ['is_admin', $filter['is_admin']];
        }

        if (!empty($filter['id'])) {
            $filter_root[] = ['menu_id', (is_array($filter['id'])) ? $filter['id'] : explode(",", $filter['id'])];
        }

        if (empty($filter['language_id'])) {
            $filter['language_id'] = get_lang_id();
        }

        $filter['name'] = empty($filter['name']) ? '%%' : '%' . $filter['name'] . '%';
        $filter_detail  = sprintf('where:language_id=%d and name like \'%s\'', $filter['language_id'], $filter['name']);

        $total = $this->with_detail($filter_detail)->count_rows($filter_root);

        if (!empty($limit) && isset($offset)) {
            $result = $this->limit($limit,$offset)->order_by(['menu_id' => 'DESC'])->with_detail($filter_detail)->get_all($filter_root);
        } else {
            $result = $this->order_by(['menu_id' => 'DESC'])->with_detail($filter_detail)->get_all($filter_root);
        }

        if (empty($result)) {
            return [false, 0];
        }

        return [$result, $total];
    }

    public function get_detail($ids)
    {
        if (empty($ids)) {
            return false;
        }

        $ids            = is_array($ids) ? $ids : explode(',', $ids);
        $filter_detail  = sprintf('where:language_id=%d', get_lang_id());
        $result         = $this->where('menu_id', $ids)->with_detail($filter_detail)->get_all();

        return $result;
    }

    public function get_menu_active($filter = null)
    {
        $filter['published'] = STATUS_ON;

        $key_prefix = (isset($filter['is_admin']) && $filter['is_admin'] == STATUS_ON) ? 'admin_' : 'frontend_';
        $this->load->driver('cache', ['adapter' => 'file', 'key_prefix' => $key_prefix]);

        if ( ! $result = $this->cache->get('get_menu_cc')) {
            $result = $this->order_by(['sort_order' => 'DESC'])->with_detail('where:language_id=' . get_lang_id())->get_all($filter);
            if (empty($result)) {
                return false;
            }

            // Save into the cache for 1hour
            $this->cache->save('get_menu_cc', $result, 3600);
        }
        return $result;
    }
}
