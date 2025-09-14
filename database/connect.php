<?php
$conn = new mysqli("localhost", "root", "", "absensi_osis");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>