<?php
$msg=$data->getMessage();
if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE) {
    $msg .= "\nBacktrace:\n";
        foreach (debug_backtrace() as $error){
            if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0){
                        $msg.="	File: ".$error['file']."\n".
			"Line: ".$error['line']."\n".
			"Function: :".$error['function']."\n";
                
            }
            }
        }



$this->output
           ->set_content_type('application/json')
           ->set_output(json_encode(
                    (object)array('message'=>$msg,'success'=>FALSE)
                   ,JSON_PRETTY_PRINT));


