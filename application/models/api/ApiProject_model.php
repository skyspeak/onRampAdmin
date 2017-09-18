<?php


class ApiProject_model extends CI_Model{

        public function __construct(){
            $this->load->database();
        }


        //Getting project infor for learn 
        public function projectByIdToLearn($project_id, $user_id){
            $projectData = $this->getProjectByID($project_id);

            $data  = $projectData['data']['partData']['partData'];

            //return $data;

            if(count($data)<=0){
                return $projectData;
            }

            //$tasks = $data['taskList'];

            //return $task;

            // TO DO
            //get the tasks for each data
            //decode the base64
            //get the ids from them
            //send query to db to the submission table with the above ids and user id
            //if that is submited and appending approval :  set new attribute pending to true and completed to true
            //if submited and appending approved  and completed :  then set attributes pending to false and completed to true
            //return the data back

            $newProjectData = array();

            //foreach()
            $newPart = array();
            $testData = array();
            foreach($data as $item){
                $taskList = $item['taskList'];
                $newTask = array();
                $taskCount = count($taskList);
                $taskCompletedCount = 0;
                foreach($taskList as $task){

                    $idDecode = json_decode(base64_decode(strrev($task['id'])),true);
                    //Get all the ids from the task base64 id;
                    $queryConditions = array('project_id'=>$idDecode['project'],'part_id'=>$idDecode['part'],'task_id'=>$idDecode['id']);
                    $queryConditions['userClient_id'] = $user_id;


                    
                    $submissionCheck = $this->db->get_where('clientsubmissions',$queryConditions);
                    $testData[] = $submissionCheck;
                    if($submissionCheck->num_rows()>0){
                        //return $submissionCheck[0];
                        $submissionCheck =  $submissionCheck->row_array();
                        
                        if($submissionCheck['completed'] == 1){
                            $taskCompletedCount += 1;
                        }

                        $task['completed'] = (boolean)($submissionCheck['completed']);
                        $task['submitted'] = (boolean)($submissionCheck['submitted']);
                        
                    }else{
                        $task['completed'] = false;
                        $task['submitted'] = false;
                    }

                    $newTask[] = $task;
                }

                if($taskCompletedCount == $taskCount){
                    $item['completed'] = 1;
                }else{
                    $item['completed'] = 0;
                }
                $item['taskList'] = $newTask;
                $newPart[] = $item;
            
            }

                $projectData['data']['partData']['partData'] = $newPart;
                //return $testData;
                //return $newPart;
                return $projectData;

            

        }



        public function enrollment($project_id,$user_id){


                $returnArray =array();

                $enrolQuery = $this->db->insert("clientenrollment",array('userClient_id'=>$user_id,"project_id"=>$project_id));
                if($enrolQuery){
                    if($this->db->affected_rows()>0){
                        $returnArray['success'] =true;
                    }else{
                        $returnArray['success'] = false;
                        $returnArray['msg'] ="Enrollment Failed";
                    }

                }else{
                    $returnArray['success'] = false;
                    $returnArray['msg'] = "Internal Error";
                }
                
               return $returnArray; 
        }



        public function submitTask($data,$user_id=null){

                if(empty($data)){
                    return array("success"=>false,"msg"=>"Internal Error");
                }

              $submitQuery = $this->db->insert("clientsubmissions",$data);

              if($submitQuery){

                  if($this->db->affected_rows()>0){
                        return array("success"=>true,"msg"=>"Task Submitted");
                  }else{
                      return array("success"=>false,"msg"=>"Task Submission Failed");
                  }

              }else{
                  return(array("success"=>false,"msg"=>"Unauthorized Access"));
              }
        }


        public function getIfEnrolled($project_id,$user_id){

            $findQuery = $this->db->get_where("clientenrollment",array('userClient_id'=>$user_id,"project_id"=>$project_id));
            if($findQuery->num_rows()>0){
                return true;
            }
            return false;
        }



    public function getTaskByID($ids,$type =null,$user_id = null){

        $returnArray =array();
        if(empty($ids) || $type==null || $user_id ==null){

            return array("success"=>false,"msg"=>"Internal Error");
        
        }else{

            $checkIfEnrolled = $this->getIfEnrolled($ids['project_id'],$user_id);
            if(!$checkIfEnrolled){
               return array("success"=>false,"msg"=>"Authorized Access"); 
            }
            $partQuery;
            if($type == "task"){
                $partQuery = $this->db->get_where("project_tasks",$ids);
            }else if($type == "readingList"){
                $partQuery = $this->db->get_where("project_readinglist",$ids);
            }else{
                return(array("success"=>false,"msg"=>"Internal Error"));
            }

            if($partQuery){
                    if($partQuery->num_rows()>0){
                        $data = $partQuery->row_array();
                        $returnArray['success'] = true;
                        $returnArray['part'] = $data;

                        return $returnArray;

                    }else{
                        return array("success"=>false,"msg"=>"Part Not Found");
                    }
            }else{
                return array("success"=>false,"msg"=>"Authorized Access");
            }

        }

    }

