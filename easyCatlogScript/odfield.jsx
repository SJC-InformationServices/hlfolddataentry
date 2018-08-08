
var layoutAry = [];
var layout = myRecord['elementlayout'];
try{
switch(layout){
    case '1Box':
    case '1BoxLb':
    layoutAry.push('1 box');
    break;
    case '2Box':
    case '2BoxLb':
    layoutAry.push('2 box');
    break;
    case '4Box':
    case '4BoxLb':
    layoutAry.push('4 box');
    break;
    case 'FrontCover':
    case 'FrontCoverLB':
    layoutAry.push('frontcover');
    break;
    default:
    layoutAry.push(layout);
    break;
}
var orgPrice = myRecord['price'];
var orgPriceLb = myRecord['pricelb'];
var price = orgPrice;
var enddigt = "US";

if(orgPriceLb != "00¢"){
    price = orgPriceLb;
    enddigt = "LB"
}
if(myRecord['uos'] != "" && myRecord['uos'].indexOf("/")){
    layoutAry.push("x/x");
}
var cents = price.indexOf("¢") >0 ? "dollar" : "cent";
layoutAry.push(cents);

var decimals = price.replace(/[^0-9\.]+/g, '') % 1;

if(decimals != 0){
    var split = orgPrice.split(".");
    layoutAry.push(split[0].length);
}
else{    
    layoutAry.push(orgPrice.length);
}


var obj = layoutAry.join(" ").replace("  "," ");
}catch(e){
    var obj = "Script Error:"+ e.message;
}

obj;