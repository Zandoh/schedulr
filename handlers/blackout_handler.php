<?php
require_once('DBcore.class.php');


 function processBlackouts($json){

        $DBcore = new DBcore();
        //this will be the json arr that is given
        $arr = json_decode($json);
        foreach($arr as $row){
            $array = get_object_vars($row);

            $congregation_ID = $array["id"];
            $clearResult = $DBcore->clearBlackouts($congregation_ID);
            if ($clearResult){
                 //good clear
            }
            else{
                return false;
            }
        }  

        foreach($arr as $row){
            $array = get_object_vars($row);
            $congregation_ID = $array["id"];
            $start_date = $array["start_date"];
            $end_date = $array["end_date"];
            $insertResult = $DBcore->insertBlackouts($congregation_ID, $start_date, $end_date);
            if ($insertResult){
                 //good clear
            }
            else{
                return false;
            }    
        }
       return true;
    }
?>