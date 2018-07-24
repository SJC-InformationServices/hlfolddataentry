<?php
error_reporting(-1);
chdir("/storage/www/hlf/includes");
include "serverconfig.php";
$tolist = 'sandi.hancocks@stjoseph.com;luke.buhajczyk@stjoseph.com;jeff.desjardins@stjoseph.com;stefan.schoenebeck@stjoseph.com;maria.gagliano@stjoseph.com;brad.morgan@stjoseph.com;stephanie.walker@stjoseph.com';
//$tolist = 'kevin.noseworthy@stjoseph.com';
$sqlmedia = "Select `media` from $stackertable where markedforexport = '1' and exportedtolago = '0' group by `media`";
$mediaresults = mysqli_query($mysqliconnect, $sqlmedia);
$mailrecords =array();
$updateIds = array();
if (!$mediaresults) {
    echo mysqli_error($mysqliconnect);
} else {
    while ($mediarec = mysqli_fetch_array($mediaresults, MYSQLI_ASSOC)) {
        $loadmedia = $mediarec['media'];
        $mailrecords[$loadmedia]=array();

        $sqlelements = "Select * from $stackertable where markedforexport = 1 and exportedtolago = 0 and media = '$loadmedia' and stackerfield in (select max(stackerfield) from $stackertable where markedforexport = 1 and exportedtolago = 0 and media = '$loadmedia' group by offerid, articlenumber) group by offerid, articlenumber order by deletearticle asc, media, page, position, articlenumber";
        $sqlresults = mysqli_query($mysqliconnect, $sqlelements);
        
        while ($elementresults = mysqli_fetch_array($sqlresults, MYSQLI_ASSOC)) {
            if (!isset($mailrecords[$loadmedia]['keys'])) {
                $mailrecords[$loadmedia];
            }
            if ($elementresults['deletearticle'] == 1) {
                $delart = 'DELETED';
            } else {
                $delart = '';
            }
            $mailstring = "<tr><td>"
            .$elementresults['mediaimportkey']."</td><td>"
            .$elementresults['page']."</td><td>"
            .$elementresults['position']."</td><td>"
            .$elementresults['articlenumber']."</td><td>"
            .$elementresults['textcombined']."</td><td>"
            .$elementresults['artselection']."</td><td>"
            .$elementresults['instructions']."</td><td>"
            .$delart."</td></tr>";
            array_push($mailrecords[$loadmedia], $mailstring);
            array_push($updateIds, $elementresults['id']);
        }
    }
}
if (count($updateIds) > 0) {
    $date = date('Y-m-d H:i');
    $updatestatment = "update $stackertable set 
    loadtolagodate = '$date', exportedtolago = 1
    where 
    id in (".implode(",", $updateIds).")";
    echo "$updatestatment<br>";
    $mailmessage = "";
    foreach ($mailrecords as $k=>$v) {
        $mailmessage .= "<h3>$k</h3><table>
        <thead><tr><td>Media</td><td>Page</td><td>Postion</td><td>ArticleNumber</td>
        <td>TextCombined</td><td>Art Selection</td><td>Instructions</td><td></tr></thead><tbody>".
        implode("", $v)."</tbody>";
        ;
        
    }
    echo $mailmessage;
    $headers = "From: sjc.benton.informationservices@stjoseph.com \r\n";
    $headers.= "Content-Type: text/html; charset=utf-8 \r\n";
    $headers .= "MIME-Version: 1.0 \r\n"; 
    mail($tolist, 'HLF data/art instructions.', $mailmessage, $headers);
    $updateresults = mysqli_query($mysqliconnect, $updatestatment);
}
?>