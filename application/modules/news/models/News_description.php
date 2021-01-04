<?php defined('BASEPATH') OR exit('No direct script access allowed');

class News_description extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'news_description';
        $this->primary_key = 'news_id';

        $this->has_one['root'] = [
            'foreign_model' => 'news/News',
            'foreign_table' => 'news',
            'foreign_key'   => 'news_id',
            'local_key'     => 'news_id',
        ];

        $this->fillable = [
            'news_id',
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
