<?php
require_once('DBcore.class.php');


function getCongregationOption(){
    $DBcore = new DBcore();
    $congArr = array();
    $congArr = $DBcore->selectAllCongregations();
    $optionStr = '';

    foreach($congArr as $row){
        $congregation_ID = $row['congregation_ID'];
        $congregation_name = $row['congregation_name'];


        $optionStr .= '<option value="'.$congregation_ID.'">'.$congregation_name.'</option>';

    }//end of foreach

    return $optionStr;
}

function returnCongregations() {
    $DBcore = new DBcore();
    $congArr = array();
    $congArr = $DBcore->selectAllCongregations();
    $json = array();

    foreach($congArr as $row) {
        $cong = array(
            'congID' => $row['congregation_ID'],
            'congName' => $row['congregation_name']
        );
        array_push($json, $cong);
    }

    $jsonstring = json_encode($json);

    return $jsonstring;
}


function getCongregationSelected($congregation_Current){
    $DBcore = new DBcore();
    $congArr = array();
    $congArr = $DBcore->selectAllCongregations();
    $optionStr = '';

    foreach($congArr as $row){
        $congregation_ID = $row['congregation_ID'];
        $congregation_name = $row['congregation_name'];

        if($congregation_Current == $congregation_ID){
            $optionStr .= '<option value="'.$congregation_ID.'" selected>'.$congregation_name.'</option>';
        }
        else{
            $optionStr .= '<option value="'.$congregation_ID.'">'.$congregation_name.'</option>';
        }

    }//end of foreach

    return $optionStr;
}



function createEditCongregationForm($congregation_ID){
    $DBcore = new DBcore();
    $congregation = array();
    $congregation = $DBcore->selectOneCongregation($congregation_ID);
    //congregation_ID, congregation_name, congregation_street_address, congregation_phone, congregation_bus_need, congregation_city, congregation_state, congregation_zip
    foreach($congregation as $row) {  
        $formStr = '<div class="container-fluid admin-container">
                <h1>Edit Congregation</h1>
                <form id="add-user" name="editCongSubmit" method="post">
                <input type="hidden" name="congregation_ID" value="'.$row['congregation_ID'].'">
                  <div class="form-group col-md-4">
                    <label for="edit-cong-name">Name</label>
                    <input type="text" class="form-control" id="edit-cong-name" placeholder="Name" name="congregation_name" value="'.$row['congregation_name'].'">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="edit-cong-number">Phone Number</label>
                    <input type="text" class="form-control" id="edit-cong-number" placeholder="Phone Number" name="congregation_phone" value="'.$row['congregation_phone'].'">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="edit-cong-address">Street Address</label>
                    <input type="text" class="form-control" id="add-cong-address" placeholder="Address" name="congregation_street_address" value="'.$row['congregation_street_address'].'">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="edit-cong-city">City</label>
                    <input type="text" class="form-control" id="edit-cong-city" placeholder="City" name="congregation_city" value="'.$row['congregation_city'].'">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="edit-cong-state">State</label>
                    <input type="text" class="form-control" id="edit-cong-state" placeholder="State" name="congregation_state" value="'.$row['congregation_state'].'">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="edit-cong-zip">Zip Code</label>
                    <input type="text" class="form-control" id="edit-cong-zip" placeholder="Zip" name="congregation_zip" value="'.$row['congregation_zip'].'">
                  </div>
                  <div class="form-group col-md-4">
                   <button type="submit" class="submit" name="editCongregationSubmitButton" value="edit" id="admin-add-user-submit">Save Edits</button>
                  </div>
                </form>
                </div>';
    }
    return $formStr;

}

function createAddCongregationForm(){
    $formStr = '<h1>Add Congregation</h1>
                <form id="add-user" name="addCongSubmit" method="post">
                <input type="hidden" name="congregation_ID">
                  <div class="form-group col-md-4">
                    <label for="add-congName">Name</label>
                    <input type="text" class="form-control" id="add-congName" placeholder="Name" name="congregation_name">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="add-cong-number">Phone Number</label>
                    <input type="text" class="form-control" id="add-cong-number" placeholder="Phone Number" name="congregation_phone">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="add-cong-street">Street Address</label>
                    <input type="text" class="form-control" id="add-cong-street" placeholder="Address" name="congregation_street_address">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="add-cong-city">City</label>
                    <input type="text" class="form-control" id="add-cong-city" placeholder="City" name="congregation_city">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="add-cong-state">State</label>
                    <input type="text" class="form-control" id="add-cong-state" placeholder="State" name="congregation_state">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="add-cong-zip">Zip Code</label>
                    <input type="text" class="form-control" id="add-cong-zip" placeholder="Zip" name="congregation_zip">
                  </div>
                  <div class="form-group col-md-4">
                   <button type="submit" class="submit" name="submitAddedCongregation" value="submitAddedCongregation" id="admin-add-user-submit">Add Congregation</button>
                  </div>
                </form>';

    return $formStr;
}

