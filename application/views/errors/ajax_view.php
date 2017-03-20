<?php
$this->output
           ->set_content_type('application/json')
           ->set_output(json_encode($data,JSON_PRETTY_PRINT));
