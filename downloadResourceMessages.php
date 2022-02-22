<?php 
 
// Load the database configuration file 
require_once "dbconfig.php";




$myfiles = mysqli_query($con,"SELECT $SystemMessage_Table.*,$Translation_Table.*,$SystemMessage_Table.id as sysid FROM " . $SystemMessage_Table . " LEFT JOIN " . $Translation_Table . " ON $Translation_Table.sys_message_id = $SystemMessage_Table.id WHERE application_id = '" . $_GET['application'] . "' AND resource_type = 2");

if(mysqli_num_rows($myfiles) > 0){
    $delimiter = ",";
    $filename = "s_Id" . date('Y-m-d') . ".csv";
    
    //create a file pointer
    $f = fopen('php://memory', 'w');
    
    //set column headers
    $fields = array('id','Title', 'Message','Translate');
    fputcsv($f, $fields, $delimiter);
    
    //output each row of the data, format line as csv and write to file pointer
    while ($row = mysqli_fetch_assoc($myfiles)){
        if($row['language_id'] == $_GET['lang']):$lantrans = $row['translation_msg']; else:$lantrans = null; endif;
        //$status = ($row['status'] == '1')?'Active':'Inactive';
        $lineData = array($row['sysid'], $row['Title'], $row['Message'],$lantrans);
        fputcsv($f, $lineData, $delimiter);
    }
    
    //move back to beginning of file
    fseek($f, 0);
    
    //set headers to download file rather than displayed
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
    
    //output all remaining data on a file pointer
    fpassthru($f);
}
else
{
    $excelData = 'No records found...'. "\n";
    echo $excelData;
}
exit;


 
?>