<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_description_manager extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'menu_description';
        $this->primary_key = 'menu_id';

        //khoa ngoai article_category
        $this->has_one['root'] = [
            'foreign_model' => 'menus/Menu_manager',
            'foreign_table' => 'menu',
            'foreign_key'   => 'menu_id',
            'local_key'     => 'menu_id',
        ];

        $this->fillable = [
            'menu_id',
            'language_id',
            'name',
            'description',
        ];
    }
}
