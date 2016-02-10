<?php
    require 'connect_db.php';

    function run_query($query) {
        $con = connect_to_db("bookly");
        $result = mysqli_query($con, $query);

        if ($result) {
            mysqli_close($con);
            $rows = mysqli_fetch_all($result);
            return $rows;
        } else {
            $error = mysqli_error($con);
            mysqli_close($con);
            return $error;
        }
    }
