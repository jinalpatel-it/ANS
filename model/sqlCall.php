<?php
require_once "../dbconfig.php";
// if update system message
if (isset($_POST['updateSystemMessage'])) {

    if ($_POST['isNew'] == false) {
        $sql = "INSERT INTO " . $Translation_Table . " (id,sys_message_id,language_id,translation_msg) VALUES (NULL,'" . $_POST['SysId'] . "','" . $_POST['Lang'] . "','" . mysqli_real_escape_string($con, $_POST['Message']) . "')";
    } else {
        $sql = "UPDATE " . $Translation_Table . " SET translation_msg='" . mysqli_real_escape_string($con, $_POST['Message']) . "'  WHERE language_id=" . $_POST['Lang'] . " AND sys_message_id = " . $_POST['SysId'];
    }
    $result = mysqli_query($con, $sql);
    if ($result) {
        echo json_encode(array('status' => TRUE, 'response' => '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button> Message Updated......</div>'));
    } else {

        echo json_encode(array('status' => FALSE, 'response' => mysqli_error($con)));
    }
}

//Add SystemMessage
if (isset($_POST['addSystemMessage'])) {
    //$sql = "INSERT INTO " . $SystemMessage_Table . " SET Title='" . $_POST['Title'] . "',Message='".$_POST['Message']."'  WHERE id=" . $_POST['SysId'];
    $sql = "INSERT INTO " . $SystemMessage_Table . " (  Title,Message,application_id,module_id) VALUES ('" . $_POST['Title'] . "', '" . $_POST['Message'] . "','" . $_POST['Application'] . "','" . $_POST['module_id'] . "')";
    $result = mysqli_query($con, $sql);
    $message_id = mysqli_insert_id($con);
    if ($result) {
        echo json_encode(array('status' => TRUE, 'response' => '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button> Message Updated......</div>'));
    } else {

        echo json_encode(array('status' => FALSE, 'response' => '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button> Message Not Updated......</div>'));
    }
}

if (isset($_POST['deleteSystemMessage'])) {
    $sql = "DELETE FROM " . $SystemMessage_Table . " WHERE id=" . $_POST['SysId'];

    $result = mysqli_query($con, $sql);
    if ($result) {
        echo json_encode(array('status' => TRUE, 'response' => '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button> Message Deleted......</div>'));
    } else {

        echo json_encode(array('status' => FALSE, 'response' => '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button> Message Not Deleted......</div>'));
    }
}



if (isset($_POST['newApplication'])) {
    $sql = mysqli_query($con, "INSERT INTO  $Application_Table (name) VALUES ('" . $_POST['name'] . "')");


    if ($sql) {
        echo json_encode(array('status' => TRUE, 'response' => '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button> Message Deleted......</div>'));
    } else {

        echo json_encode(array('status' => FALSE, 'response' => mysqli_error($con)));
    }
}
if (isset($_POST['addModule'])) {
    $sql = mysqli_query($con, "INSERT INTO  $Modules_Table (name, application_id) VALUES ('" . $_POST['moduleName'] . "', '" . $_POST['Application'] . "')");
    if ($sql) {
        echo json_encode(array('status' => TRUE, 'response' => '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button>Module added successfully.</div>'));
    } else {
        echo json_encode(array('status' => FALSE, 'response' => mysqli_error($con)));
    }
}


if (isset($_POST['getApplication'])) {
    $sql = mysqli_query($con, "SELECT * FROM  $Application_Table");


    if ($sql) {
        if (mysqli_num_rows($sql) > 0) :
            $options = '<option value="">Select Application</option>';
            while ($row = mysqli_fetch_assoc($sql)) :
                $options .= "<option value=" . $row['id'] . ">" . $row['name'] . "</option>";
            endwhile;
            echo json_encode(array('status' => TRUE, 'data' =>  $options));
        else :
            echo json_encode(array('status' => FALSE, 'response' => 'No Data Found'));
        endif;
    } else {

        echo json_encode(array('status' => FALSE, 'response' => mysqli_error($con)));
    }
}



if (isset($_POST['getLang'])) {
    $sql = mysqli_query($con, "SELECT * FROM  $lang_Table");


    if ($sql) {
        if (mysqli_num_rows($sql) > 0) :
            $options = '';
            while ($row = mysqli_fetch_assoc($sql)) :
                $options .= "<option value=" . $row['id'] . ">" . $row['name'] . "</option>";
            endwhile;
            echo json_encode(array('status' => TRUE, 'data' =>  $options));
        else :
            echo json_encode(array('status' => FALSE, 'response' => 'No Data Found'));
        endif;
    } else {

        echo json_encode(array('status' => FALSE, 'response' => mysqli_error($con)));
    }
}

if (isset($_POST['newLang'])) {
    $sql = mysqli_query($con, "INSERT INTO  $lang_Table (name,shortname) VALUES ('" . $_POST['name'] . "','" . ucfirst($_POST['s_name']) . "')");


    if ($sql) {
        echo json_encode(array('status' => TRUE, 'response' => '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button> Message Deleted......</div>'));
    } else {

        echo json_encode(array('status' => FALSE, 'response' => mysqli_error($con)));
    }
}


if (isset($_POST['addFile'])) {
    $sql = mysqli_query($con, "INSERT INTO  $resources_Table (title) VALUES ('" . $_POST['title'] . "')");
    if ($sql) {
        echo json_encode(array('status' => TRUE, 'response' => '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button> File Added......</div>'));
    } else {

        echo json_encode(array('status' => FALSE, 'response' => mysqli_error($con)));
    }
}


if (isset($_POST['updateFileName'])) {
    $sql = mysqli_query($con, "UPDATE $resources_Table  SET title = '".$_POST['title']."' WHERE id = '".$_POST['id']."'");
    if ($sql) {
        echo json_encode(array('status' => TRUE, 'response' => '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button> File Updated......</div>'));
    } else {

        echo json_encode(array('status' => FALSE, 'response' => mysqli_error($con)));
    }
}


