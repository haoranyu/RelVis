<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title>RelVis</title>
	<link rel="stylesheet" href="css/main.css" type="text/css">
	<link href="css/nouislider.css" rel="stylesheet">
	<script src="js/jquery-1.9.0.js"></script>
	<script src="js/jquery-ui-1.10.0.custom.js"></script>
	<script src="js/jquery.nouislider.js"></script>
	<script src="js/jquery.slabtext.min.js"></script>
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	</head>
<body>
<div id="left">
	<div id="system">
	</div>
	<div id="timeBar">
		<canvas id="breakline" ></canvas>
		<div id="noUiSlider" class="noUiSlider" ></div>
		<div id="sc" style="width:100%">
			 <div id="Block">| | |</div>
		</div>
		<input id="TimeLeft" type="hidden" value=""/>
		<input id="TimeRight" type="hidden" value=""/>
		<input id="TimeRight2" type="hidden" value=""/>
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
//Config
var yCoor = coorArray.line;
var maxCoor = infoArray.user[0].sent.length;//The number of dots on the axias;
var maxHeight = Math.max.apply( Math,yCoor)*1.15;//the max numer of mail per week(times 1.1)
var stepLength = 1;//Data by day
var yearName = coorArray.year;
</script>
<script type="text/javascript" src="js/frame.js"></script>
</body>
</html>