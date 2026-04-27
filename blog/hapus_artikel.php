<?php
require 'koneksi.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // 1. CARI NAMA GAMBAR DI DATABASE DULU
    $query = $conn->prepare("SELECT gambar FROM artikel WHERE id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $gambarLama = $row['gambar'];
        
        // 2. HAPUS FILE FISIKNYA DARI FOLDER
        $pathGambar = 'uploads_artikel/' . $gambarLama;
        if (!empty($gambarLama) && file_exists($pathGambar)) {
            unlink($pathGambar); 
        }
    }

    // 3. BARU HAPUS DATA DARI DATABASE
    $stmt = $conn->prepare("DELETE FROM artikel WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo 'sukses';
    } else {
        echo 'gagal: ' . $conn->error;
    }
}
?>