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

function sumArray(arr,st,en){
	var i,max,sum=0;
	if(arr.length<en){
		max = arr.length;
	}
	else{
		max = en;
	}
	for(i=st;i<max;i++){
		sum+=arr[i];
	}
	return sum;
}

$(window).resize(function(){
	sizing();
});
$(document).ready(function(){
	sizing();
});

$(function(){
	var init = function(){
		if($('#disable').is(':checked')){
			$("#noUiSlider").noUiSlider('enable');
			$('#disable').attr('checked', false);
		}
		var stepSetting = false;
		$("#noUiSlider").empty().noUiSlider( 'init', {
			step: stepSetting,
			change:
				function(){
					var values = $(this).noUiSlider( 'value' );				
					$('#TimeLeft').val(values[0]);
					$('#TimeRight').val(values[1]);
					var myWidth = parseFloat($('.noUi-upperHandle').css("left")) - parseFloat($('.noUi-lowerHandle').css("left"))
					var myLeft = parseFloat($('.noUi-lowerHandle').css("left"));
					$("#Block").css("width",(myWidth-1)+"px").css("left",myLeft+"px");
					countUsers();
				},
			end:
				function(type){}

		}).find('.noUi-handle div').each(function(index){
			$('#TimeLeft').val($(this).parent().parent().noUiSlider( 'value' )[0]);
			$('#TimeRight').val($(this).parent().parent().noUiSlider( 'value' )[1]);
			var myWidth = parseFloat($('.noUi-upperHandle').css("left")) - parseFloat($('.noUi-lowerHandle').css("left"))
			var myLeft = parseFloat($('.noUi-lowerHandle').css("left"));
			$("#Block").css("width",(myWidth-1)+"px").css("left",myLeft+"px");
			countUsers();
		});
	};
	init.call();
	$('#disable').change(function(){
		if($(this).is(':checked')){
			$("#noUiSlider").noUiSlider('disable');
		} else {
			$("#noUiSlider").noUiSlider('enable');
		}
	});
});

var trigger = function(){
		$("#noUiSlider").noUiSlider('move',{
			handle: 0,
			to: $("#TimeLeft").val()
		})

		$("#noUiSlider").noUiSlider('move',{
			handle: 1,
			to: $("#TimeRight2").val()
		})
};

$("#Block").mousedown(function(e){
	$(this).css('cursor','move');
});
$("#Block").mouseover(function(e){
	$(this).css('cursor','move');
});
$("#Block").draggable({ 
	containment: "#sc",
	axis: "x" ,
	drag: function() {
		var newLeft = parseFloat($("#Block").css("left"))/parseFloat($("#sc").css("width"))*maxCoor;
		var newRight = (parseFloat($("#Block").css("left"))+parseFloat($("#Block").css("width")))/parseFloat($("#sc").css("width"))*maxCoor;
		$('#TimeLeft').val(newLeft);
		$('#TimeRight2').val(newRight);
	},
	stop: function() {
		trigger();
	}
});


//Setup Contact

for(i=0;i<infoArray.user.length;i++){
	$(".list ul").prepend('<li><a class="checkbox" check="true" uid="'+(i+1)+'" send="" receive=""></a>'+infoArray.user[i].email+'</li>');
}

//List and checkbox
$(".list li").mouseover(function(){
	$(this).css('background',"#FFFFCD");
});

$(".list li").mouseout(function(){
	$(this).css('background',"#FFF");
});

$(".checkbox").click(function(){
	if($(this).attr("check")==="false"){
		$(this).attr("check","true").css("background-position","0 -30px");
	}
	else{
		$(this).attr("check","false").css("background-position","0 0");
		$(".selectall span").attr("check","false").css("background-position","top");
	}
});

$(".selectall span").click(function(){
	if($(this).attr("check")==="false"){
		$(this).attr("check","true").css("background-position","bottom");
		$(".checkbox").attr("check","true").css("background-position","0 -30px");
	}
	else{
		$(this).attr("check","false").css("background-position","top");
		$(".checkbox").click();
	}
});

function countUsers(){
	var i;
	for(i=0;i<infoArray.user.length;i++){
		$("[uid='"+(i+1)+"']").attr("send",sumArray(infoArray.user[i].sent,$("#TimeLeft").val(),$("#TimeRight").val())).attr("receive",sumArray(infoArray.user[i].receive,$("#TimeLeft").val(),$("#TimeRight").val()));;
	}
}


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