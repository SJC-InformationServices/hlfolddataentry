<?php
session_start();
if(isset($_SESSION['id']) )
{
header('content-type: application/json; charset=utf-8'); 
error_reporting(-1);
include 'serverconfig.php';


if (isset($_REQUEST['articlenumber'])) {
  $artnum = isset($_GET['articlenumber'])?$_GET['articlenumber'] : null; 
  //$media = $_GET['media']; 
  //$page = $_GET['page']; 
  //$position = $_GET['position'];
  foreach($_GET as $k => $v){
    $$k = $v;
  }
  //adding this for change from offer to article no in final dataarray.
//  $artnamefromscreen   = $_GET['textlines'];
       $artname = isset($_GET['articlename']) ? $_GET['articlename']:null;
      /* 
        $price     = isset($_GET['price'])  ?  $_GET['price'] : null;
        $pricelb   = isset($_GET['pricelb']) ? $_GET['pricelb']:null;
        $pricekg   = isset($_GET['pricekg']) ? $_GET['pricekg']:null;
  $elementlayoutget   = isset($_GET['elementlayout']) ? $_GET['elementlayoutget'] : null;
  $elementlayout = trim($elementlayoutget);

	$textlines = isset($_GET['textlines']) ? $_GET['textlines']:null;
 	$unitofsale      = isset($_GET['unitofsale']) ? $_GET['unitofsale']:null;
	$measure      = isset($_GET['measure']) ? $_GET['measure']:null;
 	$instructions      = isset($_GET['instructions']) ? $_GET['instructions']:null;
	$graphicslogo      = isset($_GET['logo']) ? $_GET['logo']:null;
	$category      = isset($_GET['category']) ? $_GET['category']:null;
	$artselection = isset($_GET['artselection']) ? $_GET['artselection']:null;
	$deletearticle = isset($_GET['deletearticle']) ? $_GET['deletearchivel']:null;*/

$checkexistsquery = "SELECT * FROM $stackertable WHERE articlenumber = '$artnum' AND media = '$media' 
and page = '$page' and position = '$position'";
$resultscheck = mysqli_query($mysqliconnect, $checkexistsquery);
$numrows = mysqli_num_rows($resultscheck);

$checkhllagotablequery = "SELECT * FROM $hllagotable WHERE articlenumber = '$artnum'";
$resultscheckhllago = mysqli_query($mysqliconnect, $checkhllagotablequery);
$numrowshllago = mysqli_num_rows($resultscheckhllago);

if($numrows > 0 )
{

	$q = "SELECT page, articlenumber, position, textcombined, $stackermaxfield, price, pricelb, pricekg, elementlayout, elementname, uos, measure, instructions, artselection, graphicslogo, media, category, deletearticle, articlename FROM $stackertable WHERE articlenumber ='$artnum' AND media = '$media' and page = '$page' and position = '$position' AND $stackermaxfield IN  (SELECT MAX($stackermaxfield) FROM $stackertable WHERE  articlenumber ='$artnum' AND media = '$media'
and page = '$page' and position = '$position')";
	$results = mysqli_query($mysqliconnect, $q);	

if(!$results)
{
$error = mysqli_error($mysqliconnect);
echo "Error see lago group this is fetch1<br>";
echo "$error";
}
else
{	
while($lagorecord = mysqli_fetch_array($results, MYSQLI_ASSOC))
{
	// Initialize the PHP variable:
if($lagorecord['page'] == 0)
{
$page = $page;
}
else
{   
  $page = $lagorecord['page'];
}
    if($lagorecord['position']==0)
    {
 //   $position = $position;
    $position = "";
    }
    else
    {
    $position = $lagorecord['position'];
    }

	$artnumber = $lagorecord['articlenumber'];
	$artname   = $lagorecord['articlename'];
	$price     = $lagorecord['price'];
  $pricelb   = $lagorecord['pricelb'];
  $pricekg   = $lagorecord['pricekg'];
  $elementlayout   = $lagorecord['elementlayout'];
	$textlines = $lagorecord['textcombined'];
	$media      = $lagorecord['media'];
//  $elementname = $lagorecord['elementname'];
 	$unitofsale      = $lagorecord['uos'];
	$measure      = $lagorecord['measure'];
 	$instructions      = $lagorecord['instructions'];
	$graphicslogo      = $lagorecord['graphicslogo'];
	$category      = $lagorecord['category'];
	$artselection = $lagorecord['artselection'];
	$deletearticle = $lagorecord['deletearticle'];
	
	$trademarkarray = array("(r)", "(R)", "?", chr(63));
	
		$dataarray = array("page"=>"$page", "position"=>"$position", "articlenumber"=>"$artnumber","category"=>"$category","textlines"=>"$textlines", "price"=>"$price", "pricelb"=>"$pricelb", "pricekg"=>"$pricekg",  "elementlayout"=>"$elementlayout", "unitofsale"=>"$unitofsale", "measure"=>"$measure","instructions"=>"$instructions", "artselection"=>"$artselection","logo"=>"$graphicslogo", "deletearticle"=>$deletearticle, "articlename"=>"$artname");
		//Echo '{"createarticles":'.json_encode($dataarray).'}';
    echo '{"createarticles":'.json_encode($dataarray).'}';
}	
}
}
elseif($numrows == 0 && $numrowshllago > 0)
{
// echo "in the hllagodata fetch";
	$q = "SELECT page, articlenumber, position, textcombined, $lagostackermaxfield, price, pricelb, pricekg, elementlayout, elementname, uos, measure, instructions, artselection, graphicslogo, media, category, deletearticle, articlename FROM $hllagotable WHERE articlenumber ='$artnum' AND $lagostackermaxfield IN  (SELECT MAX($lagostackermaxfield) FROM $hllagotable WHERE  articlenumber ='$artnum') AND media <> 'HLFrawdata'";
	$results = mysqli_query($mysqliconnect, $q);	

  if(!$results)
  {
  $error = mysqli_error($mysqliconnect);
  echo "Error see lago group this is fetch2<br>";
  echo "$error";
  }
  else
  {	
  while($lagorecord = mysqli_fetch_array($results, MYSQLI_ASSOC))
  {
  	// Initialize the PHP variable:
  if($lagorecord['page'] == 0)
  {
  $page = $page;
  }
  else
  {   
    $page = $lagorecord['page'];
  }
  if($lagorecord['position']==0)
  {
   $position = $position;
//    $position = "";
  }
  else
  {
  $position = $lagorecord['position'];
  }
		$artnumber = $lagorecord['articlenumber'];
	$artname   = $lagorecord['articlename'];
	$price     = $lagorecord['price'];
  $pricelb   = $lagorecord['pricelb'];
  $pricekg   = $lagorecord['pricekg'];
  $elementlayout   = $lagorecord['elementlayout'];
	$textlines = $lagorecord['textcombined'];
	$media      = $lagorecord['media'];
//  $elementname = $lagorecord['elementname'];
 	$unitofsale      = $lagorecord['uos'];
	$measure      = $lagorecord['measure'];
 	$instructions      = $lagorecord['instructions'];
	$graphicslogo      = $lagorecord['graphicslogo'];
	$category      = $lagorecord['category'];
	$artselection = $lagorecord['artselection'];
	$deletearticle = $lagorecord['deletearticle'];
	
	$trademarkarray = array("(r)", "(R)", "?", chr(63));
	
  $dataarray = array("page"=>"$page", "position"=>"$position", "articlenumber"=>"$artnumber","category"=>"$category","textlines"=>"$textlines", "price"=>"$price", "pricelb"=>"$pricelb", "pricekg"=>"$pricekg", "elementlayout"=>"$elementlayout", "unitofsale"=>"$unitofsale", "measure"=>"$measure","instructions"=>"$instructions" , "artselection"=>"$artselection", "logo"=>"$graphicslogo","deletearticle"=>$deletearticle, "articlename"=>"$artname" );

    echo '{"createarticles":'.json_encode($dataarray).'}';
	}
}	
} //with the elseif that fetches hllagodata
else
{
//echo "just setting the variables without fetch";
$page = $page;
$position = $position;

	$trademarkarray = array("(r)", "(R)", "?", chr(63));
	
  $dataarray = array("page"=>"$page", "position"=>"$position", "articlenumber"=>"$artnum", "category"=>"$category","textlines"=>"$textlines", "price"=>"$price", "pricelb"=>"$pricelb", "pricekg"=>"$pricekg", "elementlayout"=>"$elementlayout", "unitofsale"=>"$unitofsale", "measure"=>"$measure","instructions"=>"$instructions" , "artselection"=>"$artselection", "logo"=>"$graphicslogo","deletearticle"=>$deletearticle, "articlename"=>"$artname" );

    echo '{"createarticles":'.json_encode($dataarray).'}';
}

}
}
else {
header("location:../index.php");
}
?>