function editCongregation($congregation_ID, $congregation_name, $congregation_street_address, $congregation_phone, $congregation_bus_need, $congregation_city, $congregation_state, $congregation_zip){
    $DBcore = new DBcore();
    $result = array();
    $result = $DBcore->editOneCongregation($congregation_ID, $congregation_name, $congregation_street_address, $congregation_phone, $congregation_bus_need, $congregation_city, $congregation_state, $congregation_zip);
    if ($result) {
        return true;
    } else {
        return false;
    }
}


function addCongregation($congregation_name, $congregation_street_address, $congregation_phone, $congregation_bus_need, $congregation_city, $congregation_state, $congregation_zip){
    $DBcore = new DBcore();
    $result = array();
    $result = $DBcore->addOneCongregation($congregation_name, $congregation_street_address, $congregation_phone, $congregation_bus_need, $congregation_city, $congregation_state, $congregation_zip);
    if ($result) {
        return true;
    } else {
        return false;
    }

}

function deleteCongregation($congregation_ID){
    $DBcore = new DBcore();
    $result = array();
    $result = $DBcore->removeOneCongregation($congregation_ID);
    if ($result) {
        return true;
    } else {
        return false;
    }

}


function generateCongregationSchedule(){
    $optionStr = "";
    $congCount = "";
    $previousDate = "";
    $flippyBit = true;

    $DBcore = new DBcore();
    $congArr = array();
    $blackoutArr = array();
    $nextRotationArr = array();

    $currentCongArr = $DBcore->selectAllCongregations();
    $prevCongArr = $DBcore->selectPreviousRotation();
    $last_date = $DBcore->selectMaxRotationDate();
    $congCount = $DBcore->selectCongCount();

    $previousDate = $last_date;

    // add start and end dates needed for next rotation (add 1 week to each)
    for($i = 0; $i < $congCount; $i++){
        $endDate = date('Y-m-d', strtotime($previousDate."+1 week"));

        $dates = array($previousDate, $endDate, $currentCongArr[$i]['congregation_ID']);

        $blackout = array();
        $blackout = $DBcore->selectCongregationBlackoutDateAfter($currentCongArr[$i]['congregation_ID'],$last_date);

        array_push($nextRotationArr, $dates);
        array_push($blackoutArr, $blackout);

        $previousDate = $endDate;
    }

    while($flippyBit){
      shuffle($nextRotationArr);
      $flippyBit = checkBlackoutDates($nextRotationArr,$blackoutArr);
    }
    //print_r($nextRotationArr);
    //$DBcore->createNewCongregationSchedule($nextRotationArr[0][0], $nextRotationArr[count($nextRotationArr)-1][1]);

    return $optionStr;
}

/*
 * Returns the start date, end date for a given id
 */
function returnBlackouts($id) {
    $DBcore = new DBcore();
    $driverArr = array();
    $driverArr = $DBcore->selectCongregationBlackoutDates($id);
    $json = array();

    foreach($driverArr as $row) {
        $user = array(
            'startDate' => $row['blackout_date_start'],
            'endDate' => $row['blackout_date_end']
        );
        array_push($json, $user);
    }

    $jsonstring = json_encode($json);

    return $jsonstring;
}



function checkBlackoutDates($scheduleArray,$blackoutArray){
    $sizeOf = count($scheduleArray);
    $sizeOfBla = count($blackoutArray);
    //$dirtyBit = false;
    $returnStr = '';
    
    //for each element in the schedule array
    for($j = 0; $j < $sizeOf; $j++){
        //$returnStr .= "<h2>Week " . $j . " Schedule start day: " . $scheduleArray[$j][0] . " CID : " . $scheduleArray[$j][2] . "</h2>";
        // for each element in the blackout array
        for($i = 0; $i < $sizeOfBla; $i++){      
            $sizeOf2DBla = count($blackoutArray[$i]);
            if($sizeOf2DBla > 0){
             for($k = 0; $k < $sizeOf2DBla; $k++){   
                if($scheduleArray[$j][2] == $blackoutArray[$i][$k][congregation_ID]){
                    if($scheduleArray[$j][0] == $blackoutArray[$i][$k][blackout_date_start] || $scheduleArray[$j][0] == $blackoutArray[$j][$k][blackout_date_end]){
                        //$returnStr .= "<p>Blackout start day: " . $blackoutArray[$i][$k][blackout_date_start] .
                        //"</p><p>Blackout ID : " . $blackoutArray[$i][$k][congregation_ID] . "</p>";
                        return false;
                    }
                }
            }   
          }             
        }    
    }
    return true;
}


?>
