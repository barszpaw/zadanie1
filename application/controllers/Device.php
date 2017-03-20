<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *

/**
 * Description of Device
 *
 * @author BarszPaw
 */
class Device extends MY_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('Device_model','device_m'); // model urzadzenia
        $this->load->model('Flag_model','flag_m'); // model dla slownika statusów
        $this->load->model('Devicechangelogs_model','devicechangelogs_m');
        $this->load->model('Process_tree_model','process_tree_m');
    }
    /**
     * Lista wszystkich urzadzeń.
     */
    public function index(){
          $this->load->view('device/ajax_view',array('data'=>$this->device_m->get_all()));
        }
    
     /**
      * Widok pojedynczego urzadzena.
      * @param string $serial numer seryjny urzadzenia
      */
     public function view($serial){
         $details=$this->device_m->getBySerial($serial);
         if (!$details) {
             $this->failed('Nie ma uządzenia o tym numerze seryjnym!');
         } else {
             $this->load->view('device/ajax_view',array('data'=>$details));
         }
     }   
      
   /**
    * Dodanie urzadzenia 
    * @param string $serial
    */  
    public function add($serial){
        $data=array('serial_number'=> $serial   ,'ipaddr'=> $this->input->ip_address());
        $result=$this->device_m->add($data);
        if ($result){$this->sucess('dodano nowe urządzenie');}
        
    }
   
    /**
     * Zmina stanu urzadzenia
     * @param string $serial numer serujny urzadzenia
     * @param string $state_new nowy status urzadzenia 
     */
    public function change_state($serial=NULL,$state_new=NULL){
        $state_new_id=$this->flag_m->get_row_where(array('name'=>$state_new));
        $status=$this->device_m->chage_state($serial, $state_new_id->id);
        
        if ($status!==FALSE){
            $this->sucess('Zmieniono status!');
        }
         
        // $this->load->view('device/ajax_view',array('data'=> $this->device_m->getBySerial($serial)));
    }    
    
    /**
     * Lista dostepnych statusów
     */
    public function flaglist() {
        $flagi=$this->flag_m->get_all();
        $this->load->view('device/ajax_view',array('data'=> $flagi));
    }
    
    
    /* testowo
    public function validate($state_curr,$state_new){
        $data=array('data'=>
        $this->process_tree_m->validate_change_state($state_curr, $state_new));
        $this->load->view('device/ajax_view',$data);
    }
    */
    }
    
    

