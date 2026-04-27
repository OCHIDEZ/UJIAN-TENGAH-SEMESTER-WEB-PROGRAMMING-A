<?php
require 'koneksi.php'; // Sesuaikan dengan nama file koneksi kamu

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // 1. CARI NAMA FOTO DI DATABASE DULU
    $query = $conn->prepare("SELECT foto FROM penulis WHERE id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $fotoLama = $row['foto'];
        
        // 2. HAPUS FILE FISIKNYA DARI FOLDER (Jika filenya ada)
        $pathFoto = 'uploads_penulis/' . $fotoLama;
        if (!empty($fotoLama) && file_exists($pathFoto)) {
            unlink($pathFoto); // Ini fungsi ajaib untuk hapus file di folder
        }
    }

    // 3. BARU HAPUS DATA DARI DATABASE
    $stmt = $conn->prepare("DELETE FROM penulis WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo 'sukses';
    } else {
        echo 'gagal: ' . $conn->error;
    }
}
?>