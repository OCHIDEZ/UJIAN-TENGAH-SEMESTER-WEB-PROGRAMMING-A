<?php
require 'koneksi.php';
$id = $_GET['id'];
$res = $conn->query("SELECT id, nama_depan, nama_belakang, user_name FROM penulis WHERE id = $id");
echo json_encode($res->fetch_assoc());
?>