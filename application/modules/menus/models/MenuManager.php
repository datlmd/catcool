<?php defined('BASEPATH') OR exit('No direct script access allowed');

use menus\models\Menu;

class MenuManager extends My_DModel
{

    const ENTITY_NAME = 'menus\models\Menu';

    //query su dung trong support tool
    private $_queries = [
        'find_by_all' => 'SELECT e FROM __TABLE_NAME__ e WHERE e.title LIKE :title AND e.is_admin LIKE :is_admin AND e.language LIKE :language ORDER BY e.id DESC',
        'find_by_id'  => 'SELECT e FROM __TABLE_NAME__ e WHERE e.id = :id',
        'find_by_ids' => 'SELECT e FROM __TABLE_NAME__ e WHERE e.id IN (:ids)',
    ];

    private $_queries_frontend = [
        'find_menu_by_context' => "SELECT e FROM __TABLE_NAME__ e WHERE e.is_admin = :is_admin AND e.published = 'yes' AND e.language LIKE :language ORDER BY e.precedence DESC",
    ];

    function __construct() {
        parent::__construct();

        $this->init(self::ENTITY_NAME, $this->doctrine->em);
    }

    /**
     * Create table
     * @return bool
     */
    public function install()
    {
        try {
            $this->doctrine->tool->createSchema(array($this->em->getClassMetadata($this->entity)));
        } catch(Exception $err) {
            log_message("error", $err->getMessage(), false);
            return false;
        }

        return true;
    }

    /**
     * insert or update
     * @param $data
     * @param null $id
     * @return bool
     */
    public function create($data, $id = null)
    {
        if (empty($data)) {
            return false;
        }

        $entry = new Menu;
        foreach ($data as $key => $value) {
            $entry->$key($value);
        }

        //update
        if (!empty($id)) {
            $entry = $this->em->merge($entry);
        }

        // Save in db
        $result = $this->save($entry);
        if (empty($result)) {
            return false;
        }

        return $result;
    }

    /**
     * get by id
     * @param $id
     * @return bool
     */
    public function get_by_id($id)
    {
        if (empty($id)) {
            return false;
        }

        // Find post $this->get($id);
        $entry = $this->get_first($this->_queries['find_by_id'], ['id' => $id]);
        if (empty($entry)) {
            return false;
        }

        return $entry;
    }

    /**
     * Get all
     * @return bool
     */
    public function get_all_by_filter($filter = null, $limit = 0, $offset = 0)
    {
        $filter['language'] = empty($filter['language']) ? '%%' : '%'.$filter['language'].'%';
        $filter['title']    = empty($filter['title']) ? '%%' : '%'.$filter['title'].'%';
        $filter['is_admin'] = empty($filter['is_admin']) ? '%%' : '%'.$filter['is_admin'].'%';

        list($result, $total) = $this->get_array($this->_queries['find_by_all'], $filter, $limit, $offset, true);
        if (empty($result)) {
            return [false, 0];
        }

        return [$result, $total];
    }

    public function get_list_by_ids($ids)
    {
        if (empty($ids)) {
            return false;
        }

        if (!is_array($ids)) {
            $ids = explode(',', $ids);
        }

        $return = $this->get_array($this->_queries['find_by_ids'],['ids' => $ids]);
        if (empty($return)) {
            return false;
        }

        return $return;
    }

    public function get_menu_active($filter = null)
    {
        $filter['language'] = empty($filter['language']) ? '%%' : '%'.$filter['language'].'%';

        $result = $this->get_array($this->_queries_frontend['find_menu_by_context'], $filter);
        if (empty($result)) {
            return false;
        }

        return $result;
    }
}
