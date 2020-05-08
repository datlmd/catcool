<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Member_token extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'member_token';
        $this->primary_key = 'member_id';

        $this->fillable = [
            'member_id',
            'remember_selector',
            'remember_code',
            'ip',
            'agent',
            'platform',
            'browser',
            'location',
            'ctime',
            'mtime'
        ];
    }

    public function add_token($member_id, $token)
    {
        if (empty($member_id) || empty($token)) {
            return false;
        }
        try {
            //set token login auto bang cookie
            $this->load->library('user_agent');

            $getloc = json_decode(file_get_contents("http://ipinfo.io/"));

            $data_token = [
                'member_id'         => $member_id,
                'remember_selector' => $token['selector'],
                'remember_code'     => $token['validator_hashed'],
                'ip'                => get_client_ip(),
                'agent'             => $this->agent->agent_string(),
                'platform'          => $this->agent->platform(),
                'browser'           => $this->agent->browser(),
                'location'          => sprintf("%s, %s, %s", $getloc->city, $getloc->region, $getloc->country) ,
            ];

            $user_token = $this->where(['member_id' => $member_id, 'agent' => $this->agent->agent_string()])->get();
            if (empty($user_token)) {
                $data_token['ctime'] = get_date();
                $this->insert($data_token);
            } else {
                $this->update($data_token, ['remember_selector' => $user_token['remember_selector']]);
            }

        } catch (Exception $ex) {
            error_log($ex->getMessage());
        }

        return true;
    }

    public function delete_token($token)
    {
        if (empty($token)) {
            return false;
        }

        $user_token = $this->get(['remember_selector' => $token['selector']]);
        if (!empty($user_token)) {
            $this->delete(['remember_selector' => $user_token['remember_selector']]);
        }

        return true;
    }
}
