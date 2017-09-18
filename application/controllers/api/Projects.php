<?php
require APPPATH . 'libraries/REST_Controller.php';
use Firebase\JWT\JWT;
class Projects extends REST_Controller{

    public function __construct(){
            
            parent::__construct();
    }


       // Get projects by their id
    public function index_get($id=null){
        if($id == null){
            $this->response(array("success"=>false,"msg"=>"No project specified"));
        }

        if(!$this->apiproject_model->hasProject($id)){
            $this->response(array("success"=>false,"msg"=>"Project Not Found"));
        }
        $getData =  $this->get();
        if(isset($getData['token']) && !empty($getData['token'])){

            //get the project specific for they user
            $tokenDecode = $this->decodeTokenGetID(true,$getData['token']);
            if($tokenDecode['success']){
            $user_id = $tokenDecode['user_id'];
            $checkIf=  $this->apiproject_model->getIfEnrolled($id,$user_id);
                
                if($checkIf){
                    $data= $this->apiproject_model->projectByIdToLearn($id,$user_id);
                    $this->response($data);
                }else{
                    $this-response(array("success"=>false,"msg"=>"Project No Enrolled"));
                }
            }else{
                $this->response( $tokenDecode);
            }
            
        }else{
        $this->response($this->apiproject_model->getProjectByID($id));
        }
    }


    // Get all the projects in the Database
    public function all_get(){
        $this->response($this->apiproject_model->getAllProjects());
    }

    public function isEnrolled_get($project_id=null){
        
        if($project_id == null){
            $this->response(array("success"=>false,"msg"=>"Invalid project id"));
        }
        
        $tokenDecode = $this->decodeTokenGetID();
        if($tokenDecode['success']){
            $user_id = $tokenDecode['user_id'];
            $checkIf=  $this->apiproject_model->getIfEnrolled($project_id,$user_id);
                
                if($checkIf){
                    $this->response(array("success"=>true,"msg"=>"Already Enrolled"));
                }else{
                    $this-response(array("success"=>false,"msg"=>"Enroll"));
                }

        }else{
            $this->response(array("success"=>false,"msg"=>$tokenDecode['msg']));
        }
        
                

    }

    
    //Submit the task
    public function submitTask_post(){
        //check if auth is present
        //check if all the the post data is present
        //decode the base64 and validate it
        //check if enrolled 
        //if valid enter to db

        //Decode Token
        $tokenDecode = $this->decodeTokenGetID();

        //if the token is successful decoded : valid token
        if($tokenDecode['success']){

                //Get all the post data
                $postData = $this->post();

                //Security Check : Check for keys that are accepted
                $allowedKey = array("link","comment","id");
                if(count($postData) != count($allowedKey)){
                    $this->response(array("success"=>false,"msg"=>"Invalid Request"));
                }

                //Looping through the post data to see whether neccessary key is present
                foreach($postData as $key=>$value){
                    if(!in_array($key,$allowedKey)){
                        $this->response(array("success"=>false,"msg"=>"Invalid Post data"));
                    }
                }


                if(!isset($postData['link']) || !isset($postData['comment']) ){
                    $this->response(array("success"=>false,"msg"=>"Submission details not provided"));
                }

                if(strlen($postData['link']) < 5){
                    $this->response(array("success"=>false,"msg"=>"Submission Link Invalid"));
                }


                try{
                $id = strrev($postData['id']);
                $baseDecode = base64_decode($id,true);
                //$this->response($baseDecode);
                if($baseDecode != false){
                    $idJSON = json_decode($baseDecode,true);
                    //$this->response($idJSON);
                    $allowedIds =  array("project","part","id","type");
                        
                        foreach($idJSON as $key=>$value){
                            //$this->response($key);
                            if(!in_array($key,$allowedIds)){
                                $this->response(array("success"=>false,"msg"=>"Invalid ID"));
                            }
                        }

                    $project_id = $idJSON['project'];
                    $user_id = $tokenDecode['user_id'];
                    $checkIf=  $this->apiproject_model->getIfEnrolled($project_id,$user_id);

                    if(!$checkIf){
                        $this->response(array("success"=>false,"msg"=>"Project not enrolled"));
                    }

                    $data =  array("project_id"=>$idJSON['project'],"part_id"=>$idJSON['part'],"task_id"=>$idJSON['id'] , "submission_link"=>$postData['link'] , "submission_comment"=>$postData['comment'],'userClient_id'=>$user_id );
                    //this is where the submission to db comes 
                    $submissionStatus = $this->apiproject_model->submitTask($data);

                    $this->response($submissionStatus);                     
                    


                }else{
                    $this->response(array("success"=>false ,"msg"=>"Unauthorized Access"));
                }
                
                 }catch(Exception $e){
                    $this->response(array("success"=>false,"msg"=>"Invalid ID Specified"));
                } 
        }else{
            $this->response(array("success"=>false,"msg"=>"Unauthorized Error"));
        }
        
    }

