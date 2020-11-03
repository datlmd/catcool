<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//cache browser js css loader
defined('CACHE_TIME_CSS') OR define('CACHE_TIME_CSS', '20200419');
defined('CACHE_TIME_JS') OR define('CACHE_TIME_JS', '20200419');

// CAT COOL
defined('ALERT_SUCCESS') OR define('ALERT_SUCCESS', 'success'); // alert type
defined('ALERT_WARNING') OR define('ALERT_WARNING', 'warning'); // alert type
defined('ALERT_DANGER')  OR define('ALERT_DANGER', 'danger'); // alert type
defined('ALERT_ERROR')   OR define('ALERT_ERROR', 'danger'); // alert type

//pagination
defined('PAGINATION_DEFAULF_LIMIT')        OR define('PAGINATION_DEFAULF_LIMIT', 20);
defined('PAGINATION_MANAGE_DEFAULF_LIMIT') OR define('PAGINATION_MANAGE_DEFAULF_LIMIT', 20);

defined('CATCOOL_DASHBOARD')        OR define('CATCOOL_DASHBOARD', 'manage');

//publish status
defined('STATUS_ON')  OR define('STATUS_ON', 1);
defined('STATUS_OFF') OR define('STATUS_OFF', 0);

//comment status
defined('COMMENT_STATUS_OFF')  OR define('COMMENT_STATUS_OFF', 0); // t?t b«Ành lu?n
defined('COMMENT_STATUS_ON') OR define('COMMENT_STATUS_ON', 1); // t? ©Â?ng duy?t
defined('COMMENT_STATUS_CONFIRM') OR define('COMMENT_STATUS_CONFIRM', 2); // ch? duy?t

//gender
defined('GENDER_MALE')   OR define('GENDER_MALE', 1);
defined('GENDER_FEMALE') OR define('GENDER_FEMALE', 2);
defined('GENDER_OTHER')  OR define('GENDER_OTHER', 3);

// su dung cho url
defined('URL_LAST_SESS_NAME') OR define('URL_LAST_SESS_NAME', 'last_url');
defined('URL_LAST_FLAG')      OR define('URL_LAST_FLAG', 1);

//display list
defined('DISPLAY_LIST') OR define('DISPLAY_LIST', 'list');
defined('DISPLAY_GRID') OR define('DISPLAY_GRID', 'grid');

defined('UPLOAD_FILE_DIR')             OR define('UPLOAD_FILE_DIR', 'media/uploads/');
defined('UPLOAD_FILE_CACHE_DIR')       OR define('UPLOAD_FILE_CACHE_DIR', 'cache/');
defined('UPLOAD_IMAGE_DEFAULT')        OR define('UPLOAD_IMAGE_DEFAULT', 'content/common/images/img_default.png');
defined('RESIZE_IMAGE_DEFAULT_WIDTH')  OR define('RESIZE_IMAGE_DEFAULT_WIDTH', 1024);
defined('RESIZE_IMAGE_DEFAULT_HEIGHT') OR define('RESIZE_IMAGE_DEFAULT_HEIGHT', 960);
defined('RESIZE_IMAGE_THUMB_WIDTH')    OR define('RESIZE_IMAGE_THUMB_WIDTH', 300);
defined('RESIZE_IMAGE_THUMB_HEIGHT')   OR define('RESIZE_IMAGE_THUMB_HEIGHT', 400);

//menu position
defined('MENU_POSITION_MAIN')   OR define('MENU_POSITION_MAIN', 'main');
defined('MENU_POSITION_FOOTER') OR define('MENU_POSITION_FOOTER', 'footer');
defined('MENU_POSITION_TOP')    OR define('MENU_POSITION_TOP', 'top');
defined('MENU_POSITION_BOTTOM') OR define('MENU_POSITION_BOTTOM', 'bottom');
defined('MENU_POSITION_OTHER')  OR define('MENU_POSITION_OTHER', 'other');

//cache name
defined('SET_CACHE_NAME_MENU') OR define('SET_CACHE_NAME_MENU', 'menu_position');