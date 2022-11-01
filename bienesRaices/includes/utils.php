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

?>