<?php
error_reporting(0);
session_start();
if(isset($_SESSION['id']) )
{
include 'serverconfig.php';

$media = $_REQUEST['media'];
$page = $_REQUEST['page'];
$user = $_REQUEST['user'];
$date = date('Y-m-d H:i');

$sql = "update $stackertable set markedforexport = 1, savedate='$date' where media = '$media' and page = '$page' and markedforexport = 0 ";
echo $sql;
$results = mysqli_query($mysqliconnect,$sql);
if(!$results)
{
echo "Update failed";
echo "<br>".mysqli_error($mysqliconnect);
}
else
{
echo "Page Marked for Export";
//submitform('selectedpage');
}
$mailsubject = "Media $media, page $page has been updated by HLF $user.";
$mailmessage = "Media $media, page $page has been updated and will be applied in Lago within 30 minutes.";
}
?>
