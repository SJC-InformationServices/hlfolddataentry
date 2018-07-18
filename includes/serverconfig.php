<?php
$dbfile = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/archivedb.json"),true);
$dbcfg = $dbfile['hlfdataentryprod'];
//print_r($dbcfg);
$mysqliconnect = mysqli_connect(
	$dbcfg['server'], 
	$dbcfg['uid'], 
	$dbcfg['pwd'], 
	$dbcfg['db']);
if (!$mysqliconnect)
{
	die('mysqli_login failed to connect : ' . mysqli_error($mysqliconnect));
}
$mysqlidb = mysqli_select_db($mysqliconnect, 'hlf');
if (!$mysqlidb)
{
	die('mysqli_db fail: ' . mysqli_error());
}
$hlusertable = "hlusertable";
$stackertable = "hldata";
$stackertable2 = "hldata";
$stackermaxfield = "id";
$mediacontrol = "hlmediacontrol";
$hlcategorytable = "hlcategory";
$importdir = "importtext";
$hllagodatafileforload = "HLF_Lago_Loadfile.txt";
$hllagorawdatafileforload = "HLF_Raw_Product_Data3clean.txt";
$exportdir = "exportedtext";

$exportfileforload = "HLF_Retail_LoadFile-".date('Ymd-His').".imp";
$cataloguefileforload = "HLF_makecatalogue.imp";
//$cataloguefileforload = "makecatalogue-".date('Ymd-His').".imp";
$deletefileforload = "HLF_Delete_LoadFile-".date('Ymd-His').".imp";
$elementonlyfile = "HLF_ElementOnly_Loadfile-".date('Ymd-His').".imp";

$hllagotable = "hllagodata";
$lagostackermaxfield = "id";
$hlconstantstable = "hlconstants";
$layouttable = "hltemplates";
$layouttable2 = "hltemplates2";


// Create a function for escaping the data.
function escape_data ($data) {
	global $mysqliconnect;
	// Address Magic Quotes.
	if (ini_get('magic_quotes_gpc')) {
		$data = stripslashes($data);
	}
	
	// Check for mysqli_real_escape_string() support.
	if (function_exists('mysqli_real_escape_string')) {
		global $mysqliconnect; // Need the connection.
		$data = mysqli_real_escape_string ($mysqliconnect,trim($data));
	} else {
		$data = mysqli_real_escape_string ($mysqliconnect, trim($data));
	}

	// Return the escaped value.	
	return $data;

} // End of function.

?>
