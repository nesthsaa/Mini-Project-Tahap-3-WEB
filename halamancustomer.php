<?php
session_start();

// Include file konfigurasi database
include 'process.php';

// Periksa apakah pengguna sudah login sebagai admin
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["level"] !== 'customer') {
    header("location: login.php");
    exit;
}

// Proses form appointment jika data sudah dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap data dari form
    $name = $_POST["name"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $service = $_POST["service"];

    // Periksa apakah tanggal dan waktu yang diinput tersedia
    $sql_check_availability = "SELECT * FROM appointments WHERE date = '$date' AND time = '$time'";
    $result = mysqli_query($conn, $sql_check_availability);

    if (mysqli_num_rows($result) > 0) {
        // Jika slot sudah terisi, tampilkan pesan
        echo "<script>alert('Appointment slot not available. Please choose another date and time.');</script>";
    } else {
        // Jika slot masih tersedia, lakukan proses penyimpanan data appointment
        $sql_insert_appointment = "INSERT INTO appointments (name, date, time, service) VALUES ('$name', '$date', '$time', '$service')";

        if (mysqli_query($conn, $sql_insert_appointment)) {
            echo "<script>alert('Appointment successfully.');</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f6e7ea;  
            margin: 0;
            padding: 0;
        }
        .container {
            margin: 20px auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 15px; /* Tambahkan radius sudut pada kontainer */
            background-color: #ffff; /* Warna tombol pink */
        }
        .section {
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px; /* Tingkatkan jarak antara grup formulir */
        }
        .btn {
            padding: 10px 20px; /* Ubah ukuran tombol */
            border: none;
            border-radius: 25px; /* Ubah radius sudut tombol */
            background-color: #ff1493; /* Warna tombol pink */
            color: #fff;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease; /* Efek transisi saat hover */
        }
        .btn:hover {
            background-color: #ff1493; /* Warna tombol pink saat dihover */
        }
        .navbar {
            border-radius: 0 0 15px 15px; /* Tambahkan radius sudut pada bagian bawah navbar */
        }
        .navbar-brand {
            font-family: 'Lucida Handwriting', cursive;
            font-weight: bold;
            padding-left: 20px;
            color: #ff1493; /* Warna teks navbar pink */
        }
        .navbar-nav .nav-link {
            color: #ff1493; /* Warna teks item navbar pink */
            padding: 0 15px;
        }
        .navbar-nav .nav-link:hover {
            color: #333; /* Warna teks item navbar pink saat dihover */
        }
        .navbar-brand .navbar-brand:hover {
            color: #333; /* Warna teks item navbar pink saat dihover */
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
            background-color: #ffffff;
            overflow: hidden;
        }

        .card img {
            width: 100%;
            height: auto;
            border-radius: 15px 15px 0 0;
        }

        .card-content {
            padding: 20px;
        }

        .card-title {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .card-description {
            margin-bottom: 20px;
        }

        @media (max-width: 576px) {
            .container {
                padding: 10px;
            }
        }
    </style>
</head>
<body>

<header>
    <nav class="navbar navbar-expand-lg navbar-light"  style="background-color: #f6e7ea;"> <!-- Ganti navbar-dark dengan navbar-light -->
        <div class="container">
            <a class="navbar-brand" href="#">Gloss & Glam</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#appointments">Appointment</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#treatment">Treatment</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#feedback">Feedback</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
            </div>
        </div>
    </nav>
</header>

<div class="container">
<div class="section" id="appointments" style="height: 70vh;">
        <h2>Make Appointment</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" required class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="date">Date:</label>
                        <input type="date" id="date" name="date" required class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="time">Time:</label>
                        <input type="time" id="time" name="time" required class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="service">Service:</label>
                        <select id="service" name="service" required class="form-control">
                            <option value="Haircut">Haircut</option>
                            <option value="Coloring">Coloring</option>
                            <option value="Perm">Perm</option>
                            <option value="Keratin Straightening">Keratin Straightening</option>
                            <option value="Creambath">Creambath</option>
                            <option value="Styling">Styling</option>
                            <option value="Hair Extensions">Hair Extensions</option>
                            <option value="Hair Spa">Hair Spa</option>
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn">Submit Appointment</button>
        </form>
    </div>

    <div class="section">
    <section id="treatment">
        <h2>Treatment</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <img src="https://i.pinimg.com/564x/cd/bb/58/cdbb589d4f5d7302fe5c1cd2b875296a.jpg" alt="Haircut">
                    <div class="card-content">
                        <h3 class="card-title">Haircut</h3>
                        <p class="card-description">A basic haircut service to trim your hair and give it a fresh look.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="https://i.pinimg.com/564x/fe/2f/71/fe2f717ae86899553488f752a7afce1a.jpg" alt="Coloring">
                    <div class="card-content">
                        <h3 class="card-title">Coloring</h3>
                        <p class="card-description">Professional hair coloring service using high-quality products for beautiful and long-lasting color.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="https://i.pinimg.com/564x/01/61/69/016169bb931e27144fdd646727f2a18f.jpg" alt="Perm">
                    <div class="card-content">
                        <h3 class="card-title">Perm</h3>
                        <p class="card-description">A process to achieve wavy or curly hair with a natural look.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <img src="https://i.pinimg.com/564x/0c/1b/2f/0c1b2f0923e321a28bb55e0e3d178d33.jpg" alt="Keratin Straightening">
                    <div class="card-content">
                        <h3 class="card-title">Keratin Straightening</h3>
                        <p class="card-description">Treatment aimed to straighten the hair, smooth hair texture, and reduce frizz and stiffness.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="https://i.pinimg.com/564x/6f/24/a4/6f24a4eecdb90b13da79638731863eca.jpg" alt="Creambath">
                    <div class="card-content">
                        <h3 class="card-title">Creambath</h3>
                        <p class="card-description">Hair treatment involving the use of hair cream or mask to provide extra moisture and nutrition to the hair.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="https://i.pinimg.com/736x/5e/bc/92/5ebc927bc6697e7f90b99987eaca20fe.jpg" alt="Styling">
                    <div class="card-content">
                        <h3 class="card-title">Styling</h3>
                        <p class="card-description">Styling service for special occasions or everyday use. We offer various styles ranging from formal hairstyles to casual looks.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <img src="https://i.pinimg.com/564x/bc/cd/2c/bccd2c79b582756932a3cd41e1013e39.jpg" alt="Hair Extensions">
                    <div class="card-content">
                        <h3 class="card-title">Hair Extensions</h3>
                        <p class="card-description">Service to add length, volume, or color to the hair using artificial or natural hair extensions.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="https://i.pinimg.com/736x/49/ce/db/49cedbe8de2f62a8a9621f1f093f7d02.jpg" alt="Hair Spa">
                    <div class="card-content">
                        <h3 class="card-title">Hair Spa</h3>
                        <p class="card-description">Treatment aimed to nourish and rejuvenate the hair and scalp, promoting healthy hair growth and relaxation.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section" id="feedback" style="height: 100vh;">
        <h2>Give Feedback</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
            <label for="treatment">Select Treatment:</label>
            <select id="treatment" name="treatment" required class="form-control">
                <option value="Haircut">Haircut</option>
                <option value="Coloring">Coloring</option>
                <option value="Perm">Perm</option>
                <option value="Keratin Straightening">Keratin Straightening</option>
                <option value="Creambath">Creambath</option>
                <option value="Styling">Styling</option>
                <option value="Hair Extensions">Hair Extensions</option>
                <option value="Hair Spa">Hair Spa</option>
            </select>
            </div>
            <div class="form-group">
                <label for="feedback">Your Feedback:</label>
                <textarea id="feedback" name="feedback" rows="4" required class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="rating">Rating (1-5):</label>
                <input type="number" id="rating" name="rating" min="1" max="5" required class="form-control">
            </div>
            <button type="submit" class="btn">Submit Feedback</button>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>
