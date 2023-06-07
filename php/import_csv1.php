<?php
// Konfigurasi database
include "../db_conn.php";

// Fungsi untuk memvalidasi dan memindahkan file yang diunggah
function moveUploadedFile($file)
{
    $targetDirectory = "uploads/"; // Direktori untuk menyimpan file yang diunggah
    $targetFile = $targetDirectory . basename($file["name"]);
    $uploadOk = true;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Periksa apakah file yang diunggah adalah file CSV
    if ($fileType != "csv") {
        echo "Hanya file CSV yang diperbolehkan.";
        $uploadOk = false;
    }

    // Periksa apakah file sudah ada di server
    if (file_exists($targetFile)) {
        echo "File sudah ada.";
        $uploadOk = false;
    }

    // Batasan ukuran file (misalnya, 2MB)
    if ($file["size"] > 2000000) {
        echo "Ukuran file terlalu besar.";
        $uploadOk = false;
    }

    // Jika tidak ada masalah dengan file, pindahkan ke direktori tujuan
    if ($uploadOk) {
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            return $targetFile;
        } else {
            echo "Gagal mengunggah file.";
        }
    }

    return null;
}

// Periksa apakah file telah diunggah melalui formulir
if (isset($_FILES["csvFile"])) {
    $uploadedFile = moveUploadedFile($_FILES["csvFile"]);

    if ($uploadedFile) {
        // Baca file CSV
        $csvData = file_get_contents($uploadedFile);

        // Konversi data CSV menjadi array
        $lines = explode("\n", $csvData);
        $data = array();
        foreach ($lines as $line) {
            $data[] = str_getcsv($line);
        }

        // Impor data ke tabel users
        foreach ($data as $row) {
            $username = $row[0];
            $password = md5($row[1]);
            $name = $row[2];

            // Query untuk memasukkan data ke tabel users
            $query = "INSERT INTO users (role, username, password, name) 
                      VALUES ('user', '$username', '$password', '$name')";

            // Jalankan query
            mysqli_query($conn, $query);
        }

        // Hapus file yang diunggah setelah selesai diimpor
        unlink($uploadedFile);

        echo "<script>
        alert('Import CSV Berhasil');
        document.location.href = '../home.php';
        </script>";
    }
}
