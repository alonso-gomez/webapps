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

?>