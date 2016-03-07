<?php

    function print_rows($results) {
        if (is_array($results) && isset($results)) {
            foreach($results as $row_num => $row_vals) {
                echo '<tr>';
                foreach($row_vals as $col_num => $col_val) {
                    echo '<td id=">' . $col_val . '</p>';
                }
            }
        }
    }
?>

