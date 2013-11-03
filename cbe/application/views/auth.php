<?php
header('Access-Control-Expose-Headers: Access-Control-Allow-Origin"');

?>
<?php if($auth["logged_in"] == true){ ?>
	Username: <?php echo $username; ?> <br/>
	Password: <?php echo $password; ?>
<?php } 
else{
	echo json_encode($auth);
 } ?>