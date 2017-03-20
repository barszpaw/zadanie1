<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Device
 *
 * @author BarszPaw
 */
class Device_model extends MY_Model {

    protected $_table = 'devices';
    protected $_pk_field = 'id';
    

    function __construct() {
        parent::__construct();
       
    }

    public function get_all() {
        $data = parent::get_all();
        // enrichment of every registered device
        foreach ($data as $idx => $device) {
            $flag = $this->ci->flag_m->get_row($device->last_state);
            $device->state_name = (is_object($flag)) ? $flag->name : NULL;
            //$device->state_name=$this->ci->flag_m->get($last_state)[0]->name;
            //$device->change_log = $this->ci->devicechangelogs_m->get_where(array('device_id' => $device->id));
        }
        return $data;
    }

    public function add($data) {
        $id = parent::add($data);
        $id_log=null;
        if ($id){
        $data = $this->get_row($id); //pobieramy dane z nowoutroznego skyrptu w celu dodania informacji do logu zmian statusu
        $params = array(
            'device_id' => $id,
            'flag_id' => $data->last_state,
            'ipaddr' => $data->ipaddr,
            'create_time' => $data->create_time
        );
       $id_log=$this->ci->devicechangelogs_m->add($params); // dodanie wpisu do logu zmian
        }
        return ($id and $id_log);
    }

    /**
     * zmiana statusu urzadzenia
     * @param type $serial
     * @param type $state_new
     * @return boolean|misc FALSE: błąd
     */
    public function chage_state($serial, $state_new) {
       
       
        $device = $this->getBySerial($serial);
        if (is_object($device)) {
            if ($this->process_tree_m->validate_change_state($device->last_state, $state_new)==FALSE) {  // sprawdzenie czy można zmienić status
                 $this->ci->failed('Nie można zmienić statusu!');
                 return false;
            } 
                    $this->update($device->id, array('last_state' => $state_new, 'ipaddr' => $this->input->ip_address()));
                    $device = $this->getBySerial($serial);
                    $params = array(
                        'device_id' => $device->id,
                        'flag_id' => $device->last_state,
                        'ipaddr' => $device->ipaddr,
                        'create_time' => $device->modify_time
                    );
                $this->ci->devicechangelogs_m->add($params);
                return TRUE;
            } else { 
                 $this->ci->failed('Nie ma uządzenia o tym numerze seryjnym!');
            return FALSE;
        }
    }

    /**
     * Pobranie informacji o urzadzeniu poprzez numerseryjny
     * @param type $serial
     * @return boolean
     */
    public function getBySerial($serial) {
        $device = $this->get_row_where(array('serial_number' => $serial));
        
        if (is_object($device)) {
               $device->state_name = (!is_null($device->last_state))?$this->ci->flag_m->get_row($device->last_state)->name:$device->last_state;
                $device->change_log= $this->ci->devicechangelogs_m->get_where(array('device_id'=>$device->id));
               return $device;
        } else {
            $this->ci->handleError(-3, "Nie ma takiego urządzenia w systemie");
            return FALSE;
        }
    }

    
        
   
    
}
