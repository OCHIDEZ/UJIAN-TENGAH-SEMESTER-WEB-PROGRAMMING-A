<?php
require 'koneksi.php'; 

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $query = $conn->prepare("SELECT foto FROM penulis WHERE id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $fotoLama = $row['foto'];
        
        $pathFoto = 'uploads_penulis/' . $fotoLama;
        if (!empty($fotoLama) && file_exists($pathFoto)) {
            unlink($pathFoto); 
        }
    }

    $stmt = $conn->prepare("DELETE FROM penulis WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo 'sukses';
    } else {
        echo 'gagal: ' . $conn->error;
    }
}
?>