<?php defined('BASEPATH') OR exit('No direct script access allowed');

use catcool\models\Translation;

class TranslationManager extends My_DModel
{
    const ENTITY_NAME = 'catcool\models\Translation';

    //query su dung trong support tool
    private $_queries = [
        'find_by_all' => 'SELECT e FROM __TABLE_NAME__ e WHERE (e.lang_key LIKE :lang_key OR e.lang_value LIKE :lang_value) AND e.module_id = :module_id ORDER BY e.lang_key, e.id DESC',
        'find_by_id'  => 'SELECT e FROM __TABLE_NAME__ e WHERE e.id = :id',
        'find_by_ids' => 'SELECT e FROM __TABLE_NAME__ e WHERE e.id IN (:ids)',
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

        $entry = new Translation;
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
        $filter['lang_key']   = empty($filter['lang_key']) ? '%%' : '%'.$filter['lang_key'].'%';
        $filter['lang_value'] = empty($filter['lang_value']) ? '%%' : '%'.$filter['lang_value'].'%';

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
}
