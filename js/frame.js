//conter for a loop
var i ;
//Sizing the frame
function sizing(){
$("#left").width($(window).width()-212).height($(window).height());
$("#system").width($("#left").width()).height($(window).height()-38);
$("#right").height($(window).height());
$(".list").height($("#right").height()-26);
$("#breakline").width($("#timeBar").width());
}
$(window).resize(function(){
	sizing();
	getSlideBar();
});
//Setup Contact
for(i=0;i<infoArray.user.length;i++){
	$(".list ul").prepend('<li><a class="checkbox" check="true" uid="'+(i+1)+'" send="" receive=""></a>'+infoArray.user[i].email+'</li>');
}
//List and checkbox
$(".list li").live("mouseover",function(){
	$(this).css('background',"#FFFFCD");
});
$(".list li").live("mouseout",function(){
	$(this).css('background',"#FFF");
});
$(".checkbox").live("click",function(){
	if($(this).attr("check")==="false"){
		$(this).attr("check","true").css("background-position","0 -30px");
	}
	else{
		$(this).attr("check","false").css("background-position","0 0");
	}
});
$(".selectall span").live("click",function(){
	if($(this).attr("check")==="false"){
		$(this).attr("check","true").css("background-position","bottom");
		$(".checkbox").click();
	}
	else{
		$(this).attr("check","false").css("background-position","top");
		$(".checkbox").click();
	}
});

//Time Bar Part
jQuery("#Timeline").slider({ 
	from: 0, 
	to: maxCoor,
	step: stepLength, //The step of each slide action
	scale: yearName, 
	dimension: ""
});
$(document).mousemove(getSlideBar);
function getSlideBar(){
	var width = $("#tl i.v").width()-2+"px";
	var left = $("#tl .cuslider-pointer-from").css('left');
	var value = $("#Timeline").val().split(";");
	$("#Block").css('left',left).css('width',width).css('width',width);
	$("#TimeLeft").val(value[0]);
	$("#TimeRight").val(value[1]);
}
var pins = false;
//var block = false;
var offsetX=0;
$("#Block").mouseover(function(e){
	$(this).css('cursor','move');
 });
 /*
$("#Block").mousedown(function(e){
	block=true;
	offsetX = e.pageX;
	$(this).css('cursor','move');
 });
 */
$("#tl .cuslider-pointer").mousedown(function(){
	pins=true;
});
$("#tl .cuslider-pointer").mouseup(function(){
	pins=true;
});
function countUsers(){
	var i;
	for(i=0;i<infoArray.user.length;i++){
		$("[uid='"+(i+1)+"']").attr("send",sumArray(infoArray.user[i].sent,$("#TimeLeft").val(),$("#TimeRight").val())).attr("receive",sumArray(infoArray.user[i].receive,$("#TimeLeft").val(),$("#TimeRight").val()));;
	}
}
$("#Block").mouseup(function(){
	block=false;
});
$(document).mousemove(function(e){
	if(pins==true){
		getSlideBar;
	}
	/*else if(block ==true){
		var x = e.pageX-offsetX;
		var barMax = parseFloat($("#sc").css('width'));
		var blockLeft = parseFloat($("#Block").css('left'))/100*barMax;
		var newLeft = blockLeft+x;
		var max = barMax - parseFloat($("#Block").width());
		newLeft = newLeft<0?0:newLeft;
		newLeft = newLeft>max?max:newLeft;
		var newRight = newLeft+parseFloat($("i.v").css('width'));
		$("#Block").css('left',newLeft+"px");
		$("i.v").css('left',newLeft+"px");
	}*/
});
$(document).mouseup(function(){
	block=false;
	pins=false;
	countUsers();
});
$(document).ready(function(){
	sizing();
	getSlideBar();
	countUsers();
});
//BreakLine Drawing
$("#breakline").attr("height",maxHeight).attr("width",maxCoor);
var bl = document.getElementById("breakline");
var cxi = bl.getContext("2d");
cxi.strokeStyle = "#000";
cxi.fillStyle = "#eee";
cxi.beginPath();
cxi.moveTo(0,maxHeight);
for(i=0;i<yCoor.length;i++){
	cxi.lineTo(i,maxHeight-yCoor[i]);
}
cxi.lineTo(maxCoor,maxHeight);
cxi.lineTo(0,maxHeight);
cxi.stroke();
cxi.fill();