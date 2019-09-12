<?php defined('BASEPATH') OR exit('No direct script access allowed');

class RelationshipManager extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table = 'relationships';
        $this->primary_key = 'id';
        $this->fillable = [
            'id',
            'candidate_table',
            'candidate_key',
            'foreign_table',
            'foreign_key',
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
        $filter['candidate_table LIKE'] = empty($filter['candidate_table']) ? '%%' : '%' . $filter['candidate_table'] . '%';
        $filter['foreign_table LIKE']   = empty($filter['foreign_table']) ? '%%' : '%' . $filter['foreign_table'] . '%';

        unset($filter['candidate_table']);
        unset($filter['foreign_table']);

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

    public function get_relationship($candidate_table, $candidate_key, $foreign_table, $foreign_key)
    {
        if (empty($candidate_table) || empty($candidate_key) || empty($foreign_table) || empty($foreign_key)) {
            return false;
        }

        $data = [
            'candidate_table' => $candidate_table,
            'candidate_key'   => $candidate_key,
            'foreign_table'   => $foreign_table,
            'foreign_key'     => $foreign_key,
        ];

        $return = $this->get_all($data);
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
            'candidate_key'   => $candidate_key,
            'foreign_table'   => $foreign_table,
        ];

        $return = $this->order_by(['id' => 'DESC'])->get_all($data);
        if (empty($return)) {
            return false;
        }

        return $return;
    }
}
