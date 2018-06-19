


<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">
<head><title>Highland Testing</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=\"UTF-8\">
<meta http-equiv=\"refresh\" content=\"3600;url=index.php\">


</head>
<body>
<form action = "index.php" id=\"createarticles\" method = 'post'>

<?php 
$mysqliconnect = mysqli_connect('localhost', 'lago', 'como888');
if (!$mysqliconnect) 
{
	die('mysqli_login failed to connect : ' . mysqli_error());
}
$mysqlidb = mysqli_select_db('retailtesting', $mysqliconnect);
if (!$mysqlidb)
{
	die('mysqli_db fail: ' . mysqli_error());
}

$stackertable = "hldata";
$stackermaxfield = "stackerfield";
$mediacontrol = "hlmediacontrol";
$hlcategorytable = "hlcategory";
echo "tables are connected!";

$query = "SELECT categoryname FROM $hlcategorytable ORDER BY categoryname";
$results = mysqli_query($mysqliconnect, $query);

echo "<select name = "categoryfield">";
foreach($results as $value)
{ echo "<option value=\"$value=\">$value</option>\n";
}


echo '</select>';
echo '</form>';
echo '</body>';
echo '</html>';
?>
