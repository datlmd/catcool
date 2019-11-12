<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Article_description_manager extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'article_description';
        $this->primary_key = 'article_id';

        //khoa ngoai article_category
        $this->has_one['root'] = [
            'foreign_model' =>'articles/Article_manager',
            'foreign_table' =>'article',
            'foreign_key'   =>'article_id',
            'local_key'     =>'article_id',
        ];

        $this->fillable = [
            'article_id',
            'language_id',
            'name',
            'slug',
            'description',
            'content',
            'meta_title',
            'meta_description',
            'meta_keyword',
        ];
    }
}
