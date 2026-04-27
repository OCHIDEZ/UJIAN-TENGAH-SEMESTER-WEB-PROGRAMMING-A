<?php
require 'koneksi.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $query = $conn->prepare("SELECT gambar FROM artikel WHERE id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $gambarLama = $row['gambar'];
        
        $pathGambar = 'uploads_artikel/' . $gambarLama;
        if (!empty($gambarLama) && file_exists($pathGambar)) {
            unlink($pathGambar); 
        }
    }

    $stmt = $conn->prepare("DELETE FROM artikel WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo 'sukses';
    } else {
        echo 'gagal: ' . $conn->error;
    }
}
?>