<?php defined('BASEPATH') OR exit('No direct script access allowed');

use relationships\models\Relationship;

class RelationshipManager extends My_DModel
{
    const ENTITY_NAME = 'relationships\models\Relationship';

    //query su dung trong support tool
    private $_queries = [
        'find_by_all' => 'SELECT e FROM __TABLE_NAME__ e WHERE (e.candidate_table LIKE :candidate_table OR e.foreign_table LIKE :foreign_table) ORDER BY e.id DESC',
        'find_by_id'  => 'SELECT e FROM __TABLE_NAME__ e WHERE e.id = :id',
        'find_by_ids' => 'SELECT e FROM __TABLE_NAME__ e WHERE e.id IN (:ids)',
        'find_relationship' => 'SELECT e FROM __TABLE_NAME__ e WHERE e.candidate_table = :candidate_table AND e.candidate_key = :candidate_key AND e.foreign_table = :foreign_table AND e.foreign_key = :foreign_key',
        'find_by_candidate' => 'SELECT e FROM __TABLE_NAME__ e WHERE e.candidate_table = :candidate_table AND e.candidate_key = :candidate_key AND e.foreign_table = :foreign_table ORDER BY e.id DESC',
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
        // Create new post
        if (empty($id)) {
            $entry = new Relationship;
        } else {
            $entry = $this->get($id);

            if (empty($entry)) {
                return false;
            }
        }

        $entry->candidate_table($data['candidate_table']);
        $entry->candidate_key($data['candidate_key']);
        $entry->foreign_table($data['foreign_table']);
        $entry->foreign_key($data['foreign_key']);

        // Save in db
        if (!$this->save($entry)) {
            return false;
        }

        return true;
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
        $filter['candidate_table']    = empty($filter['candidate_table']) ? '%%' : '%'.$filter['candidate_table'].'%';
        $filter['foreign_table']  = empty($filter['foreign_table']) ? '%%' : '%'.$filter['foreign_table'].'%';

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

    public function get_relationship($candidate_table, $candidate_key, $foreign_table, $foreign_key)
    {
        if (empty($candidate_table) || empty($candidate_key) || empty($foreign_table) || empty($foreign_key)) {
            return false;
        }

        $data = [
            'candidate_table' => $candidate_table,
            'candidate_key' => $candidate_key,
            'foreign_table' => $foreign_table,
            'foreign_key' => $foreign_key,
        ];

        $return = $this->get_first($this->_queries['find_relationship'], $data);
        if (empty($return)) {
            return false;
        }

        return $return;
    }

    public function get_candidate($candidate_table, $foreign_table, $candidate_key)
    {
        if (empty($candidate_table) || empty($foreign_table) || empty($candidate_key)) {
            return false;
        }

        $data = [
            'candidate_table' => $candidate_table,
            'candidate_key' => $candidate_key,
            'foreign_table' => $foreign_table,
        ];

        $return = $this->get_array($this->_queries['find_by_candidate'], $data);
        if (empty($return)) {
            return false;
        }

        return $return;
    }
}
