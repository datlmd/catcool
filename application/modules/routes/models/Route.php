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

    public function get_list_available($urls)
    {
        if (empty($urls)) {
            return false;
        }

        $routes = [];
        foreach(get_list_lang() as $key => $value) {
            if(empty($urls[$key]['route'])) {
                continue;
            }

            if (!empty($urls[$key]['id'])) {
                $route = $this->where([['route', $urls[$key]['route']], ['id', '!=', $urls[$key]['id']]])->get();
            } else {
                $route = $this->where('route', $urls[$key]['route'])->get();
            }

            if (!empty($route)) {
                $routes[] = $route;
            }
        }

        return $routes;
    }

    public function write_file()
    {
        try {
            $this->load->helper('file');

            $routers = $this->get_list_by_publish();
            // file content
            $file_content = "<?php \n\n";
            if (!empty($routers)) {
                foreach ($routers as $router) {
                    $file_content .= "\$route['" . $router['route'] . "'] = '" . $router['module'] . "/" . $router['resource'] . "';\n";
                }
            }

            write_file(CATCOOLPATH . 'media/config/routes.php', $file_content);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    public function save_route($urls, $module, $resource)
    {
        if (empty($urls) || empty($module) || empty($resource)) {
            return false;
        }

        foreach (get_list_lang() as $key => $value) {
            if (empty($urls[$key]['route'])) {
                continue;
            }
            if (!empty($urls[$key]['id'])) {
                $this->update($urls[$key], $urls[$key]['id']);
            } else {
                $route_data = [
                    'module'      => $module,
                    'resource'    => $resource,
                    'language_id' => $key,
                    'route'       => $urls[$key]['route'],
                    'user_id'     => $this->session->userdata('user_id'),
                    'published'   => STATUS_ON,
                    'ctime'       => get_date(),
                ];
                $this->insert($route_data);
            }
        }
        $this->write_file();

        return true;
    }
}
