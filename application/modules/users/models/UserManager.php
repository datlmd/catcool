<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use users\models\User;

class UserManager extends My_DModel
{
    const ENTITY_NAME = 'users\models\User';

    //query su dung trong support tool
    private $_queries = [
        'find_by_all' => 'SELECT e FROM __TABLE_NAME__ e WHERE e.title LIKE :title AND e.language LIKE :language ORDER BY e.id DESC',
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
        // Create new post
        if (empty($id)) {
            $entry = new User;
        } else {
            $entry = $this->get($id);

            if (empty($entry)) {
                return false;
            }
        }

        $entry->title($data['title']);
        $entry->description($data['description']);
                $entry->username($data['username']);
                $entry->password($data['password']);
                $entry->email($data['email']);
                $entry->activation_selector($data['activation_selector']);
                $entry->activation_code($data['activation_code']);
                $entry->forgotten_password_selector($data['forgotten_password_selector']);
                $entry->forgotten_password_code($data['forgotten_password_code']);
                $entry->forgotten_password_time($data['forgotten_password_time']);
                $entry->remember_selector($data['remember_selector']);
                $entry->remember_code($data['remember_code']);
                $entry->created_on($data['created_on']);
                $entry->last_login($data['last_login']);
                $entry->active($data['active']);
                $entry->first_name($data['first_name']);
                $entry->last_name($data['last_name']);
                $entry->company($data['company']);
                $entry->phone($data['phone']);
                $entry->address($data['address']);
                $entry->dob($data['dob']);
                $entry->gender($data['gender']);
                $entry->image($data['image']);
                $entry->super_admin($data['super_admin']);
                $entry->status($data['status']);
                $entry->is_delete($data['is_delete']);
                $entry->ip_address($data['ip_address']);
        $entry->language($data['language']);
        $entry->precedence($data['precedence']);
        $entry->published($data['published']);

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
        $filter['language'] = empty($filter['language']) ? '%%' : '%'.$filter['language'].'%';
        $filter['title']    = empty($filter['title']) ? '%%' : '%'.$filter['title'].'%';

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
