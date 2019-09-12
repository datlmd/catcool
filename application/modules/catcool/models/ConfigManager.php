<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ConfigManager extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'configs';
        $this->primary_key = 'id';

        $this->fillable = [
            'id',
            'config_key',
            'config_value',
            'description',
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
        $filter['config_key LIKE']   = empty($filter['config_key']) ? '%%' : '%' . $filter['config_key'] . '%';
        $filter['config_value LIKE'] = empty($filter['config_value']) ? '%%' : '%' . $filter['config_value'] . '%';

        unset($filter['config_key']);
        unset($filter['config_value']);

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

    public function get_list_by_publish($published = STATUS_ON)
    {
        if (empty($published)) {
            return false;
        }

        $return = $this->order_by(['id' => 'DESC'])->get_all(['published' => $published]);
        if (empty($return)) {
            return false;
        }

        return $return;
    }
}
