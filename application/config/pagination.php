<?php
defined('BASEPATH') OR exit('No direct script access allowed');

defined('PAGINATION_CLASS')     OR define('PAGINATION_CLASS', 'pagination float-right');

$config['per_page']           = PAGINATION_DEFAULF_LIMIT;
$config["uri_segment"]        = 3;
$config['use_page_numbers']   = TRUE;
$config['reuse_query_string'] = TRUE;
$config["num_links"]          = 5; // so luong phan trang se hien thi

$config['page_query_string']    = TRUE;
$config['query_string_segment'] = 'page';

$config['reuse_query_string'] = TRUE; //keep filter TRUE
$config['display_pages']      = TRUE; //for example, you only want ¡Ènext¡É and ¡Èprevious¡É links

$config['attributes'] = ['class' => 'page-link'];

$config['full_tag_open']  = '<ul class="' . PAGINATION_CLASS . '">';
$config['full_tag_close'] = '</ul>';

$config['first_link']      = lang('pagination_first'); //OR FALSE
$config['first_tag_open']  = '<li class="page-item first">';
$config['first_tag_close'] = '</li>';

$config['last_link']      = lang('pagination_last');
$config['last_tag_open']  = '<li class="page-item last">';
$config['last_tag_close'] = '</li>';

$config['next_link']      = lang('pagination_next');
$config['next_tag_open']  = '<li class="page-item next">';
$config['next_tag_close'] = '</li>';

$config['prev_link']      = lang('pagination_prev');
$config['prev_tag_open']  = '<li class="page-item prev">';
$config['prev_tag_close'] = '</li>';

$config['cur_tag_open']  = '<li class="page-item active"><span class="page-link">';
$config['cur_tag_close'] = '</span></li>';

$config['num_tag_open']  = '<li class="page-item numlink">';
$config['num_tag_close'] = '</li>';