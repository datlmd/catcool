<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use users\models\User;

class UserManager extends My_DModel
{
    const ENTITY_NAME = 'users\models\User';

    //query su dung trong support tool
    private $_queries = [
        'find_by_all' => 'SELECT e FROM __TABLE_NAME__ e WHERE e.username LIKE :username OR e.email LIKE :email OR e.phone LIKE :phone ORDER BY e.id DESC',
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

        if (isset($data['username']))
            $entry->username($data['username']);

        if (isset($data['password']))
            $entry->password($data['password']);

        if (isset($data['email']))
            $entry->email($data['email']);

        if (isset($data['activation_selector']))
            $entry->activation_selector($data['activation_selector']);

        if (isset($data['activation_code']))
            $entry->activation_code($data['activation_code']);

        if (isset($data['forgotten_password_selector']))
            $entry->forgotten_password_selector($data['forgotten_password_selector']);

        if (isset($data['forgotten_password_code']))
            $entry->forgotten_password_code($data['forgotten_password_code']);

        if (isset($data['forgotten_password_time']))
            $entry->forgotten_password_time($data['forgotten_password_time']);

        if (isset($data['remember_selector']))
            $entry->remember_selector($data['remember_selector']);

        if (isset($data['remember_code']))
            $entry->remember_code($data['remember_code']);

        if (isset($data['active']))
            $entry->active($data['active']);

        if (isset($data['first_name']))
        $entry->first_name($data['first_name']);

        if (isset($data['middle_name']))
            $entry->middle_name($data['middle_name']);

        if (isset($data['last_name']))
            $entry->last_name($data['last_name']);

        if (isset($data['company']))
            $entry->company($data['company']);

        if (isset($data['phone']))
            $entry->phone($data['phone']);

        if (isset($data['address']))
            $entry->address($data['address']);

        if (isset($data['dob']))
            $entry->dob($data['dob']);

        if (isset($data['gender']))
            $entry->gender($data['gender']);

        if (isset($data['image']))
            $entry->image($data['image']);

        if (isset($data['super_admin']))
            $entry->super_admin($data['super_admin']);

        if (isset($data['status']))
            $entry->status($data['status']);

        if (isset($data['is_delete']))
            $entry->is_delete($data['is_delete']);

        if (isset($data['ip_address']))
            $entry->ip_address($data['ip_address']);

        if (isset($data['created_on']))
            $entry->created_on($data['created_on']);

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
        $filter['username'] = empty($filter['username']) ? '%%' : '%'.$filter['username'].'%';
        $filter['email']    = empty($filter['email']) ? '%%' : '%'.$filter['email'].'%';
        $filter['phone']    = empty($filter['phone']) ? '%%' : '%'.$filter['phone'].'%';

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
