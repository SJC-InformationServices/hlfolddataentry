<?php
error_reporting(-1);
chdir("/storage/www/hlf/includes");
include "serverconfig.php";

$c = oci_connect("sjcreadonly", "sjcreadonly", "10.3.0.186/cmsanew", "AL32UTF8") OR die('Unable to connect to the database. Error: <pre>' . print_r(oci_error(),1) . '</pre>');

function key2name($key)
{
$key = intval($key);

$path = str_pad(intval(($key-1024*intval($key/1024))/32),3,0,STR_PAD_LEFT)."/".str_pad((($key-1024*intval($key/1024))/32 - intval(($key-1024*intval($key/1024))/32))*32,3,0,STR_PAD_LEFT);

return $path;
}

$ds = '{"ip":"localhost","user":"admin","password":"pi1g0","database":"sdm","tableprefix":"sdm","catalogtype":"SDM","lagoversion":"3.12","lagoip":"10.3.0.186","lagouser":"sjcreadonly","lagopassword":"sjcreadonly","lagosid":"cmsanew","lagodbprefix":"LESMILL","lagocatalogtype":"SDM","lfspath":{"images":{"highres":"/mnt/Lago_LFS/lesmill/VolumesLM/hires_","previews":"/mnt/Lago_LFS/lesmill/VolumesLM/prev__"},"documents":{"quark":"/mnt/Lago_LFS/lesmill/VolumesLM/doc___","pdf":"/mnt/Lago_LFS/lesmill/VolumesLM/cor___","templates":"/mnt/Lago_LFS/lesmill/VolumesLM/templ_"}},"importpaths":{"xmlscripts":"/storage/www/sdm/lagoimp/image_scripts","errorscripts":"/storage/www/sdm/lagoimp/image_errors","scriptlogs":"/storage/www/sdm/lagoimp/image_logs"},"defaultassettype":"SDM","defaultassetstatus":"UnRetouched"}';

$d = json_decode($ds, true);
$u = $d['lagouser'];
$p = $d['lagopassword'];
$s = $d['lagoip']."/".$d['lagosid'];
$oc = oci_connect("$u", "$p", "$s", "AL32UTF8");
$destPth = "/mnt/dropbox/DNA_Kevin_Noseworthy/HighlandLFS/";

$elSql = "select *
from BENTON.ART,BENTON.PRO,BENTON.KOM,BENTON.AEZ,BENTON.BVW,BENTON.BLD,BENTON.KAT,BENTON.SAI where
SAIBEZC = '2018 HL Retail' and 
KATSAIKEYI = SAIKEYI and 
KATKEYI = PROKATKEYI and PRODELS = 0 and
ARTKEYI = AEZARTKEYI and AEZPROKEYI = PROKEYI and
PROKEYI = KOMPROKEYI and KOMKEYI = BVWOBJKEYI and
BVWBLDKEYI = BLDKEYI and BLDDELS = 0 and KOMPLAS =1";
$qry = oci_parse($oc, $elSql);
oci_execute($qry);
while ($d = oci_fetch_array($qry, OCI_ASSOC)) {
    $d=mysqli_real_escape_string($mysqliconnect, JSON_ENCODE($d));
    $insqry = "insert into `hllagoimages` (`rawdata`) values ('$d')";
    $ins = mysqli_query($mysqliconnect, $insqry);
}

?>