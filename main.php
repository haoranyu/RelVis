<?php
//header("Content-type: text/plain");
require_once 'MailUtil.php';

ini_set('max_execution_time', 3600);
ini_set("session.cookie_lifetime",3600); 

if(isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['year'])&&$_POST['username']!=''&&$_POST['password']!=''){
	$username = $_POST['username'];
	$password = $_POST['password'];
	$start_year = $_POST['year'];
}
else{
	header('Location: index.php');
	exit;
}
$current_year = intval(date('Y',time()))+1;
if(intval($start_year)<2005||intval($start_year)>($current_year-1)){
	header('Location: index.php');
	exit;
}

function getAlllZero($day_length){
	$str = '0';
	for($i=1;$i<$day_length;$i++){
		$str .=",0";
	}
	return $str;
}


$day_length = ($current_year-$start_year) * 365 + 1;

$arr_rec = MailUtil::getReceivedMails($username, $password, $start_year);
$arr_sen = MailUtil::getSentMails($username, $password, $start_year);

//Date array

$date = array();
$receive_date = MailUtil::getDateMap($arr_rec, 'from');
$sent_date = MailUtil::getDateMap($arr_sen,'to');
for($i=1;$i<$day_length;$i++){
	if(isset($receive_date[$i])){
		$receive = $receive_date[$i];
	}
	else{
		$receive = 0;
	}
	if(isset($sent_date[$i])){
		$sent = $sent_date[$i];
	}
	else{
		$sent = 0;
	}
	$date[$i] = $receive + $sent;
}
$string = '';
foreach($date as $co){
	if($string==''){
		$string .= $co;
	}
	else{
		$string = $string.",".$co;
	}
}
$year_string = '';
for($i=$start_year;$i<=$current_year;$i++){
	if($year_string==''){
		$year_string .= $i;
	}
	else{
		$year_string = $year_string.",".$i;
	}
}

$coorArray = '{"year":['.$year_string.'],"line":['.$string.']}';
	

//Content array
$receive_con = MailUtil::getContactMap($arr_rec, 'from');
foreach($receive_con as &$con){
	$temp_str = '';
	$sent_date = MailUtil::getDateMap($arr_sen,'to');
	for($i=1;$i<$day_length;$i++){
		if(!isset($con[$i])){
			if($i==1){
				$temp_str.=$temp_str.'0';
			}
			else{
				$temp_str=$temp_str.',0';
			}
		}
		else{
			if($i==1){
				$temp_str=$temp_str.$con[$i];
			}
			else{
				$temp_str=$temp_str.','.$con[$i];
			}
		}
	}
	$con = $temp_str;
}
//print_r($receive_con);
$sent_con = MailUtil::getContactMap($arr_rec, 'to');
foreach($sent_con as &$con){
	$temp_str = '';
	$sent_date = MailUtil::getDateMap($arr_sen,'to');
	for($i=1;$i<$day_length;$i++){
		if(!isset($con[$i])){
			if($i==1){
				$temp_str.=$temp_str.'0';
			}
			else{
				$temp_str=$temp_str.',0';
			}
		}
		else{
			if($i==1){
				$temp_str=$temp_str.$con[$i];
			}
			else{
				$temp_str=$temp_str.','.$con[$i];
			}
		}
	}
	$con = $temp_str;
}
$contact_re = array_keys($receive_con);
$contact_se = array_keys($sent_con);
$contact = array_unique(array_merge($contact_re,$contact_se));
$infoArray = '{"user":[';
foreach($contact as &$con){
	if(isset($sent_con[$con])){
		$sent = $sent_con[$con];
	}
	else{
		$sent = getAlllZero($day_length);
	}
	if(isset($receive_con[$con])){
		$receive = $receive_con[$con];
	}
	else{
		$receive = getAlllZero($day_length);
	}
	if($infoArray!='{"user":['){
		$infoArray .= ",";
	}
	$infoArray = $infoArray.'{"email":"'.$con.'","sent":['.$sent.'],"receive":['.$receive.']}';
}
$infoArray .= ']}';
include("template.php")
?>
