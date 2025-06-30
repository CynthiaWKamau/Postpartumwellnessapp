<?php
require 'db_connection.php';
echo "Connection successful!";
if (isset($conn)) {
    echo "Connected!";
} else {
    echo "Failed!";
}
?>
