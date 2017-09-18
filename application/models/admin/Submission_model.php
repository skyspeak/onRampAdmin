<?php

class Submission_Model extends CI_Model{


        public function getAllSubmission(){

        $returnResponse =array();

        $query = $this->db->get("clientsubmissions");
        if($query){
            
            $datas= $query->result_array();

            $submissions =array();

            if(count($datas)>0){
               foreach($datas as $data){
                    $getProjectName = $this->db->get_where("projects",array('project_id'=>$data['project_id']))->row_array();
                    $getPartName = $this->db->get_where("project_parts",array("part_id"=>$data['part_id']))->row_array();
                    $getTaskName = $this->db->get_where("project_tasks",array("task_id"=>$data['task_id']))->row_array();
                    $getStudentName = $this->db->get_where("clientuser",array("userClient_id"=>$data['userClient_id']))->row_array();
                    //print_r($getStudentName);
                    
                    $submissionDetails = array();
                    $submissionDetails['student_name'] = $getStudentName['userClient_firstName'] . " " . $getStudentName['userClient_lastName'];
                    $submissionDetails['project_name'] = $getProjectName['project_name'];
                    $submissionDetails['part_name'] = $getPartName['part_name'];
                    $submissionDetails['task_name'] = $getTaskName['task_name'];
                    $submissionDetails['submission_id'] = $data['submission_id'];

                    $submissions[] = $submissionDetails;

               }

            $returnResponse['success'] =true;
            $returnResponse['data']= $submissions;
            //print_r($returnResponse);

            return $returnResponse;

            } 
        }else{
            $returnResponse['success'] =false;
            $returnResponse['msg'] = "Internal Error";
        }

        return $returnResponse;
    }

    public function getSubmissionByID($ids){
        
        $returnResponse =array();

        $query = $this->db->get_where("clientsubmissions",array("submission_id"=>$ids));
        if($query){
            
            $data= $query->row_array();

            //$submissions =array();

            if(count($data)>0){
              
                    $getProjectName = $this->db->get_where("projects",array('project_id'=>$data['project_id']))->row_array();
                    $getPartName = $this->db->get_where("project_parts",array("part_id"=>$data['part_id']))->row_array();
                    $getTaskName = $this->db->get_where("project_tasks",array("task_id"=>$data['task_id']))->row_array();
                    $getStudentName = $this->db->get_where("clientuser",array("userClient_id"=>$data['userClient_id']))->row_array();
                    //print_r($getStudentName);
                    
                    $submissionDetails = array();
                    $submissionDetails['student_name'] = $getStudentName['userClient_firstName'] . " " . $getStudentName['userClient_lastName'];
                    $submissionDetails['project_name'] = $getProjectName['project_name'];
                    $submissionDetails['part_name'] = $getPartName['part_name'];
                    $submissionDetails['task_name'] = $getTaskName['task_name'];
                    $submissionDetails['submission_id'] = $data['submission_id'];
                    $submissionDetails['submission_link'] = $data['submission_link'];
                    $submissionDetails['submission_comment'] = $data['submission_comment'];

                    //$submissions[] = $submissionDetails;

               

            $returnResponse['success'] =true;
            $returnResponse['data']= $submissionDetails;
            //print_r($returnResponse);

            return $returnResponse;

            } 
        }else{
            $returnResponse['success'] =false;
            $returnResponse['msg'] = "Internal Error";
        }

        return $returnResponse;
    }


    public function hasSubmission($id=null){

        if($id == null){
            die("Internal Error");
        }


        $query = $this->db->get_where("clientsubmissions",array("submission_id"=>$id));
        if(!$query){
            die("Authorized Error");
        }

        if($query->num_rows()>0){
            return true;
        }

        return false;
    }


    public function approveProject($id,$approval){
        
        $returnResponse = array();
        $returnResponse['success'] =false;
        $returnResponse['msg'] = "Internal Error";
        
        if($this->hasSubmission($id)){
            if($approval == true){
                $this->db->where('submission_id',$id);
                $approvalQuery = $this->db->update("clientsubmissions",array('completed'=>1));
                
                if($approvalQuery){
                    $returnResponse['msg']="Task Marked Completed";
                    $returnResponse['success'] = true;
                    return $returnResponse;

                }else{
                    return $returnResponse;
                }
            }else if ($approval == false){
                $this->db->where('submission_id', $id);
                $this->db->delete('clientsubmissions');
                if($this->db->affected_rows()>0){
                    $returnResponse['msg']="Task Submission Rejected";
                    $returnResponse['success'] = true;
                    return $returnResponse;

                }else{
                    return $returnResponse;
                }
            }
        }else{
            return $returnResponse;
        }


    }


    

}
