<?php
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $cek = $conn->prepare("SELECT id FROM artikel WHERE id_kategori = ?");
    $cek->bind_param("i", $id);
    $cek->execute();
    $cek->store_result();

    if ($cek->num_rows > 0) {
        echo "digunakan"; 
    } else {
        $stmt = $conn->prepare("DELETE FROM kategori_artikel WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) echo "sukses";
        else echo "gagal";
        
        $stmt->close();
    }
    $cek->close();
}
?>