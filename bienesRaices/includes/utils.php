<?php

function printMsg($msg,$type){
	echo "<div class=\"$type\">";
	if (is_array($msg)) {
		echo "<ul>";
		foreach($msg as $caca) {
			echo "<li>$caca</li>";
		}
		echo "</ul>";
	}
	else {
		echo $msg;
	}
	echo "</div>";
}

// Cierre de sesión
if(isset($_GET['logOff']) && $_GET['logOff'] == "true") {
	session_destroy();
	header("Location: login.php?loggedOff=true");
}

?>