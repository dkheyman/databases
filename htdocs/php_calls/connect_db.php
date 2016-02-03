<?php
    function connect_to_db($database) {
        $con = mysqli_connect('localhost', 'root', 'root', $database);
        if (!$con) {
            echo mysqli_error($con);
            die('Could not connect to database: ' . mysqli_error($con));
        }
        mysqli_select_db($con, "$database");
        return $con;
    }
?>
