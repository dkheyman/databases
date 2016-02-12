<?php
// checks whether username session variable is set. echoes it if yes

if ($_SESSION["username"] != null) {
	echo $_SESSION["username"];
}

?>