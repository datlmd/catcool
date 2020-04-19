<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Article_category_relationship extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'article_category_relationship';
        $this->primary_key = 'article_id';

        $this->has_one['article'] = [
            'foreign_model' =>'articles/Article',
            'foreign_table' =>'article',
            'foreign_key'   =>'article_id',
            'local_key'     =>'article_id',
        ];

        $this->has_one['category'] = [
            'foreign_model' =>'articles/Article_category',
            'foreign_table' =>'article_category',
            'foreign_key'   =>'category_id',
            'local_key'     =>'category_id',
        ];

        $this->fillable = [
            'category_id',
            'article_id',
        ];
    }
}
