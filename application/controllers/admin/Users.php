<?php

class Users extends CI_Controller{

    public function isLoggedIn(){

        if($this->session->has_userdata("loggedIn")){
            return true;
        }

        return false;
    }

    public function index(){

        if(!$this->isLoggedIn()){
           redirect("admin/login");
        }

        $this->load->view("templates/header");
        
        $users = $this->useradmin_model->getAllUsers();
        if(!$users['success']){
            die($users['msg']);
        }else{
            $this->load->view("mainViews/studentListing",array("users"=>$users));
        }

        $this->load->view("templates/footer");
    }



}


