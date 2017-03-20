<?php
/**
 * Description of crud_model
 *
 * @author BarszPaw
 */
class MY_Model extends CI_Model
{
public $_database;
protected $_table;
protected $_pk_field;
public $ci;

            function __construct()
    {
        parent::__construct();
        $this->_database=$this->db;
         $this->_fetch_table();
         $this->_fetch_primary_key();        
        $this->ci=& get_instance();
        
    }
    
    private function _fetch_table()
    {
        if ($this->_table == NULL){
             $this->_table = plural(preg_replace('/(_m|_model)?$/', '', strtolower(get_class($this))));
            } 
            
    }    
   
   private function  _fetch_primary_key()
   {
   if($this->_pk_field == NULL AND get_class($this)!=='MY_Model'){
	    $sql="SELECT k.column_name FROM information_schema.table_constraints t JOIN information_schema.key_column_usage k USING(constraint_name,table_schema,table_name) WHERE t.constraint_type='PRIMARY KEY' AND t.table_name='".$this->_table."'";
                     $this->_pk_field = $this->_database->query($sql)->row()->column_name;
    }

   }
   
   
   
   
    
   public function get_fields(){
       $sql="select column_name from INFORMATION_SCHEMA.COLUMNS where table_name = '".$this->_table."'";
       return array_map(function($row){return $row['column_name'];},$this->_database->query($sql)->result_array());
   }
   


   /*
     * Get row by pk_field
     */
    public function get($_pk_field)
    {
        $data=$this->db->get_where($this->_table,array($this->_pk_field=>$_pk_field),1);
        if (!$data){
            $error=$this->db->error();
            $this->ci->handleError($error['code'],$error['message'] );
        } else {
        
        return $data->result();
        }
    }
    
    public function get_where($data,$limit=NULL){
        $data=$this->db->get_where($this->_table,$data,$limit);
        if (!$data){
            $error=$this->db->error();
            $this->ci->handleError($error['code'],$error['message'] );
        } else {
        return $data->result();
        }
    }


    /*
     * Get all rows
     */
    public function get_all()
    {
        
        $data=$this->last_result=$this->db->get($this->_table);
        if (!$data){
            $error=$this->db->error();
            $this->ci->handleError($error['code'],$error['message'] );
        }
        return $data->result();
        
    }
    
    /*
     *  function to add new row
     */
    public function add($params)
    
    {
        
        if ($this->db->insert($this->_table,$params)===FALSE) {
           $error=$this->db->error();
           $this->ci->handleError($error['code'],$error['message'] );
           } else {
        return $this->db->insert_id();
        }
    }
    
    /*
     * function to update row
     */
    public function update($_pk_field,$params)
    {
        
        $this->db->where($this->_pk_field,$_pk_field);
        $res=$this->db->update($this->_table,$params);
        if (!$res){
            $error=$this->db->error();
            $this->ci->handleError($error['code'],$error['message'] );
        }
        return $res;
    }
    
    /*
     * delete rows
     */
    public function delete($_pk_field)
    {
        $res=$this->db->delete($this->_table,array($this->_pk_field=>$_pk_field));
        if (!$res){
                $error=$this->db->error();
            $this->ci->handleError($error['code'],$error['message'] );
        }
        return $res;
    }
    
  /**
   * 
   * @param type $_pk_field
   * @return boolean| $data
   */
    public function get_row($_pk_field){
        $data=$this->get($_pk_field);
        if(count($data)>0){
            return $data[0];
        } 
        return FALSE;
    }
    
    public function get_row_where($data) {
        $data= $this->get_where($data, 1);
        if(count($data)>0){
            return $data[0];
        } 
        return FALSE;
    }
    
}