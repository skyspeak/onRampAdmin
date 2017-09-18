<?php

class Useradmin_Model extends CI_Model{

    public function __construct(){
        $this->load->database();
    }

     public function getAllUsers(){

        $returnResponse =array();

        $query = $this->db->get("clientuser");
        if($query){
            $returnResponse['success'] =true;
            
            $users = $query->result_array();

            $finalUsers = array();
            foreach($users as $user){
                unset($user['userClient_password']);
                $user['userClient_name'] = $user['userClient_firstName'] . " ". $user['userClient_lastName'];
                $finalUsers[] = $user;
            }

            $returnResponse['data']= $finalUsers;
        }else{
            $returnResponse['success'] =false;
            $returnResponse['msg'] = "Internal Error";
        }

        return $returnResponse;
    }

}