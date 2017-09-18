<?php

class Submissions extends CI_Controller{

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
        
        $submissions = $this->submission_model->getAllSubmission();
        if(!$submissions['success']){
            die($submissions['msg']);
        }else{
            $this->load->view("mainViews/submissionListing",array("submissions"=>$submissions));
        }

        $this->load->view("templates/footer");

    }



    public function view($id = null){

        if(!$this->isLoggedIn()){
           redirect("admin/login");
        }

        if($id == null){
            redirect("admin/submissions");
        }


        $checkIfSubmission = $this->submission_model->hasSubmission($id);

        if(!$checkIfSubmission){
            redirect("admin/submissions");
        }

       
        //print_r($data);

        $this->load->view("templates/header");
        
        $submissions = $this->submission_model->getSubmissionByID($id);
        if(!$submissions['success']){
            die($submissions['msg']);
        }else{
            //print_r($submissions);
            $viewResponse = array();
            if($this->session->flashdata("approvalStatus")){
                $viewResponse['approvalStatus'] = $this->session->flashdata("approvalStatus");
            }
            $postData = $this->input->post();
            //print_r($postData);
            if(isset($postData['approved']) && !empty($postData['approved'])){
                $approvaStatus = $postData['approved'];
                
                if($approvaStatus == "true"){
                    $approval = $this->submission_model->approveProject($id,true);
                    $this->session->set_flashdata('approvalStatus',$approval);
                    redirect("admin/submissions/view/" .$id);
                }else if ($approvaStatus == "false"){
                    $this->submission_model->approveProject($id,false);
                    $this->session->set_flashdata('approvalStatus',$approval);
                    redirect("admin/submissions/");
                }   
            }
            $viewResponse['submissions'] = $submissions;
            $this->load->view("mainViews/submissionView",$viewResponse);
        }

        $this->load->view("templates/footer");

    }



}