<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Translation extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'translation';
        $this->primary_key = 'id';

        $this->fillable = [
            'id',
            'lang_key',
            'lang_value',
            'lang_id',
            'module_id',
            'user_id',
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
        if (!empty($filter)) {
            $filter_root['lang_key LIKE']   = empty($filter['key']) ? '%%' : '%' . $filter['key'] . '%';
            $filter_root['lang_value LIKE'] = empty($filter['value']) ? '%%' : '%' . $filter['value'] . '%';
            $filter_root['module_id']       = $filter['module_id'];
        }

        $total = $this->count_rows($filter_root);
        if (!empty($limit) && isset($offset)) {
            $result = $this->limit($limit,$offset)->order_by(['id' => 'DESC'])->get_all($filter_root);
        } else {
            $result = $this->order_by(['id' => 'DESC'])->get_all($filter_root);
        }

        if (empty($result)) {
            return [false, 0];
        }

        return [$result, $total];
    }

    public function get_by_key_lang_module($key, $lang_id, $module_id)
    {
        if (empty($key) || empty($lang_id) || empty($module_id)) {
            return false;
        }
        $entry = $this->get(['lang_key' => $key, 'lang_id' => $lang_id, 'module_id' => $module_id]);
        if (empty($entry)) {
            return false;
        }

        return $entry;
    }

    public function get_list_by_key_module($key, $module_id)
    {
        if (empty($key) || empty($module_id)) {
            return false;
        }
        $entry = $this->get_all(['lang_key' => $key, 'module_id' => $module_id]);
        if (empty($entry)) {
            return false;
        }

        return $entry;
    }
}
