<?php
require_once(APPPATH . "models/doctrine/entities/User.php");


class User_manager extends My_DModel {

    function __construct() {
        parent::__construct();


        $this->init("User",$this->doctrine->em);
    }

    public function createUser()
    {
        return new User();
    }

    public function save_user($data,$id = NULL)
    {
//        if(empty($id)){
//            $user = $this->createUser();
//        }
//        else{
            $user = $this->get($id);
        //}
//        $user->username = $data["user_name"];
//        $user->email = $data["email"];
        echo "<pre>";
        print_r($user);
        //$this->save($user);

        return true;
    }

}