    public function getProjectByID($id){

        if(isset($id)){
            $returnReponse =array();
            
            $projectQuery = $this->db->get_where("projects",array("project_id"=>$id));
            //$partQuery = $this->db->get_where("project_parts",array("project_id"=>$id));
            $partData = $this->getPartByProjectAPI($id);

            if($projectQuery && $partData['success']){

                $projectData = $projectQuery->row_array();
                //$partData = $partQuery->result_array();

                //unset the admin ID
                unset($projectData['created_by']);
                $projectData['project_shortDescription'] = $this->truncateText($projectData['project_description'],500);
                //$projectData['project_thumb'] = base_url()."data/thumbs/" . $projectData['project_thumb'];
                $returnReponse['projectData'] = $projectData;

                //if(count($partData)>0){
                $returnReponse['partData'] =$partData['data'];
                //} 

                return array('success'=>true,'data'=>$returnReponse);
            }
        }

        return array('success'=>false, 'msg'=>"Internal Error");

    }    
    
    public function truncateText($s,$max_length=null){
     
        //$s = "In the beginning there was a tree.";
        
        if($max_length == null){
            $max_length = 200;
        }
 
        if (strlen($s) > $max_length)
        {
            $offset = ($max_length - 3) - strlen($s);
            $s = substr($s, 0, strrpos($s, ' ', $offset)) . '...';
        }
        return $s;
 
    }


    public function getAllProjects(){

        $returnResponse =array();
        $this->db->order_by("project_id", "DESC");
        $query = $this->db->get("projects");
        if($query){
            $returnResponse['success'] =true;
            //$returnResponse['data']= $this->removeDBSlugfromArray("project_",$query->result_array());
            $projectItems= $this->removeDBSlugfromArray("project_",$query->result_array());
            
            $projectNewItems = array();
            foreach($projectItems as $projectItem){

                    $projectItem['description'] = $this->truncateText($projectItem['description']);
                    //return $projectItem;
                   // $projectItem['thumb'] = base_url()."data/thumbs/" . $projectItem['thumb'];
                    $projectNewItems[] = $projectItem;
            }

            $returnResponse['data'] =  $projectNewItems;

        }else{
            $returnResponse['success'] =false;
            $returnResponse['msg'] = "Internal Error";
        }

        return $returnResponse;
    }

    //function that doesnt return the project parts
    public function getSingleProjectInfo($id){

        $returnResponse =array();

        $query = $this->db->get_where("projects",array("project_id"=>$id));
        if($query){
            //$returnResponse['success'] =true;
            $returnResponse['data']= $this->removeDBSlugfromArray("project_",$query->result_array());
        }else{
            ///$returnResponse['success'] =false;
            $returnResponse['msg'] = "Internal Error";
        }

        return $returnResponse;
    }





            //need to check after creating the task and reading is added
        public function getPartByProjectAPI($project_id){

        if(isset($project_id)){
            $returnReponse =array();
            
            $partQuery = $this->db->get_where("project_parts",array("project_id"=>$project_id));

            //loop through each of the parts and query and get the count;

            $projectPartData =array();

            if($partQuery){

                $partData = $partQuery->result_array();
                // $readingList = $readingListQuery->result_array();
                // $taskList = $taskListQuery->result_array(); 

            foreach($partData as $parts){
                $queryConditionals = array("project_id"=>$project_id ,"part_id"=>$parts['part_id']);

                $taskList = $this->db->get_where("project_tasks",$queryConditionals)->result_array();
                $readingList = $this->db->get_where("project_readingList",$queryConditionals)->result_array();


                $newTasks = array();
                foreach($taskList as $task){
                    $taskSession = array("project"=>$task['project_id'],"part"=>$task['part_id'],"id"=>$task['task_id'],"type"=>"task");
                    $taskSession = strrev(base64_encode(json_encode($taskSession)));
                    //$dSession = base64_decode(strrev($taskSession));
                    $taskSession = str_replace("=","",$taskSession);
                    
                    $newTask = array("id"=>$taskSession,"name"=>$task['task_name'],"description"=>$task['task_details']);
                    $newTasks[] = $newTask;
                }

                $parts["taskList"] = $newTasks;

                $newReadingList = array();

                foreach($readingList as $reading){
                    $readingSession = array("project"=>$reading['project_id'] , "part"=> $reading['part_id'] ,"id" => $reading['readingList_id'],"type"=>"reading");
                    $readingSession = strrev(base64_encode(json_encode($readingSession)));
                    $readingSession =str_replace("=","",$readingSession);
                    $newReading = array("id"=>$readingSession,"name"=>$reading['readingList_name'],"link"=>$reading['readingList_link']);
                    $newReadingList[] = $newReading;
                }

                $parts["readingList"] = $newReadingList;

                $projectPartData[] = $parts;

            }
 


                $returnReponse['partData'] = $projectPartData;
  
                return array('success'=>true,'data'=>$returnReponse);
            }else{
                die("Authorized Access");
            }
        }

        return array('success'=>false, 'msg'=>"Internal Error");

    }

    public function hasProject($id){

        if(isset($id)){

            $query = $this->db->get_where("projects",array("project_id"=>$id));
            if($query){
                if(!empty($query->row_array())){

                    return true;

                }
            }

        }

        return false;

    }




    //helper function
     private function removeDBSlug($slug,$data){

              $returnArray =array();

              foreach($data as $key=> $value){

                    $newKey = str_replace($slug,"",$key);
                    $returnArray[$newKey] = $value;

              }  

            unset($data);
            return $returnArray;
    }


     private function removeDBSlugfromArray($slug,$data){

              $returnArray =array();

            foreach($data as $item){

                $itemArray =array();
                foreach($item as $key=> $value){

                    $newKey = str_replace($slug,"",$key);
                    $itemArray[$newKey] = $value;

              }  

              $returnArray[] = $itemArray;
            }

            unset($data);
            return $returnArray;
    }



}