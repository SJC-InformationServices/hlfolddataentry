<?php

function articlecreate()
{
global $stackertable, $mysqlidb, $mysqliconnect, $mysqlidb, $mediacontrol, $selectedmedia, $selectedpage, $hlcategorytable, $hlconstantstable; 
echo "<table class=\"createarticle\">";
echo "<tr>
<td class=\"verysmall\">Page</td>
<td class=\"verysmall\">Pos</td>
<td class=\"medium\">Item No</td>
<td class=\"small\">Category</td>
<td class=\"large\">Text Lines</td>
<td class=\"small\">Price</td>
<td class=\"small\">Pricelb</td>
<td class=\"small\">Pricekg</td>
<td class=\"small\">Layout</td>
<td class=\"small\">UoS</td>
<td class=\"medium\">Measure</td>
<td class=\"medium\">Instructions</td>
<td class=\"small\">Logo</td></tr>";

//make the hlcategories array
$query = "SELECT categoryname FROM $hlcategorytable order by categoryname";
$result = mysqli_query($mysqliconnect,$query);
$querylayout = "SELECT hlconstantvalue FROM $hlconstantstable WHERE hlconstants = 'elementlayout'";
$layoutresults = mysqli_query($mysqliconnect,$querylayout);
echo "<tr>
<td><input  name=\"page\" value=\"$selectedpage\"></td>
<td><input  name=\"position\" onChange=\"positionnan(this.value)\"></td>
<td><input  name=\"articlenumber\" onblur=\"artname(this.value,document.createarticles.position.value)\"></td>";
//make the category pulldown
echo "<td><select name=\"category\"> <option value = \"\" selected=\"\">";
while($hlcategories = mysqli_fetch_array($result, MYSQLI_ASSOC))
{
foreach ($hlcategories as  $key => $value) {
	echo "<option value=\"$value\" >$value </option>\n";
}
}
echo "</select>";
echo "</td>";
echo "<td><textarea name=\"textlines\" rows=\"2\" cols=\"60\"></textarea></td>
<td><input  name=\"price\" id=\"createarticlesprice\" onkeyup=\"checkprice(this.id)\" value=\"0.00\"></td>
<td><input  name=\"pricelb\" id=\"createarticlespricelb\" onkeyup=\"checkpricelb(this.id)\" value=\"0.00\"></td>
<td><input  name=\"pricekg\" id=\"createarticlespricekg\" onChange=\"checkprice(this.id)\" disabled value=\"0.00\"></td>";
echo "<td><select name=\"elementlayout\"> <option value = \"\" selected=\"\">";
while($hllayouts = mysqli_fetch_array($layoutresults, MYSQLI_ASSOC))
{
foreach ($hllayouts as  $key => $value) {
	echo "<option value=\"$value\" >$value </option>\n";
}
}
echo "</select>";
echo "</td>";
$logoarray = array('', 'AAA','21 Day/AAA', 'Country Kitchen', 'Floral', 'Ontario', 'Organic', 'Ontario/Organic', 'First of the Season', 'Best for the bbq','Driscoll�s','Calvo', 'Delmonte','Dole','New');
echo "<td><input  name=\"unitofsale\"></td>
<td><input  name=\"measure\"></td>
<td><input  name=\"instructions\" maxlength = \"200\"></td>
<td><select name=\"logo\" id=\"logo\" <option value = \"\" selected=\"\">";
foreach ($logoarray as $val) {
	echo "<option value=\"$val\" >$val </option>\n";
}
echo "</select><br />";
echo "</td><tr>
<td ></td><td></td><td></td><td></td><td><input  name=\"articlename\" id=\"articlename\"  disabled value=\"\" </td><td></td><td></td><td></td><td>Delete</td><td><input  name=\"deletearticle\" type=\"checkbox\" onclick=submitarticles()></td><td>select art</td>";

$query = "SELECT hlconstantvalue FROM $hlconstantstable WHERE hlconstants = 'artselect'";
$result = mysqli_query($mysqliconnect,$query);
echo "<td><select name=\"artselection\"> <option value = \"\" selected=\"\">";
while($hlartselect = mysqli_fetch_array($result, MYSQLI_ASSOC))
{
foreach ($hlartselect as  $key => $value) {
	echo "<option value=\"$value\" >$value </option>\n";
}
}
echo "</select>";
echo "</td>";
echo "</table>";

}

?>
