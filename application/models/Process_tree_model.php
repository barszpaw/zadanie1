<?php

/**
 * Model validujący przepływ procesuw na postawie drzewa procesów process_tree
 *
 * @author BarszPaw
 */
class Process_tree_model extends MY_Model {
    protected $_table='process_tree';
    protected $_pk_field='id';
    

   /**
    * Sprawdza możliwość zmiany statusu urzadzenia
    * @param type $state_curr
    * @param type $state_new
    * @return boolean  TRUE Mozliwa zmiana , FALSE nie mozna zmienic stanu
    * @assert (0, 0) == TRUE
    * @assert (2, 0) == TRUE
    * @assert (4, 1) == TRUE
    * @assert (0, 6) == FALSE
    * @assert (2, 6) == FALSE
     */    
    public function validate_change_state($state_curr,$state_new){
    $valid=FALSE;
    $state_curr= $this->get_row($state_curr);
    $state_new=$this->get_row($state_new);
    
   // możliwe zmiany 
    if ($state_curr and $state_new){
        
         $state_next=$this->get_row_where(array('process_id'=>$state_curr->id),1);
         $valid_next=FALSE;
         if ($state_next){
             $valid_next=($state_new->id == $state_next->id);
         } 
         
         
         $state_prev=$this->get_row_where(array('id'=>$state_curr->process_id),1);
         
         $valid_prev=FALSE;
         if ($state_prev){
             $valid_prev=($state_new->id == $state_prev->id);
             
         }
        $valid=($valid_next or $valid_prev);
        } 
            return $valid;
    }
}

