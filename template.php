<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title>RelVis</title>
	<link rel="stylesheet" href="css/jquery.slider.min.css" type="text/css">
	<link rel="stylesheet" href="css/main.css" type="text/css">
	<script type="text/javascript" src="js/jquery-1.7.1.js"></script>
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	</head>
<body>
<div id="left">
	<div id="system">
	<input id="TimeLeft" type="hidden" value=""/>
	<input id="TimeRight" type="hidden" value=""/></br>
	</div>
	<div id="timeBar">
		<canvas id="breakline" ></canvas>
		<div style="overflow:hidden" id="tl">
		<input id="Timeline" type="slider" value="0;365" />
		</div>
		<div id="sc" style="width:100%">
			 <div id="Block">| | |</div>
		</div>
	</div>
</div>
<div id="right">
	<div class="sidehead"><span>Contacts</span></div>
	<div class="selectall"><span check="true">&nbsp;&nbsp;&nbsp;&nbsp;All</span></div>
	<div class="invisible-clear"></div>
	<div class="list">
		<ul></ul>
	</div>
</div>

<script type="text/javascript" charset="utf-8">

//Data
var infoArray = jQuery.parseJSON(
	'<?php echo $infoArray;?>'
);
var coorArray = jQuery.parseJSON(
	'<?php echo $coorArray;?>'
);
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
//Config
var yCoor = coorArray.line;
var maxCoor = infoArray.user[0].sent.length;//The number of dots on the axias;
var maxHeight = Math.max.apply( Math,yCoor)*1.15;//the max numer of mail per week(times 1.1)
var stepLength = 1;//Data by day
var yearName = coorArray.year;
</script>
<script type="text/javascript" src="js/jquery-1.7.1.js"></script>
<script type="text/javascript" src="js/jquery.slider.min.js"></script>
<script type="text/javascript" src="js/frame.js"></script>
</body>
</html>