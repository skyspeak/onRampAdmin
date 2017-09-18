<?php

class ProjectPart_Model extends CI_Model{

        public function __construct(){
            $this->load->database();
        }

        public function createPart($data){

                $returnResponse = array();

                if(!empty($data)){

                    $insertPart = $this->db->insert("project_parts",$data);
                    if($insertPart){
                        if($this->db->affected_rows()){
                            $returnResponse['msg'] ="Part ". $data['part_name'] . " Created";
                            $returnResponse['success'] = true;
                        }else{
                            $returnResponse['msg'] = "Create Failed";
                            $returnResponse['success'] = false;
                        }
                    }else{
                        die("Authorized Access");
                    }
                    

                }else{
                    $returnResponse['msg'] = "Internal Error";
                    $returnResponse['success'] = false;
                }


                return $returnResponse;

        }


        public function editPart($data , $project_id,$partID){

            $returnResponse = array();

            if(!$this->project_model->hasProject($project_id)){
                die("Authorized Access");
            }   

            $this->db->where(array("part_id"=>$partID,"project_id"=>$project_id));
            $updateQuery = $this->db->update("project_parts",$data);

            if($updateQuery){
                
                if($this->db->affected_rows()>0){
                    $returnResponse['success'] = true;
                    $returnResponse['msg'] = "Part Update Successful";
                }else{
                    $returnResponse['success'] =  false;
                    $returnResponse['msg'] = "Update Failed";
                }

            }else{
                die("Internal Error");
            }


            //return the response
            return $returnResponse;
        }


    //need to create Delete Part







    //Tasks and Reading List Functions

    //Task Functions
    public function createTask($project_id,$part_id,$data){

        if(empty($data)){
            die("Internal Error");
        }

        $returnReponse = array();

        $data['project_id'] = $project_id;
        $data['part_id'] = $part_id;

        $query = $this->db->insert("project_tasks",$data);

        if($query){

                if($this->db->affected_rows()>0){
                    $returnReponse['success'] = true;
                    $returnReponse['msg'] = "Task : " . $data['task_name']. " Created";
                }else{
                    $returnReponse['success'] =false;
                    $returnReponse['msg'] = "Task Failed to Create";
                }

        }else{
            die("Fatal Internal Error");
        }

        return $returnReponse;
    }


    public function updateTask($task_id =null,$data){

        if($task_id == null){
            die("Internal Error");
        }

        $returnReponse = array();

        //$data['task_id'] = $task_id;
        //$data['part_id'] = $part_id;

        //$query = $this->db->insert("project_tasks",$data);
        $this->db->where("task_id",$task_id);
        $query = $this->db->update("project_tasks",$data);
        //$get_where
        if($query){

                if($this->db->affected_rows()>0){
                    $returnReponse['success'] = true;
                    $returnReponse['msg'] = "Task : " . $data['task_name']. " Updated";
                }else{
                    $returnReponse['success'] =false;
                    $returnReponse['msg'] = "Nothing to Update";
                }

        }else{
            die("Fatal Internal Error");
        }

        return $returnReponse;
    }


        public function updateReading($reading_id =null,$data){

        if($reading_id == null){
            die("Internal Error");
        }

        $returnReponse = array();

        //$data['task_id'] = $task_id;
        //$data['part_id'] = $part_id;

        //$query = $this->db->insert("project_tasks",$data);
        $this->db->where("readingList_id",$reading_id);
        $query = $this->db->update("project_readinglist",$data);
        //$get_where
        if($query){

                if($this->db->affected_rows()>0){
                    $returnReponse['success'] = true;
                    $returnReponse['msg'] = "Reading : " . $data['readingList_name']. " Updated";
                }else{
                    $returnReponse['success'] =false;
                    $returnReponse['msg'] = "Nothing to Update";
                }

        }else{
            die("Fatal Internal Error");
        }

        return $returnReponse;
    }


    public function hasReading($reading_id=null,$project_id=null){
        
        $checkQuery = $this->db->get_where("project_readinglist",array("readingList_id"=>$reading_id,"project_id"=>$project_id));
        
        if($checkQuery){
        if($checkQuery->num_rows()>0){
            return true;
        }

        }else{
            die("Fatal Internal Error");
        }


        return false;
    }


    public function getReading($reading_id=null,$project_id=null){
        
        $query = $this->db->get_where("project_readinglist",array("readingList_id"=>$reading_id,"project_id"=>$project_id));
        
        if($query){
        if($query->num_rows()>0){
            return array("success"=>true,"data"=>$query->row_array());
        }

        }else{
            die("Fatal Internal Error");
        }


        return array("success"=>false);
    }


    public function hasTask($task_id=null,$project_id=null){
        
        $checkQuery = $this->db->get_where("project_tasks",array("task_id"=>$task_id,"project_id"=>$project_id));
        
        if($checkQuery){
        if($checkQuery->num_rows()>0){
            return true;
        }

        }else{
            die("Fatal Internal Error");
        }


        return false;
    }

      public function getTask($task_id=null,$project_id=null){
        
        $query = $this->db->get_where("project_tasks",array("task_id"=>$task_id,"project_id"=>$project_id));
        
        if($query){
        if($query->num_rows()>0){
            return array("success"=>true,"data"=>$query->row_array());
        }

        }else{
            die("Fatal Internal Error");
        }


        return array("success"=>false);
    }




    //Reading Functions

    public function createReading($project_id,$part_id,$data){

        if(empty($data)){
            die("Internal Error");
        }

        $returnReponse = array();

        $data['project_id'] = $project_id;
        $data['part_id'] = $part_id;

        $query = $this->db->insert("project_readinglist",$data);

        if($query){

                if($this->db->affected_rows()>0){
                    $returnReponse['success'] = true;
                    $returnReponse['msg'] = "Task : " . $data['task_name']. " Created";
                }else{
                    $returnReponse['success'] =false;
                    $returnReponse['msg'] = "Task Failed to Create";
                }

        }else{
            die("Fatal Internal Error");
        }

        return $returnReponse;
    }
    


    //Helper Functions       
    
    public function getProjectPartByID($part_id,$project_id){

        if(isset($part_id) && isset($project_id)){
            $returnReponse =array();
            
            $queryConditionals = array("project_id"=>$project_id , "part_id"=>$part_id);
            
            $partQuery = $this->db->get_where("project_parts",$queryConditionals);
            $taskListQuery = $this->db->get_where("project_tasks",$queryConditionals);
            $readingListQuery = $this->db->get_where("project_readingList",$queryConditionals);


            if($partQuery && $taskListQuery &&  $readingListQuery){

                $partData = $partQuery->row_array();
                $readingList = $readingListQuery->result_array();
                $taskList = $taskListQuery->result_array(); 

                $returnReponse['partData'] = $partData;
                $returnReponse['readingList'] = $readingList;
                $returnReponse['taskList'] = $taskList;

                return array('success'=>true,'data'=>$returnReponse);
            }else{
                die("Authorized Access");
            }
        }

        return array('success'=>false, 'msg'=>"Internal Error");

    }


        //need to check after creating the task and reading is added
        public function getPartByProject($project_id){

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

                $parts["taskList"] = $taskList;
                $parts["readingList"] = $readingList;
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

    
    public function hasProjectPart($part_id,$project_id){

        if(isset($part_id)&& isset($project_id)){

            $query = $this->db->get_where("project_parts",array("project_id"=>$project_id,"part_id"=>$part_id));
            if($query){
                if(!empty($query->row_array())){

                    return true;

                }
            }

        }

        return false;

    }


}