    //get the parts for all the projects
    public function part_get($type=null,$id = null){
        $tokenDecode = $this->decodeTokenGetID();

        if($type == null || $id == null){
           $this->response(array("success"=>false,"msg"=>"Invalid Request")); 
        }   

        if($type !="task"){
            if($type !="reading"){
                $this->response(array("success"=>false,"msg"=>"Type not Defined")); 
            }
        }


        if(!$tokenDecode['success']){
            $this->response($tokenDecode['msg']);
        }else{
            

            //if token is supplied and correct
            $id = strrev($id);
            $idDecode = base64_decode($id);
            
            if($idDecode != false){

                    $user_id = $tokenDecode['user_id'];
                    try{
                        $content = json_decode($idDecode,true);
                        $allowedKey  = array("project","part","id","type");
                        //$this->response($content);
                        foreach($content as $key=>$value){
                            //$this->response($key);
                            if(!in_array($key,$allowedKey)){
                                $this->response(array("success"=>false,"msg"=>"Invalid ID"));
                            }
                        }
                        if($type !=$content['type']){
                             $this->response(array("success"=>false,"msg"=>"Invalid Type"));
                        }

                        if($type == "reading"){
                            $type = "readingList";
                        }

                        $ids= array("project_id"=>$content['project'],"part_id"=>$content['part'],$type."_id"=>$content['id']);
                        
                        $getPart = $this->apiproject_model->getTaskByID($ids,$type,$user_id);
                        $this->response($getPart);
                           
                    }catch(Exception $e){
                        $this->response("rest");
                    }
            }else{

                //Invalid ID
                $this->response(array("success"=>false,"msg"=>"Invalid ID"));


            }

        }
    }

    
 

    


//helper functions


    // Get all the headers of the request
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


    //Decode and Vertify the JWT Token
    public function decodeTokenGetID($supplied=false,$token=null){
            //$header =getallheaders();
            if(!$supplied){
            $header =$this->getallheaders();
            if(!(isset($header['Authorization']))){
                return (array("success"=>false,"msg"=>"Unauthorized Access"));
            }
                  
            $authToken = $header['Authorization'];
            }else{
                $authToken = $token;
            }
            try{
                $decoded = JWT::decode($authToken, JWT_SECRET_KEY, array('HS256'));
                $decoded = (array)$decoded;
                $user_id =$decoded['payload']->userClient_id;

                return (array("success"=>true,"user_id"=>$user_id));
             
                
            }catch(Exception $e){
                 return (array("success"=>false,"msg"=>"Token Invalid"));
            }
        }


        public function enroll_post(){
            //$authToken = getallheaders()['Authorization'];
            $header =$this->getallheaders();
            //$header =getallheaders();
           // $this->response($header);
           //change  this to function later on
            if(!(isset($header['Authorization']))){
                $this->response(array("success"=>false,"msg"=>"Unauthorized Access"));
            }
            
            $postDetails= $this->post();
            //$this->response($postDetails);
            if(!isset($postDetails['id'])){
                $this->response(array("success"=>false,"msg"=>"Project Undefined"));
            }
            $project_id = $postDetails['id'];
            $authToken = $header['Authorization'];
            


            try{
                $decoded = JWT::decode($authToken, JWT_SECRET_KEY, array('HS256'));
                $decoded = (array)$decoded;
                $user_id =$decoded['payload']->userClient_id;
                $checkIf=  $this->apiproject_model->getIfEnrolled($project_id,$user_id);
                
                if($checkIf){
                    $this->response(array("success"=>false,"msg"=>"Already Enrolled"));
                }
                
                $response = $this->apiproject_model->enrollment($project_id,$user_id);
                $this->response($response);
            }catch(Exception $e){
                 $this->response(array("success"=>false,"msg"=>"Token Invalid"));
            }
            

    }




}



