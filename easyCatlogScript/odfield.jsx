
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
}
var obj = layoutAry.join(" ").replace("  "," ");
}catch(e){
    var obj = "Script Error:"+ e.message;
}

obj;