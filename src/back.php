<?php
 // mobile APP backend
define('BACKEND', true);

if ( isset($_REQUEST['action']) ) {
    switch    ($_REQUEST['action'])
    {    
        case 'auth': 
            $response = ["status" => true, "message" => 'Backend Auth'];
			echo json_encode($response);
            break;     
        case 'get_news':
            $response = ["status" => true, "message" => 'Backend News'];
			echo json_encode($response);
            break;

    } // switch action
}








