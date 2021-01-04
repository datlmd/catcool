<?php defined('BASEPATH') OR exit('No direct script access allowed');

class News_category_relationship extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'news_category_relationship';
        $this->primary_key = 'news_id';

        $this->has_one['news'] = [
            'foreign_model' =>'news/News',
            'foreign_table' =>'news',
            'foreign_key'   =>'news_id',
            'local_key'     =>'news_id',
        ];

        $this->has_one['category'] = [
            'foreign_model' =>'news/News_category',
            'foreign_table' =>'news_category',
            'foreign_key'   =>'category_id',
            'local_key'     =>'category_id',
        ];

        $this->fillable = [
            'category_id',
            'news_id',
        ];
    }
}
