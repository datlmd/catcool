<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use menus\models\Menu;

class MenuManager extends My_DModel
{

    const ENTITY_NAME = 'menus\models\Menu';

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
        // Create new post
        if (empty($id)) {
            $entry = new Menu;
        } else {
            $entry = $this->get($id);

            if (empty($entry)) {
                return false;
            }
        }

        $entry->title($data['title']);
        $entry->description($data['description']);
        $entry->slug($data['slug']);
        $entry->context($data['context']);
        $entry->user_id($data['user_id']);
        $entry->parent_id($data['parent_id']);
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
     * @param $id
     * @return bool
     */
    public function findById($id)
    {
        if (empty($id)) {
            return false;
        }

        // Find post $this->get($id);
        $entry = $this->findFirst($this->_queries['find_by_id'], ['id' => $id]);
        if (empty($entry)) {
            return false;
        }

        return $entry;
    }

    /**
     * Get all
     * @return bool
     */
    public function findAll($filter = null, $limit = 0, $offset = 0)
    {
        $filter['language'] = empty($filter['language']) ? '%%' : '%'.$filter['language'].'%';
        $filter['title']    = empty($filter['title']) ? '%%' : '%'.$filter['title'].'%';

        list($result, $total) = $this->toArray($this->_queries['find_by_all'], $filter, $limit, $offset, true);
        if (empty($result)) {
            return [false, 0];
        }

        return [$result, $total];
    }

    public function findListByIds($ids)
    {
        if (empty($ids)) {
            return false;
        }

        if (!is_array($ids)) {
            $ids = explode(',', $ids);
        }

        $return = $this->toArray($this->_queries['find_by_ids'],['ids' => $ids]);
        if (empty($return)) {
            return false;
        }

        return $return;
    }
}
