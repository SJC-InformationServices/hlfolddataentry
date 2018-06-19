<?php
session_start();
if(isset($_SESSION['id']) )
{
include 'serverconfig.php';
$sql = "Update $stackertable set ";
$id = $_REQUEST['id'];
$date = date('Y-m-d H:i');
$offerid = $_REQUEST['media'].str_pad($_REQUEST['page'], 4, "0", STR_PAD_LEFT).str_pad($_REQUEST['position'], 4, "0", STR_PAD_LEFT);
array_pop($_REQUEST);
array_shift($_REQUEST);
foreach($_REQUEST as $varname => "$value")
{
//$value = addslashes($value);
$sql .= "$varname = '$value', ";
}
$sql .= "savedate='$date', offerid='$offerid' where id=$id";

//echo $sql;

$results = mysqli_quer($mysqliconnect, $sql);
if(!$results)
{
echo "See lago Group<br>".mysqli_error($mysqliconnect);
//echo mysqli_error($mysqliconnect)."<br>";
echo $sql;
}
}
else {
header("location:../index.php");
}
?>
