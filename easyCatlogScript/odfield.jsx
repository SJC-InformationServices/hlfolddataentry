
var layoutAry = [];
var layout = myRecord['elementlayout'];
var measure = myRecord['measure'];
try{
switch(layout){
    case '1Box':
    case '1BoxLb':
    case '1 box dollar US':
    case '1 box dollar LB':
    case '1 box cent US':
    case '1 box cent LB':
    case 'FC 1 box dollar US':
    case 'FC 1 box dollar LB':
    case '1 box x/x US':
    layoutAry.push('1 box');
    break;
    case '2Box':
    case '2BoxLb':
    case '2 box dollar US':
    case '2 box dollar LB':
    case '2 box cent US':
    case '2 box cent LB':
    case '2 box dollar2 us':

    layoutAry.push('2 box');
    break;
    case '4Box':
    case '4BoxLb':
    case '4 box dollar US':
    case '4 box dollar LB':
    layoutAry.push('4 box');
    break;
    case 'FrontCover':
    case 'FrontCoverLB':
    layoutAry.push('frontcover');
    break;
    default:
    layoutAry.push("(" + layout + ")");
    break;
}
var orgPrice = myRecord['price'];
var orgPriceLb = myRecord['pricelb'];
var price = orgPrice;
var enddigit = "US";

if(orgPriceLb != "00¢" && !/\d+g|\d+ g/.test(measure)){
    price = orgPriceLb;
    enddigit = "LB"
}
if(myRecord['uos'] != "" && myRecord['uos'].indexOf("/")){
    layoutAry.push("x/x");
}
var cents = price.indexOf("¢") >0 ?  "cent" : "dollar" ;
layoutAry.push(cents);

var orgPrice = price.replace(/[^0-9\.]+/g, '');
var decimals = orgPrice.indexOf(".");

if((price.indexOf("¢") > 0 || orgPrice < 1) && orgPrice > 0){
    //layoutAry.push(orgPrice.length);
}
else if(decimals > 0){
    var split = orgPrice.split(".");
    layoutAry.push(split[0].length);
}
else{    
    layoutAry.push(orgPrice.length);
}
layoutAry.push(enddigit);
if(myRecord['pagelayout'] == "frontcover" && myRecord['mediatemplate'] == "Highland"){
layoutAry.push("frontcover");
}
var obj = layoutAry.join(" ").replace("  "," ");
}catch(e){
    var obj = "Script Error:"+ e.message;
}

obj;