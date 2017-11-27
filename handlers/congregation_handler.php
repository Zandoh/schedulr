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



function createEditCongregationForm($congregation_ID){
    $DBcore = new DBcore();
    $congregation = array();
    $congregation = $DBcore->selectOneCongregation($congregation_ID);
    //congregation_ID, congregation_name, congregation_street_address, congregation_phone, congregation_bus_need, congregation_city, congregation_state, congregation_zip
     foreach($congregation as $row) {  
        $formStr = '<h1>Edit Congregation</h1>
                <form id="add-user" name="editUserSubmit" method="post">
                <input type="hidden" name="congregation_ID" value="'.$row['congregation_ID'].'">
                  <div class="form-group col-md-4">
                    <label for="add-email">Name</label>
                    <input type="text" class="form-control" id="add-email" placeholder="Name" name="congregation_name" value="'.$row['congregation_name'].'">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="add-phone-number">Phone Number</label>
                    <input type="text" class="form-control" id="add-phone-number" placeholder="Phone Number" name="congregation_phone" value="'.$row['congregation_phone'].'">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="add-email">Street Address</label>
                    <input type="text" class="form-control" id="add-email" placeholder="Address" name="congregation_street_address" value="'.$row['congregation_street_address'].'">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="add-fName">City</label>
                    <input type="text" class="form-control" id="add-fName" placeholder="City" name="congregation_city" value="'.$row['congregation_city'].'">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="add-lName">State</label>
                    <input type="text" class="form-control" id="add-lName" placeholder="State" name="congregation_state" value="'.$row['congregation_state'].'">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="add-lName">Zip Code</label>
                    <input type="text" class="form-control" id="add-lName" placeholder="Zip" name="congregation_zip" value="'.$row['congregation_zip'].'">
                  </div>
                  <div class="form-group col-md-4">
                   <button type="submit" class="submit" name="editCongregationSubmitButton" value="edit" id="admin-add-user-submit">Save Edits</button>
                  </div>
                </form>';
        }
            return $formStr;

}

function createAddCongregationForm(){
    $formStr = '<h1>Add Congregation</h1>
                <form id="add-user" name="addCongregationSubmit" method="post">
                <input type="hidden" name="congregation_ID">
                  <div class="form-group col-md-4">
                    <label for="add-email">Name</label>
                    <input type="text" class="form-control" id="add-email" placeholder="Name" name="congregation_name">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="add-phone-number">Phone Number</label>
                    <input type="text" class="form-control" id="add-phone-number" placeholder="Phone Number" name="congregation_phone">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="add-email">Street Address</label>
                    <input type="text" class="form-control" id="add-email" placeholder="Address" name="congregation_street_address">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="add-fName">City</label>
                    <input type="text" class="form-control" id="add-fName" placeholder="City" name="congregation_city">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="add-lName">State</label>
                    <input type="text" class="form-control" id="add-lName" placeholder="State" name="congregation_state">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="add-lName">Zip Code</label>
                    <input type="text" class="form-control" id="add-lName" placeholder="Zip" name="congregation_zip">
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

?>