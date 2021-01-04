<?php defined('BASEPATH') OR exit('No direct script access allowed');

class News_category_description extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'news_category_description';
        $this->primary_key = 'category_id';

        $this->has_one['root'] = [
            'foreign_model' => 'news/News_category',
            'foreign_table' => 'news_category',
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
