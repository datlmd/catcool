<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Farm extends MY_Model
{
    var $_table_suffix_format = "_%s";

    public function __construct()
    {
        parent::__construct();
    }

    function get_table_name_year($date)
    {
        if (empty($date)) {
            $date = get_date();
        }
        $postfix = date('Y', strtotime($date));

        // create table name
        $table_suffix   = sprintf($this->_table_suffix_format, $postfix);
        $this->db_table = $this->db_table . $table_suffix;

        return $this->db_table;
    }
}
