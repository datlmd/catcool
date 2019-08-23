<?php defined('BASEPATH') OR exit('No direct script access allowed');

use catcool\models\Module;

class ModuleManager extends My_DModel
{
    const ENTITY_NAME = 'catcool\models\Module';

    //query su dung trong support tool
    private $_queries = [
        'find_by_all' => 'SELECT e FROM __TABLE_NAME__ e WHERE e.module LIKE :module OR e.sub_module LIKE :sub_module ORDER BY e.id DESC',
        'find_by_id'  => 'SELECT e FROM __TABLE_NAME__ e WHERE e.id = :id',
        'find_by_ids' => 'SELECT e FROM __TABLE_NAME__ e WHERE e.id IN (:ids)',
        'find_by_publish' => 'SELECT e FROM __TABLE_NAME__ e WHERE e.published = :published ORDER BY e.id DESC',
    ];

    function __construct() {
        parent::__construct();

        $this->init(self::ENTITY_NAME, $this->doctrine->em);
    }

    /**
     * Create table
     *
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
     *
     * @param $data
     * @param null $id
     * @return bool
     */
    public function create($data, $id = null)
    {
        if (empty($data)) {
            return false;
        }

        $entry = new Module;
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
     *
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
     *
     * @return bool
     */
    public function get_all_by_filter($filter = null, $limit = 0, $offset = 0)
    {
        $filter['module'] = empty($filter['module']) ? '%%' : '%'.$filter['module'].'%';
        $filter['sub_module']    = empty($filter['sub_module']) ? '%%' : '%'.$filter['sub_module'].'%';

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

    public function get_list_by_publish($published = STATUS_ON)
    {
        if (empty($published)) {
            return false;
        }

        $return = $this->get_array($this->_queries['find_by_publish'], ['published' => $published]);
        if (empty($return)) {
            return false;
        }

        return $return;
    }
}
