<?php
$dbfile = json_decode(file_get_contents("archivedb.json"),true);
$dbcfg = $dbfile['hlfdataentryprod'];
//print_r($dbcfg);
$mysqliconnect = mysqli_connect(
	$dbcfg['server'], 
	$dbcfg['uid'], 
	$dbcfg['pwd'], 
	$dbcfg['db']);
$olddb = mysqli_connect("localhost", "root", "como888!", "hlf");

$qry = mysqli_query($olddb, "select * from `hlmediacontrol`");
while($d = mysqli_fetch_array($qry, MYSQLI_ASSOC))
{
    print_r($d);
    $keys = array_keys($d);
    $values = array_values($d);
    array_walk(        
        $values, 
        function(&$v) { 
            global $olddb,$mysqliconnect;
            $v = mysqli_real_escape_string($mysqliconnect, $v);
        });
    $insSql = "insert ignore into `hlmediacontrol` (`".implode("`,`", $keys)."`) values ('".implode("','", $values)."')";
    $insQry = mysqli_query($mysqliconnect, $insSql);
    if(!$insQry){
        echo "Error Mysql Error".mysqli_error($mysqliconnect);
    }
}
?>