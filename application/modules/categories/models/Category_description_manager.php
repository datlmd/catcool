<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Category_description_manager extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'category_description';
        $this->primary_key = 'category_id';

        //khoa ngoai article_category
        $this->has_one['root'] = [
            'foreign_model' => 'categories/Category_manager',
            'foreign_table' => 'category',
            'foreign_key'   => 'category_id',
            'local_key'     => 'category_id',
        ];

        $this->fillable = [
            'category_id',
            'language_id',
            'name',
            'slug',
            'description',
            'meta_title',
            'meta_description',
            'meta_keyword',
        ];
    }
}
