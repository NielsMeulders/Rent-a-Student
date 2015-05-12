<?php
require 'dbconfig.php';
function checkuser($fuid,$ffname,$femail){
    	$check = mysql_query("select * from bezoeker where fbid='$fuid'");
	$check = mysql_num_rows($check);
	if (empty($check)) { // if new user . Insert a new record
	$query = "INSERT INTO bezoeker (name,email,fbid) VALUES ('$ffname','$femail','$fuid')";
	mysql_query($query);
	} else {   // If Returned user . update the user record		
	$query = "UPDATE bezoeker SET name='$ffname', email='$femail' where fbid='$fuid'";
	mysql_query($query);
	}
}?>
