<?php

class Project_Model extends CI_Model{

    
    public function __construct(){
        $this->load->database();
    }

    public function getFieldsList(){
        return $this->db->get("projectfields")->result_array();
    }

    public function getFieldById($id){
        return $this->db->get_where("projectfields",array('field_id'=>$id))->row_array()['field_name'];
    }

    public function createProject($data){
       
        if(!empty($data)){
            $data['project_thumb'] = "http://via.placeholder.com/500x500";
            $query = $this->db->insert("projects",$data);
            //if query executed
            if(($this->db->affected_rows()>0)){
                $msg = "Project '". $data['project_name']."' Created";
                return array('success'=>true,'msg'=>$msg);
            }else{
                return array('success'=>false,"msg"=>"Internal Error");
            }
        }else{
            return array('success'=>false);
        }
    }

    //All update functions


    public function updateProjectImage($id,$fileName){

        $returnResponse = array();

        if(!empty($id) && !empty($fileName)){

        $this->db->where('project_id',$id);
        $this->db->update("projects",array('project_thumb'=>$fileName));
        if($this->db->affected_rows()>0){

            $returnResponse['success'] = true;
            $returnResponse['msg'] = "Thumbnail Updated";
        }else{
       
            $returnResponse['success'] = false;
            $returnResponse['msg'] = "Update Error";
       
        }

        }else{
       
            //update  failed due to internal errors;
            $returnResponse['success'] = false;
            $returnResponse['msg'] = "Internal Error";
       
        }

        return $returnResponse;
   }

    public function updateProject($id,$data){

        $returnResponse = array();

        if(!empty($id)){

                if($this->hasProject($id)){
                    

                    $this->db->where("project_id",$id);
                    $this->db->update("projects",$data);

                    if($this->db->affected_rows()>0){

                        $returnResponse['success'] = true;
                        $returnResponse['msg'] = "Project Details Updated";

                    }else{
                        $returnResponse['success'] = false;
                        $returnResponse['msg'] = "Update Failed";
                    } 

                }else{
                    die("Authorized Access");
                }
            
        }else{

            $returnResponse['success'] = false;
            $returnResponse['msg'] = "Internal Error";
            
        }

        return $returnResponse;


    }



    //Helper Functions

    public function getProjectByID($id,$all=true){

        if(isset($id)){
            $returnReponse =array();
            $projectQuery = $this->db->get_where("projects",array("project_id"=>$id));
            //$partQuery = $this->db->get_where("project_parts",array("project_id"=>$id));
            $partData = $this->projectpart_model->getPartByProject($id);
            
            if($all == false){
                $projectData = $projectQuery->row_array();
                unset($projectData['created_by']);
                $returnReponse['projectData'] = $projectData;
                return array('success'=>true,'data'=>$returnReponse);
            }


            if($projectQuery && $partData['success']){

                $projectData = $projectQuery->row_array();
                //$partData = $partQuery->result_array();

                //unset the admin ID
                unset($projectData['created_by']);
                $returnReponse['projectData'] = $projectData;

                //if(count($partData)>0){
                $returnReponse['partData'] =$partData['data'];
                //} 

                return array('success'=>true,'data'=>$returnReponse);
            }
        }

        return array('success'=>false, 'msg'=>"Internal Error");

    }


    public function getAllProjects(){

        $returnResponse =array();

        $query = $this->db->get("projects");
        if($query){
            $returnResponse['success'] =true;
            $returnResponse['data']= $query->result_array();
        }else{
            $returnResponse['success'] =false;
            $returnResponse['msg'] = "Internal Error";
        }

        return $returnResponse;
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

    
    public function createCat($data){

            if($this->db->insert("projectfields",$data)){

                return true;
            }
            
            return false;

    }


    

}