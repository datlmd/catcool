<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Article_category_description_manager extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'article_category_description';
        $this->primary_key = 'category_id';

        //khoa ngoai article_category
        $this->has_one['root'] = [
            'articles/Article_category_manager',
            'category_id',
            'category_id'
        ];

        $this->fillable = [
            'category_id',
            'language_id',
            'title',
            'slug',
            'description',
            'context',
            'meta_title',
            'meta_description',
            'meta_keyword',
        ];
    }
}
