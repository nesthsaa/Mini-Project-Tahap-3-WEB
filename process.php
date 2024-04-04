<?php


// Periksa apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php"); // Arahkan ke halaman login jika pengguna belum login
    exit;
}

$host = "localhost"; // Ganti dengan host Anda
$username = "root"; // Ganti dengan username database Anda  
$password = ""; // Ganti dengan password database Anda
$database = "hairstudio2"; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = mysqli_connect($host, $username, $password, $database);

// Memeriksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}


// Periksa apakah form feedback telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['feedback'])) {
    // Mengambil nilai yang dikirimkan melalui form feedback
    $treatment = $_POST['treatment'];
    $feedback = $_POST['feedback'];
    $rating = $_POST['rating'];

    // Query untuk memasukkan data ke dalam tabel feedback
    $query = "INSERT INTO feedback (treatment, feedback, rating) VALUES ('$treatment', '$feedback', '$rating')";

    if (mysqli_query($conn, $query)) {
        echo '<script>alert("Feedback berhasil disimpan. Terima kasih atas partisipasinya!")</script>';
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
?>
