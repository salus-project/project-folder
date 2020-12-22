<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    session_start();
    
    if($_SERVER['REQUEST_METHOD']=='GET'){
        $output=["status"=>false, "error"=>"", "result"=>""];
        switch($_GET['name']){
            case 'nic':
                $value=trim($_GET['value']);
                /*if(strlen($value)<5){
                    $output["error"]="Too short name.";
                    break;
                }
                if(in_array(substr($value,0,1), ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9']) ){
                    $output["error"]="Name should start with a letter";
                    break;
                }
                if( preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $value) ){
                    $output["error"]="Name can only contains valid characters.";
                    break;
                }*/
                $query = "select NIC_num from civilian_detail where NIC_num in ('".$value."', '".strtolower($value)."', '".ucfirst($value)."', '".ucwords($value)."', '".strtoupper($value)."');";
                $result = $con->query($query);
                if($result->num_rows>0){
                    $output["error"]="Account already exist.";
                }else{
                    $output["status"]=true;
                    $output["result"]="Account available";
                }
                break;
            case 'phone_num':
                $output["status"]=true;
                $output["result"]="";
                break;
            case 'email':
                $output["status"]=true;
                $output["result"]="";
                break;
        }
        echo json_encode($output);
    }