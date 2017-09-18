<?php

class Admin_Model extends CI_Model{

    public function __construct(){
        $this->load->database();
    }


    public function registerAdmin($data){
        if(!empty($data)){
            if($this->db->insert("adminuser",$data)){
                return true;
            }
        }

        return false;

    }

    public function loginAdmin($data){

        if(!empty($data)){
            $response = $this->db->get_where("adminuser",$data);
            if($response->num_rows() == 1){
                $data = $response->row_array();
                unset($data['password']);
                
                //if($data['active'] != 0){
                 if($data['active'] == 0){
                    return array('success'=>false,'msg'=>"Activate Your Account to Login. Check your Inbox :D");
                }
                return array('success'=>true,'data' =>$data,'msg'=>"Login Successful"); 
            }else{
                return array('success'=>false,'msg'=>"Incorrect Email/Password");
            }
        }else{
            return array('success'=>false,'msg'=>"Internal Error");
        }


    }

    public function isAdminExists($data){
       // die($data);
        $response = $this->db->get_where("adminuser",$data);
        //die($data);
        //print_r($response->row_array());
        //echo $response->num_rows();
        //if(empty($response->row_array())){
        if($response->num_rows()>=1){
            return true;
        }
            
        return false;
    


    }

        public function activateAccount($email){

        $isAdmin = $this->isAdminExists(array("email"=>$email));

        if(!$isAdmin){

            return array("success"=>false,"msg"=>"User not Found");
        }

        $this->db->where("email",$email);
        $updateActive = $this->db->update("adminuser",array("active"=>1));
        if($updateActive){
            return array("success"=>true,"msg"=>"Activated");
        }else{
            return array("success"=>false,"msg"=>"Internal Error");
        }

    }

}