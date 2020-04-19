<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Photo_album_description extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'photo_album_description';
        $this->primary_key = 'album_id';

        //khoa ngoai article_category
        $this->has_one['root'] = [
            'foreign_model' => 'photos/Photo_album',
            'foreign_table' => 'photo_album',
            'foreign_key'   => 'album_id',
            'local_key'     => 'album_id',
        ];

        $this->fillable = [
            'album_id',
            'language_id',
            'name',
            'description',
            'meta_title',
            'meta_description',
            'meta_keyword',
        ];
    }
}
