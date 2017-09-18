<?php 
require APPPATH . 'libraries/JWT.php';

//secret key
define("JWT_SECRET_KEY","f903ae6252835a9e7a55b03ee85aeac8");

use Firebase\JWT\JWT;


class User_Model extends CI_Model{


        public function __construct(){
            
            $this->load->database();
        }


        public function getEnrolledProjects($user_id){

            $returnArray  = array();
            if(!isset($user_id)){
                return array("success"=>false,"msg"=>"Internal Error");
            }

            $query= $this->db->get_where("clientenrollment",array("userClient_id"=>$user_id));

            if($query->num_rows()>0){
                    $returnArray['success']=true;
                    $projects = $query->result_array();
                    $returnProjects =array();
                    foreach($projects as $project){
                        $enrolledProject_id = $project['project_id'];
                        $projectDetails = $this->apiproject_model->getSingleProjectInfo($enrolledProject_id);
                        $returnProjects[] = $projectDetails;
                    }
                    $returnArray['projects'] = $returnProjects;                    
            }else{
                $returnArray['success']=false;
                $returnArray['msg']= "No Project Enrolled";
            }


            return $returnArray;


        }




        public function hasUser($username=null,$email=null){

            $returnReponse = array();

            if(!isset($email)){
            //if(!isset($username)&& !isset($email)){
                $returnReponse['error'] = true;
                $returnReponse['msg'] = "Unauthorized Access";
                return $returnReponse;   
            }
            
            if($email != null){

                    
                    //check for both
                    // $bothCheck = $this->db->get_where("clientuser",array("userClient_username"=>$username,"userClient_email"=>$email));

                    // if(!empty($bothCheck->row_array())){
                    //     $returnReponse['success'] = false;
                    //     $returnReponse['has'] = true;
                    //     $returnReponse['msg'] = "Email already registered"; 
                    //     return $returnReponse;
                    // }

                    $emailCheck = $this->db->get_where("clientuser",array("userClient_email"=>$email));

                    if(!empty($emailCheck->row_array())){
                        $returnReponse['success'] = false;
                        $returnReponse['has'] = true;
                        $returnReponse['msg'] = "Email already registered"; 
                        return $returnReponse;
                    }

            }
            
            if($username !=null){
            $usernameCheck = $this->db->get_where("clientuser",array("userClient_username"=>$username));

            if(!empty($usernameCheck->row_array())){
                $returnReponse['success'] = false;
                $returnReponse['has'] = true;
                $returnReponse['msg'] = "Username already registered"; 
                return $returnReponse;
            }

            }

            //returns the response
                //msg
                //has
            
            $returnReponse['success'] = true;
            $returnReponse['has'] = false;
            $returnReponse['msg'] = "User Available"; 
            return $returnReponse;
        }


    

        public function registerUser($data){

            $returnReponse =array();

            if(empty($data)){
                $returnReponse['success'] = false;
                $returnReponse['error'] = true;
                $returnReponse['msg'] = "Unauthorized Access";
                return $returnReponse;
            } 

            //Double check;
            //$checkUser = $this->hasUser($data['userClient_username'],$data['userClient_email']);

            $createUser = $this->db->insert("clientuser",$data);

            if(!$createUser){
                $returnReponse['success'] = false;
                $returnReponse['error'] = true;
                $returnReponse['msg'] = "Oops Something went wrong";
                return $returnReponse;
            }

            if($this->db->affected_rows()>0){
                $returnReponse['success'] = true;
                $returnReponse['msg'] = "User Created";
                
            }else{
                $returnReponse['success'] = false;
                $returnReponse['msg'] = "Failed to create user";
                
                
            }

            return $returnReponse;

        }


        public function loginUser($loginDetails){

            $returnReponse =array();

            if(empty($loginDetails)){
                $returnReponse['success'] = false;
                $returnReponse['error'] = true;
                $returnReponse['msg'] = "Unauthorized Access";
                return $returnReponse;
            } 


            $loginQuery = $this->db->get_where("clientUser",$loginDetails);

            if(!$loginQuery){
                $returnReponse['success'] = false;
                $returnReponse['error'] = true;
                $returnReponse['msg'] = "Oops Something went wrong";
                return $returnReponse;
            }

            if($loginQuery->num_rows()>0){
                $userDetails = $loginQuery->row_array();
                //unset the password
                unset($userDetails['userClient_password']);



                //if($userDetails['active']!= 0){
                 if($userDetails['active'] == 0){
                    $returnReponse['success'] = false;
                    //$returnReponse['msg'] = "Incorrect username/password";
                    $returnReponse['msg'] = "Activate your account to continue. Check Your Email :D";
                    return $returnReponse;
                    
                }else{
                    $returnReponse['success'] = true;
                    $returnReponse['user'] = $this->removeDBSlug("userClient_",$userDetails);
                    $returnReponse['token'] = $this->generateToken($userDetails);
                    return $returnReponse;
                }


            }else{
                $returnReponse['success'] = false;
                //$returnReponse['msg'] = "Incorrect username/password";
                $returnReponse['msg'] = "Incorrect password";
                return $returnReponse;
            }

        }





//Helper Functions

        public function activateAccount($email){

                $isAccount = $this->hasUser(array("userClient_email"=>$email));

                if(!$isAccount){

                    return array("success"=>false,"msg"=>"User not Found");
                }

                $this->db->where("userClient_email",$email);
                $updateActive = $this->db->update("clientuser",array("active"=>1));
                if($updateActive){
                    return array("success"=>true,"msg"=>"Activated");
                }else{
                    return array("success"=>false,"msg"=>"Internal Error");
                }

            }
        
        private function generateToken($userDetails){
            $time =time();
            $tokenData = array(
                        "iat" => $time,
                        "exp"=> $time +(24*60*60*7),// 1 week
                        "payload"=>$userDetails
                    );
                            
            return JWT::encode($tokenData,JWT_SECRET_KEY);
        }

        private function removeDBSlug($slug,$data){

              $returnArray =array();

              foreach($data as $key=> $value){

                    $newKey = str_replace($slug,"",$key);
                    $returnArray[$newKey] = $value;

              }  

            unset($data);
            return $returnArray;
        }

        private function addDBSlug($slug,$data){

            $returnArray =array();

            foreach($data as $key=> $value){

                    $newKey = $slug.$key;
                    $returnArray[$newKey] = $value;

            }  

            unset($data);
            return $returnArray;

        }


}