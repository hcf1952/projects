<?php 
	include("connection.php");
		
	$target = $_POST['toid_p'];
	$self = $_POST['selfid_p'];
	$sql="SELECT message,from_username,sendtime FROM message WHERE (from_userID = $target AND to_userID = $self) OR (from_userID = $self AND to_userID = $target) ORDER BY sendtime ASC;";
	$result=mysqli_query($con,$sql);

	$list = array();
	while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
	    $list[] = array (
	        'messagetx' => $row['message'],
	        'from_userID' => $row['from_username'],
	        'sendtime' => $row['sendtime'],
	    );
	}

	echo json_encode($list);

