<?php
    require 'connect_db.php';

    function run_query($query, $types, $args) {
        $con = connect_to_db("bookly");
        $query = mysqli_prepare($con, $query);
        if ($query) {
            if (count($args) > 0) {
                $result = call_user_func_array('mysqli_stmt_bind_param', array_merge(array($query, $types), refValues($args)));
            }
            mysqli_execute($query);
            $result = mysqli_stmt_get_result($query);
            if ($result) {
                $rows = mysqli_fetch_all($result);
                mysqli_close($con);
                return $rows;
            } else {
                $error = mysqli_error($con);
                mysqli_close($con);
                return $error;
            }
        }
        else {
            return "Failed to prepare query";
        }
    }

    function refValues($arr) { 
        $refs = array();
        foreach ($arr as $key => $value)
        {
            $refs[$key] = &$arr[$key]; 
        }
        return $refs; 
    }

    function execute_change($query, $types, $args) {
        $con = connect_to_db("bookly");
        $query = mysqli_prepare($con, $query);
        if ($query) {
            $result = call_user_func_array('mysqli_stmt_bind_param', array_merge(array($query, $types), refValues($args)));
            mysqli_execute($query);
            $result = mysqli_stmt_get_result($query);
            if (is_bool($result)) {
                mysqli_close($con);
                return $result;
            } else {
                $error = mysqli_error($con);
                mysqli_close($con);
                return $error;
            }
        } else {
            return "Failed to prepare query"; 
        }
    }
