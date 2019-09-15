<?php defined('BASEPATH') OR exit('No direct script access allowed');

class TranslationManager extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'translations';
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
        $filter['lang_key LIKE']   = empty($filter['lang_key']) ? '%%' : '%' . $filter['lang_key'] . '%';
        $filter['lang_value LIKE'] = empty($filter['lang_value']) ? '%%' : '%' . $filter['lang_value'] . '%';

        unset($filter['lang_key']);
        unset($filter['lang_value']);

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
