<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Farm extends MY_Model
{
    public $_table_suffix_format = "_%s";

    public function __construct()
    {
        parent::__construct();
    }

    function get_table_name_year($date = null)
    {
        if (empty($date)) {
            $date = time();
        }
        $postfix = date('Y', $date);

        // create table name
        $table_suffix   = sprintf($this->_table_suffix_format, $postfix);

        $db_table = explode("_", $this->db_table);
        $this->db_table = $db_table[0] . $table_suffix;

        return $this->db_table;
    }
}
