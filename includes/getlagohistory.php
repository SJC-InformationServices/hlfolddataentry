<?php
error_reporting(-1);
chdir("/storage/www/hlf/includes");
include "serverconfig.php";

$c = oci_connect("sjcreadonly", "sjcreadonly", "10.3.0.186/cmsanew", "AL32UTF8") OR die('Unable to connect to the database. Error: <pre>' . print_r(oci_error(),1) . '</pre>');

$q = "SELECT 
BENTON.ART.ARTANRC AS ARTICLENUMBER, 
BENTON.ART.ARTBEZC as ARTNAME, 
BENTON.ART.ARTVF10C AS TEXTCOMBINED,
BENTON.PRO.PROBEZC AS ELENAME, 
BENTON.KAT.KATBEZC, 
BENTON.KAT.KATINAC,
BENTON.KOM.KOMBEZC   
FROM 
BENTON.ART ART, 
BENTON.KAV KAV, 
BENTON.KVT KVT, 
BENTON.PRO PRO, 
BENTON.AEZ AEZ, 
BENTON.KAT KAT 
BENTON.KOM KOM,
BENTON.BVW BVW,
BENTON.BLD BLD,
BENTON.SAI SAI
WHERE  
SAIBEZC = '2018',
BENTON.KAT.KATKTYKEYI = 6
AND BENTON.ART.ARTKAVKEYI = BENTON.KAV.KAVKEYI 
AND BENTON.KAV.KAVKVTKEYI = BENTON.KVT.KVTKEYI  
AND BENTON.ART.ARTKEYI = BENTON.AEZ.AEZARTKEYI 
AND BENTON.ART.ARTKAVKEYI = BENTON.AEZ.AEZKAVKEYI 
AND BENTON.AEZ.AEZKAVKEYI = BENTON.PRO.PROKAVKEYI 
AND BENTON.AEZ.AEZPROKEYI = BENTON.PRO.PROKEYI 
AND (BENTON.KVT.KVTBEZC = 'Standard') 
AND BENTON.ART.ARTANRC='$articlenumber' 
and BENTON.KAV.KAVKEYI = BENTON.KAT.KATKAVKEYI
AND BENTON.KOM.PROKEYI = BENTON.PRO.PROKEYI"
;
$s = oci_parse($c, $q);

while ($d = oci_fetch_array($s, OCI_ASSOC)) {
    print_r($d);
}

?>