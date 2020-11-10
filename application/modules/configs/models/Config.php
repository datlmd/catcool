<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'config';
        $this->primary_key = 'id';

        $this->fillable = [
            'id',
            'config_key',
            'config_value',
            'description',
            'user_id',
            'group_id',
            'published',
            'ctime',
            'mtime',
        ];
    }

    /**
     * Get list all
     *
     * @param null $filter
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function get_all_by_filter($filter = null, $limit = 0, $offset = 0)
    {
        $total = $this->count_rows($filter);

        if (!empty($limit) && isset($offset)) {
            $result = $this->limit($limit,$offset)->order_by(['id' => 'DESC'])->get_all($filter);
        } else {
            $result = $this->order_by(['id' => 'DESC'])->get_all($filter);
        }

        if (empty($result)) {
            return [false, 0];
        }

        return [$result, $total];
    }

    public function get_list_by_publish($published = STATUS_ON)
    {
        $return = $this->get_all(['published' => $published]);
        if (empty($return)) {
            return false;
        }

        return $return;
    }

    public function write_file()
    {
        try {

            $this->load->model("languages/Language", 'Language');

            $list_language_config = [];
            $list_language = $this->Language->get_list_by_publish();
            foreach ($list_language as $key => $value) {
                unset($value['ctime']);
                unset($value['mtime']);
                $list_language_config[$value['id']] = $value;

            }

            $settings = $this->get_list_by_publish();

            // file content
            $file_content = "<?php \n\n";
            if (!empty($settings)) {
                foreach ($settings as $setting) {
                    $config_value = $setting['config_value'];
                    if (is_numeric($config_value) || is_bool($config_value) || in_array($config_value, ['true', 'false', 'TRUE', 'FALSE']) || strpos($config_value, '[') !== false) {
                        $config_value = $config_value;
                    } else if ($setting['config_key'] == 'file_mime_allowed') {
                        $config_value = str_replace("'", '"', $config_value);
                        $config_value = sprintf("'%s'", $config_value);
                    } else {
                        $config_value = str_replace('"', "'", $config_value);
                        $config_value = sprintf('"%s"', $config_value);
                    }

                    if (!empty($list_language_config) && $setting['config_key'] == 'list_language_cache') {
                        $config_value = "'" . json_encode($list_language_config) . "'";
                    }

                    if (!empty($setting['description'])) {
                        $file_content .= "//" . $setting['description'] . "\n";
                    }

                    $file_content .= "\$config['" . $setting['config_key'] . "'] = " . $config_value . ";\n\n";
                }
            }

            write_file(CATCOOLPATH . 'media/config/config.php', $file_content);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}
