<?php
session_start();

// Periksa apakah pengguna sudah login sebagai admin
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); // Arahkan ke halaman login jika pengguna belum login sebagai admin
    exit;
}

// Koneksi ke database
$host = "localhost"; // Ganti dengan host Anda
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$database = "hairstudio2"; // Ganti dengan nama database Anda

$conn = mysqli_connect($host, $username, $password, $database);

// Memeriksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Memeriksa apakah parameter id janji temu telah diterima dari URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk memperbarui status janji temu menjadi disetujui
    $query = "UPDATE appointments SET status='approved' WHERE id=$id";

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        // Redirect kembali ke halaman appointments setelah berhasil menyetujui janji temu
        header("Location: appointments.php");
        exit;
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}

// Tutup koneksi ke database
mysqli_close($conn);
?>
