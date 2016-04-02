<?php

$data = $_GET['data'];
$order = $_GET['order'];
switch ($data) {
	case 'status_order':
	$data = 'statut';
	break;
	case 'date_order':
	$data = 'event_time';
	break;
	case 'author_order':
	$data = 'lead_user';
	break;
	case 'location_order':
	$data = 'lonStart AND latStart';
	break;
}
switch ($order) {
	case 'up':
	$order = "ASC";
	break;
	case 'down':
	$order = "DESC"; 
	break;
}
$user->get_event_by_order($data, $order, $bdd);
$events = $user->myEvents;
$json = array();
foreach ($events as $key => $value) {
	array_push($json, json_encode($value)); 
}  
echo(json_encode($json));

?>