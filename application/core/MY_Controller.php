<?php

/**
 *  MY_Controller
 *
 * @author BarszPaw
 */
class MY_Controller extends CI_Controller{
    
    
    function __construct() {
        parent::__construct();    
        //set_error_handler(array($this, 'handleError'));
    }

     /**
     * Handles errors regarding error_reporting value
     * @param int $errno
     * @param string $errstr
     * 
     */
    public function handleError($errno, $errstr) {
        //if (error_reporting() & $errno) {
            //throw new ErrorException($errstr, $errno);
            $this->load->view('errors/ajax_view',array('data'=>
                array(
                    'message'=>$errno.": ".$errstr,
                    'success'=>FALSE
                )
                ));
                
            
        ///}
    }
    
    /**
     *  Wyswietla komunikat z flagą success==TRUE
     * @param string $msg komunikat
     */
    public function sucess($msg) {
            $this->load->view('ajax_view',array('data'=>
                array(
                    'message'=>$msg,
                    'success'=>TRUE
                )
                ));
    }
    
    /**
     * Wyswietla komunikat z flagą success==FALSE
     * @param string $msg komunikat
     */
    public function failed($msg) {
            $this->load->view('ajax_view',array('data'=>
                array(
                    'message'=>$msg,
                    'success'=>FALSE
                )
                ));
    }
    
    
}
