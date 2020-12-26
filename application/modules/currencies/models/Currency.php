<?php defined("BASEPATH") OR exit("No direct script access allowed");

class Currency extends MY_Model
{
    const CURRENCY_CACHE_FILE_NAME = 'currencies';
    
    public function __construct()
    {
        parent::__construct();

        $this->db_table    = "currency";
        $this->primary_key = "currency_id";

        $this->fillable = [
            "currency_id",
            "name",
            "code",
            "symbol_left",
            "symbol_right",
            "decimal_place",
            "value",
            "published",
            "ctime",
            "mtime",
        ];
    }

    public function get_all_by_filter($filter = null, $limit = 0, $offset = 0)
    {
        $filter['name LIKE'] = empty($filter['name']) ? '%%' : '%' . $filter['name'] . '%';
        unset($filter['name']);

        $total = $this->count_rows($filter);

        if (!empty($limit) && isset($offset)) {
            $result = $this->limit($limit,$offset)->order_by(['currency_id' => 'DESC'])->get_all($filter);
        } else {
            $result = $this->order_by(['currency_id' => 'DESC'])->get_all($filter);
        }

        if (empty($result)) {
            return [false, 0];
        }

        return [$result, $total];
    }

    public function get_list_by_publish($published = STATUS_ON, $is_cache = true)
    {

        if ($is_cache) {
            $return = $this->set_cache(self::CURRENCY_CACHE_FILE_NAME, 86400*30)->order_by(['currency_id' => 'ASC'])->get_all(['published' => $published]);
        } else {
            $return = $this->order_by(['currency_id' => 'ASC'])->get_all(['published' => $published]);
        }

        if (empty($return)) {
            return false;
        }

        return $return;
    }

    public function update_currency()
    {
        $curl = curl_init();

        //&symbols = USD,AUD,CAD,PLN,MXN
        curl_setopt($curl, CURLOPT_URL, 'http://data.fixer.io/api/latest?access_key=' . config_item('fixer_io_access_key'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($curl);

        curl_close($curl);

        $response_info = json_decode($response, true);

        if (is_array($response_info) && isset($response_info['rates'])) {
            // Compile all the rates into an array
            $currencies = array();

            $default           = config_item('currency');
            $currencies['EUR'] = 1.0000;

            foreach ($response_info['rates'] as $key => $value) {
                $currencies[$key] = $value;
            }

            $results = $this->get_list_by_publish();
            foreach ($results as $result) {
                if (isset($currencies[$result['code']])) {
                    $from = $currencies['EUR'];

                    $to = $currencies[$result['code']];

                    $result['value'] = 1 / ($currencies[$default] * ($from / $to));
                    $this->update($result, $result['currency_id']);
                }
            }
        } else {
            return false;
        }

        $this->delete_cache(self::CURRENCY_CACHE_FILE_NAME);

        return true;
    }
}
