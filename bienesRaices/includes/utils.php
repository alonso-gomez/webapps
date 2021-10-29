<?php

function printMsg($msg, $type) {
	echo "<div class=\"$type\">";
	if(is_array($msg)) {
		// el mensaje ES array
		echo "<ul>";
		foreach($msg as $caca) {
			echo "<li>$caca</li>";
		}
		echo "</ul>";
	}
	else {
		// el mensaje NO ES array
		echo $msg;
	}
	echo "</div>";
}

// Cierre de sesión
if(isset($_GET['logout']) && $_GET['logout'] == "true") {
	session_destroy();
	header("Location: user-login.php?loggedOut=true");
}

?>