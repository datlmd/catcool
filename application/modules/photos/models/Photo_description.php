<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Photo_description extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'photo_description';
        $this->primary_key = 'photo_id';

        //khoa ngoai
        $this->has_one['root'] = [
            'foreign_model' => 'photos/Photo',
            'foreign_table' => 'photo',
            'foreign_key'   => 'photo_id',
            'local_key'     => 'photo_id',
        ];

        $this->fillable = [
            'photo_id',
            'language_id',
            'name',
            'description',
            'meta_title',
            'meta_description',
            'meta_keyword',
        ];
    }
}
