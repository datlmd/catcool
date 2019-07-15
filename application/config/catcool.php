<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$config['base_url'] = 'http://localhost/dev/catcool/';

// language
$config['language'] = 'vn';
$config['is_multi_language'] = TRUE;
$config['multi_language'] = ['vn' => 'vietnam', 'english' => 'english'];
$config['is_show_select_language'] = TRUE;

$config['authentication'] = function() {
    return true;
};
$config['backends'][] = array(
    'name'         => 'default',
    'adapter'      => 'local',
    'baseUrl'      => '/demo/upload/',
//  'root'         => '', // Can be used to explicitly set the CKFinder user files directory.
    'chmodFiles'   => 0777,
    'chmodFolders' => 0755,
    'filesystemEncoding' => 'UTF-8',
);