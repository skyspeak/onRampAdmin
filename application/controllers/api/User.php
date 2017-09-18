<?php
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/sendgrid-php/sendgrid-php.php';
define('clientURL','https://pacific-headland-22092.herokuapp.com/login');
define('SENDGRIDAPI','');
define('SENDER','');
use Firebase\JWT\JWT;

class User extends REST_Controller{


        public function __construct(){
            
            parent::__construct();
        }

    //emaill stuff

    public function generateEmail($email,$name,$message){
           //print("testing sendgrid");
        $from = new SendGrid\Email("Flex Academy", SENDER);
        $subject = "Hi There ! Confirm thy Email";
        $to = new SendGrid\Email($name, $email);
        $content = new SendGrid\Content("text/plain", $message);
        $mail = new SendGrid\Mail($from, $subject, $to, $content);

<<<<<<< HEAD
        $apiKey = SENDGRIDAPI;
=======
        $apiKey = "";
>>>>>>> 36fed73a46bf2c4043eb20fe2e729fad79f94e82
        $sg = new \SendGrid($apiKey);
        //echo "<br/>";
        $response = $sg->client->mail()->send()->post($mail);
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
    
    public function activate_get(){
        ///echo "works";
        $items = $this->input->get();
        if(!isset($items['code']) || !isset($items['email'])){
            die("Invalid Request");
        }else{
            $code = $items['code'];
            $email = $items['email'];
            if($this->decodeEmailToken($code,$email)){

                $activation = $this->user_model->activateAccount($email);
                if($activation['success']){
                    redirect(clientURL);
                    //die("well time to move one");
                }else{
                    die($activation['msg']);
                }


            }else{
                die("Invalid Code");
            }
        }
    }


        public function user_get(){

            $this->set_response("User API Section",REST_Controller::HTTP_OK);

        }


        public function dashboard_get(){
            $getUserId = $this->decodeTokenGetID();
            if(!$getUserId['success']){
                //$getUserId['msg']="test";
                $this->response($getUserId);
            }

            $user_id = $getUserId['user_id'];
            $projects = $this->user_model->getEnrolledProjects($user_id);
            $this->response($projects);
        }

        // API Call that Creates Users
        public function create_post(){
           //registers user= 
                //validates if accounts already exist 
                //if not create
                //else
                //throw error

            //update fields :  add auth_type after facebook integration
            //$allowedPostDetails = array('firstName','lastName','email','username','password','interests');
            //$allowedPostDetails = array('firstName','lastName','email','username','password');
            $allowedPostDetails = array('firstName','lastName','email','password');


            $inputData = $this->post();
           //check for allowed fields;
            if(!(count($inputData) == count($allowedPostDetails))){
                //$this->response("nehi");
                $this->response(array("success"=>false,"msg"=>"Invalid Post Data"));
            }
            

            //just incase post send one that is not in the allowed list
            $newData =array();            
            $notAllowedFlag = false;
            foreach($inputData as $key => $value){
                
                if(!in_array($key,$allowedPostDetails)){
                    //$this->response($key);
                    $notAllowedFlag = true;
                    break;
                }
              
              $newKey = "userClient_" . $key;
              $newData[$newKey] = $value;
            
            }

            if($notAllowedFlag){
                $this->response(array("success"=>false,"error"=>true,"msg"=>"Invalid Post Data"));
            }
                
           // $this->set_response(array("This is a test post"));
           //$this->set_response($this->input->request_headers()['Authorization']);
           $checkUser = $this->user_model->hasUser(null,$newData['userClient_email']);
           
           if(isset($checkUser['error'])){
               $this->response($checkUser);
           }

           if($checkUser['has']){
               $this->response($checkUser);
           }

            //if username and email does not exist
            if(!$checkUser['has']){

                //md5 password
                $newData['userClient_password'] = md5($newData['userClient_password']);
                
                $entryResponse  = $this->user_model->registerUser($newData);
                //$entryResponse = $this->response($createResponse);

                if($entryResponse['success']){

                    $code = $this->generateCodeForEmail($newData['userClient_email']);
                    $emailMessage = "Hi " . $newData['userClient_firstName'] . ", \n Please follow the below link to activate your Flex Account. \n " . base_url() . "api/user/activate?email=" .$newData['userClient_email'] . "&code=" . $code;    
                    
                    $this->generateEmail($newData['userClient_email'],$newData['userClient_firstName'],$emailMessage);

                    $responseFinal = array('success'=>true,"msg"=>"Registered !. Please Activate Your Account. Check your Inbox");

                    $this->response($responseFinal);

                }else{
                    return $entryResponse;
                }


            }



        }


        public function login_post(){
            
            $loginDetails = $this->post();
            
            $alloweFields = array('email','password');
            $notAllowedFlag =false;

            foreach($loginDetails as $key=>$value){

                if(!in_array($key,$alloweFields)){
                    //$this->response($key);
                    $notAllowedFlag = true;
                    break;
                }
              
              $newKey = "userClient_" . $key;
              $newData[$newKey] = $value;

            }

            //if not allowed to proceed
            if($notAllowedFlag){
                $this->response(array("success"=>false,"error"=>true,"msg"=>"Invalid Post Data"));
            }

           // $checkUser = $this->user_model->hasUser($newData['userClient_username']);
            $checkUser = $this->user_model->hasUser(null,$newData['userClient_email']);
           
           if(isset($checkUser['error'])){
               $this->response($checkUser);
           }
          
            if(!$checkUser['has']){
                $this->response(array("success"=>false,"msg"=>"Invalid Email"));
            }
          
            //if username exist
            if($checkUser['has']){

                //md5 password
                $newData['userClient_password'] = md5($newData['userClient_password']);
                
                $loginResponse = $this->user_model->loginUser($newData);
                $this->response($loginResponse);

            }
        
        
        }




        

            public function getallheaders() 
    { 
           $headers = []; 
       foreach ($_SERVER as $name => $value) 
       { 
           if (substr($name, 0, 5) == 'HTTP_') 
           { 
               $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value; 
           } 
       } 
       return $headers; 
    } 

        public function decodeTokenGetID(){
            //$header =getallheaders();
            $header =$this->getallheaders();
            if(!(isset($header['Authorization']))){
                return (array("success"=>false,"msg"=>"UnAuthorized Access"));
                //return (array("success"=>false,"msg"=>$header));
            }
            
        
            $authToken = $header['Authorization'];
            


            try{
                $decoded = JWT::decode($authToken, JWT_SECRET_KEY, array('HS256'));
                $decoded = (array)$decoded;
                $user_id =$decoded['payload']->userClient_id;

                return (array("success"=>true,"user_id"=>$user_id));
             
                
            }catch(Exception $e){
                 return (array("success"=>false,"msg"=>"Token Invalid"));
            }
        }

       
}


?>
