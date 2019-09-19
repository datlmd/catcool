<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MenuManager extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'menus';
        $this->primary_key = 'id';

        $this->fillable = [
            'id',
            'title',
            'slug',
            'description',
            'icon',
            'context',
            'nav_key',
            'label',
            'attributes',
            'selected',
            'language',
            'precedence',
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
        $filter['language LIKE'] = empty($filter['language']) ? '%%' : '%' . $filter['language'] . '%';
        $filter['title LIKE']    = empty($filter['title']) ? '%%' : '%' . $filter['title'] . '%';
        $filter['is_admin LIKE'] = empty($filter['is_admin']) ? '%%' : '%' . $filter['is_admin'] . '%';

        unset($filter['language']);
        unset($filter['title']);
        unset($filter['is_admin']);

        $total = $this->count_rows($filter);

        if (!empty($limit) && isset($offset)) {
            $result = $this->limit($limit,$offset)->order_by(['id' => 'DESC'])->get_all($filter);
        } else {
            $result = $this->order_by(['id' => 'DESC'])->get_all($filter);
        }

        if (empty($result)) {
            return [false, 0];
        }

        return [$result, $total];
    }

    public function get_menu_active($filter = null)
    {
        $filter['published'] = STATUS_ON;
        $filter['language LIKE'] = empty($filter['language']) ? '%%' : '%' . $filter['language'] . '%';
        unset($filter['language']);

        $key_prefix = (isset($filter['is_admin']) && $filter['is_admin'] == STATUS_ON) ? 'admin_' : 'frontend_';
        $this->load->driver('cache', ['adapter' => 'file', 'key_prefix' => $key_prefix]);

        if ( ! $result = $this->cache->get('get_menu_cc')) {
            $result = $this->get_all($filter);
            if (empty($result)) {
                return false;
            }

            // Save into the cache for 1hour
            $this->cache->save('get_menu_cc', $result, 3600);
        }
        return $result;
    }
}
