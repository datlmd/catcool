<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Route extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'route';
        $this->primary_key = 'id';

        $this->fillable = [
            'id',
            'module',
            'resource',
            'route',
            'language_id',
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
        $filter['module LIKE']   = empty($filter['module']) ? '%%' : '%' . $filter['module'] . '%';
        $filter['resource LIKE'] = empty($filter['resource']) ? '%%' : '%' . $filter['resource'] . '%';

        unset($filter['module']);
        unset($filter['resource']);

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

    public function get_list_by_module($module, $resource)
    {
        if (empty($module) || empty($resource)) {
            return false;
        }

        $data = [
            'module'   => $module,
            'resource' => $resource
        ];

        $result = $this->order_by(['id' => 'DESC'])->get_all($data);
        if (empty($result)) {
            return false;
        }

        $data = [];
        foreach ($result as $value) {
            $data[$value['language_id']] = $value;
        }

        return $data;
    }

    public function get_routes($urls, $module = null, $resource = null, $id = null)
    {
        if (empty($urls)) {
            return false;
        }

        $routes = array_column($urls, 'route');

        if (!empty($id) && !empty($module) && !empty($resource)) {
            $routes = $this->where([['route', $routes], ['module', '!=', $module], ['resource', '!=', $resource . '/' . $id]])->get_all();
        } else {
            $routes = $this->where('route', $routes)->get_all();
        }

        return $routes;
    }
}
