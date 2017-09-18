<?php
require APPPATH . 'libraries/REST_Controller.php';
class Api extends REST_Controller{


        public function __construct(){
            
            parent::__construct();
        }

        public function index_get(){
            $this->set_response(array("API Page"));
        }


}