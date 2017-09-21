<?php
require APPPATH . 'libraries/sendgrid-php/sendgrid-php.php';
define('SENDGRIDAPI','SENDGRID_API_KEY');
define('SENDER','SENDER_EMAIL');

class  Admin extends CI_Controller{

    public function isLoggedIn(){

        if($this->session->has_userdata("loggedIn")){
            return true;
        }

        return false;
    }

    public function generateEmail($email,$name,$message){
           //print("testing sendgrid");
        $from = new SendGrid\Email("Flex Academy", SENDER);
        $subject = "Hi There ! Confirm thy Email";
        $to = new SendGrid\Email($name, $email);
        $content = new SendGrid\Content("text/plain", $message);
        $mail = new SendGrid\Mail($from, $subject, $to, $content);

        $apiKey = SENDGRIDAPI;
        $sg = new \SendGrid($apiKey);
        //echo "<br/>";
        $response = $sg->client->mail()->send()->post($mail);
    }

    public function activate(){
        ///echo "works";
        $items = $this->input->get();
        if(!isset($items['code']) || !isset($items['email'])){
            die("Invalid Request");
        }else{
            $code = $items['code'];
            $email = $items['email'];
            if($this->decodeEmailToken($code,$email)){

                $activation = $this->admin_model->activateAccount($email);
                if($activation['success']){
                    redirect("/admin/login");
                }else{
                    die($activation['msg']);
                }


            }else{
                die("Invalid Code");
            }
        }
    }

     public function index(){
        redirect("admin/register");
     
    }

    public function generateCodeForEmail($email){
        $code = md5($email."testDriveAlpha");
        $code = strrev($code);
        $code = base64_encode($code);
        $code = strrev($code);
        $code =base64_encode($code);
        $code = str_replace("=","",$code);
        return $code;
    }

    public function decodeEmailToken($code , $email){
            
            try{
                //$spliter = explode("&email=", $code);
                
                //$email = $spliter[1];
                $emailsalt = md5($email."testDriveAlpha");

                //$code = $spliter[0];

                $code = base64_decode($code);
                $code = strrev($code);
                $code = base64_decode($code);
                $code = strrev($code);
                // echo "<br/>";
                // print($code . "|"  . $emailsalt);
                if($code ==  $emailsalt){
                    return true;
                }
            }catch(Exception $e){
                return false;
            }



            return false;
    }

    public function register(){

        
        if($this->isLoggedIn()){
           redirect("admin/login");
        }

        $this->form_validation->set_rules("name","Full Name","required");
        // $this->form_validation->set_rules("username","Username","required|callback_check_username_exists");
        $this->form_validation->set_rules("email","Email","required|valid_email|callback_check_email_exists");
        $this->form_validation->set_rules("password","Password","required");

        $this->load->view("templates/header");

        if($this->form_validation->run() == false){
            $this->load->view("mainViews/register");
        }else{
            $data = array(
                // 'username'=> $this->input->post("username"),
                'password'=>md5($this->input->post("password")),
                'name'=> $this->input->post("name"),
                'email'=>$this->input->post("email")
                );


           // die($data);
           $checkifAdmin =$this->admin_model->isAdminExists(array("email"=>$data['email']));

            if(!$checkifAdmin){

               
            $response = $this->admin_model->registerAdmin($data);
            if($response){
                //have t handle this in the view
                $code = $this->generateCodeForEmail($data['email']);
                $emailMessage = "Hi " . $data['name'] . ", \n Please follow the below link to activate your Flex Account. \n " . base_url() . "admin/activate?email=" . $data['email'] . "&code=" . $code;    
                
                $this->generateEmail($data['email'],$data['name'],$emailMessage);

                 $registerStatus = array("success"=>true,"msg"=>"You have been registered. Check your email to verify your account");
                 $this->session->set_flashdata('registerStatus',$registerStatus);
                 redirect("/admin/login");

            }else{
                $registerStatus = array("success"=>false,"msg"=>"Oops Something went wrong.");
               //$this->session->set_flashdata('registerFailed',$registerStatus);
                $this->load->view("mainViews/register",array("registerStatus"=>$registerStatus));
            }

            }else{
                 $registerStatus = array("success"=>false,"msg"=>"Accounted Associated with " . $data['email'] . "already exists.");
               //$this->session->set_flashdata('registerFailed',$registerStatus);
                $this->load->view("mainViews/register",array("registerStatus"=>$registerStatus));

            }


        }

        $this->load->view("templates/footer");

    }

        //Login Code for Admin
        public function login(){
        
        if($this->isLoggedIn()){
           redirect("admin/login");
        }
        $this->form_validation->set_rules("email","Email","required");
        $this->form_validation->set_rules("password","Password","required");

        $this->load->view("templates/header");

        if($this->form_validation->run() == false){
            //print_r($this->session->flashdata("registerStatus"));
            if($this->session->flashdata("registerStatus")){
                //echo "has";
                //$registerStatus = 
                 $this->load->view("mainViews/login",array("registerStatus"=>$this->session->flashdata("registerStatus")));
            }else{
               // echo "sdfsdf";
            $this->load->view("mainViews/login");
            }
        }else{
            $data = array(
                'email'=> $this->input->post("email"),
                'password'=>md5($this->input->post("password")),
                 );

            $response = $this->admin_model->loginAdmin($data);
            if(!empty($response)){
                if($response['success']){
                    //echo  $response['msg'];
                    //print_r($response['data']);
                    $sessionData = $response['data'];
                    $sessionData['loggedIn'] = true;
                    $this->session->set_userdata($sessionData);
                    //print($this->session->userdata("loggedIn"));
                    redirect("/admin/projects");
                }else{
                    //echo $response['msg'];
                    $loginStatus = array("success"=>false,"msg"=>$response['msg']);
                    //$this->session->set_flashdata('registerFailed',$registerStatus);
                    $this->load->view("mainViews/login",array("loginStatus"=>$loginStatus));

                }
            }else{
               $loginStatus = array("success"=>false,"msg"=>"Internal Error");
                    //$this->session->set_flashdata('registerFailed',$registerStatus);
                    $this->load->view("mainViews/login",array("loginStatus"=>$loginStatus));
                
            }

        }

        $this->load->view("templates/footer");

    }

    public function logout(){
        $this->session->sess_destroy();
        redirect("admin/login");
    }

    //Form Custom Validations
    public function check_username_exists($username){
        $this->form_validation->set_message("check_username_exists","That username is already taken");

        if($this->admin_model->isAdminExists(array("username"=>$username))){
            return true;
        }else{
            return false;
        }
    }
    
    public function check_email_exists($email){
        $this->form_validation->set_message("check_email_exists","That email is already in use");

        //echo $this->admin_model->isAdminExists(array("email"=>$email));

        if($this->admin_model->isAdminExists(array("email"=>$email))){
            //this is how the logic for callback for codeignitor works , it the opposite always is true , so true is false;
            return false;
        }else{
            return true;
        }
    }
}
