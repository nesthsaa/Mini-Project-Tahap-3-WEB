<?php
session_start();

// Include file konfigurasi database
include 'config.php';

// Periksa apakah pengguna sudah login sebagai admin
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["level"] !== 'customer') {
    header("location: login.php");
    exit;
}

// Proses form appointment jika data sudah dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['appointments'])) {
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



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gloss & Glam Hair Studio</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: linear-gradient(to left, #fadadd, #ffff);
            margin: 0;
            padding: 0;
        }

        .navbar {
            text-align: left;
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

    /* CSS untuk bagian home */
    .home {
            background-image: url('https://img.freepik.com/premium-photo/photo-beauty-natural-woman-studio-beauty-spa-salon_198067-9187.jpg?w=900'); /* Ganti URL dengan URL gambar latar belakang Anda */
            background-size: cover;
            background-position: center;
            color: #fff; /* Warna teks putih */
            text-align: left;
            padding: 100px 0; /* Padding atas dan bawah sebesar 100px, padding samping 0 */
            height: 100vh; /* Pastikan tinggi mencakup seluruh viewport */
            position: relative; /* Atur posisi relatif untuk div home */
            
        }

        .home-overlay {
            position: absolute; /* Atur posisi absolut untuk overlay */
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.2); /* Warna background semi-transparan */
        }

        .home-content span {
            font-size: 24px; /* Ubah ukuran font */
            font-weight: bold; /* Beri ketebalan font */
            color: #f6e7ea;
        }

        .home-content {
            position: relative; /* Atur posisi relatif untuk konten */
            z-index: 1; /* Tetapkan z-index agar konten tampil di atas overlay */
            margin-left: 20px;
        }

        .home h3 {
            font-size: 80px; /* Ukuran font untuk judul */
            margin-top: 20px; /* Jarak atas dari judul */
            color: #ffff;
        }

 
        .section {
            margin-bottom: 20px;
        }

                #appointments {
            position: relative; /* Atur posisi relatif pada elemen yang memiliki gambar latar belakang */
            background-image: url('https://img.freepik.com/premium-photo/modern-stomatology-cabinet_81048-14357.jpg?w=900');
            background-size: cover;
            background-position: center;
            text-align: center;
            padding: 100px 0; /* Padding atas dan bawah sebesar 100px, padding samping 0 */
            height: 100vh; /* Pastikan tinggi mencakup seluruh viewport */
            position: relative; /* Atur posisi relatif untuk div home */
               
        }
        #appointments-overlay {
            position: absolute; /* Atur posisi absolut untuk overlay */
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9); /* Warna background semi-transparan */
        }
     
        #appointments form {
            max-width: 400px; /* Atur lebar maksimum untuk kotak formulir */
            margin: 0 auto; /* Pusatkan kotak formulir secara horizontal */
            padding: 20px; /* Tambahkan padding agar isi formulir terlihat lebih baik */
        }


        .form-group {
            margin-bottom: 20px; /* Tingkatkan jarak antara grup formulir */
        }

        .form-box {
            padding: 10px;
            border-radius: 8px;
            /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); */
        } 

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .inputBox input,
        .inputBox select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
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
        

            /* CSS untuk bagian treatment */
        #treatment {
            margin-top: 50px; /* Tambahkan jarak atas sebesar 50px */
            text-align: center; /* Posisikan teks ke tengah */
        }

        #treatment h2 {
            display: inline-block; /* Membuat judul berada dalam inline block */
            border-bottom: 5px solid #ff1493; /* Tambahkan garis bawah */
            padding-bottom: 2px; /* Padding bawah untuk menjaga jarak antara teks dan garis bawah */
        }

        
        .card {
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            margin-bottom: 20px;
            padding: 20px;
            background-color:#f6e7ea;
            overflow: hidden;
            height: 100%; /* Buat ukuran kartu menjadi 100% tinggi */
            margin: 10px;
        }

        .card img {
            width: 100%;
            height: 300px; /* Tentukan tinggi gambar (Anda bisa menyesuaikan nilai ini) */
            border-radius: 15px 15px 0 0;
            object-fit: cover; /* Atur gambar agar tetap berada di dalam kotak dengan rasio aspek yang sama */
        }
        .row {
            margin-bottom: 20px; /* Tambahkan margin bawah 20px di setiap baris */
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
    <nav class="navbar navbar-expand-lg navbar-light"  style="background-color: #CC7A8B;"> <!-- Ganti navbar-dark dengan navbar-light -->
        <div class="container">
            <a class="navbar-brand" href="#">Gloss & Glam</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                    <a class="nav-link" href="#home">Home</a>
                </li>
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

<!-- home -->

<section class="home" id="home" style="font-family:Playfair Display;">
    <div class="home-overlay"></div> <!-- Overlay semi-transparan -->
    <div class="home-content">
        <span>W E L C O M E</span>
        <h3>We make <br> your hair beautiful <br> & unique</h3>
    </div>
</section>

<!-- home -->

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




    <div class="section" id="appointments" style="height: 100vh;">
    <div class="overlay"></div>
    <h2>Make Appointment</h2>
        <button type="button" class="btn btn-primary" id="showTreatmentBtn">Lihat Rekomendasi Treatment</button>
        <div id="rekomendasi" style="max-width: 400px; margin: auto;">
            <?php
            // Query untuk mengambil data umpan balik dari database dengan rating di atas 4
            $query_feedback = "SELECT treatment, AVG(rating) AS avg_rating FROM feedback WHERE rating > 4 GROUP BY treatment";
            $result_feedback = mysqli_query($conn, $query_feedback);
            if (mysqli_num_rows($result_feedback) > 0) {
                echo '<div class="alert alert-info treatment-info" role="alert" style="display: none; background-color: #f8d7da; border-color: #f5c6cb; color: #721c24; border-radius: 10px;"">';
                while ($row_feedback = mysqli_fetch_assoc($result_feedback)) {
                    $treatment = $row_feedback['treatment'];
                    $avg_rating = $row_feedback['avg_rating'];
            ?>
                    <p><strong>Treatment:</strong> <?php echo $treatment; ?></p>
                    <p><strong>Rating:</strong> <?php echo number_format($avg_rating, 1); ?></p>
                    <hr>
            <?php
                }
                echo '</div>';
            } else {
                echo "<div class='alert alert-warning' role='alert'>No feedbacks found</div>";
            }
            ?>
        </div>

        <script>
            document.getElementById("showTreatmentBtn").addEventListener("click", function() {
                var treatmentAlert = document.querySelector(".treatment-info");
                if (treatmentAlert.style.display === "none") {
                    treatmentAlert.style.display = "block";
                } else {
                    treatmentAlert.style.display = "none";
                }
            });
        </script>


    <div class="form-box">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="appointments" value="1">

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
                        <label for="service">Treatment:</label>
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
</div>


    <div class="section" id="feedback" style="height: 100vh;">
        <h2>Give Feedback</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="feedback" value="1">
            <div class="form-group">
            <label for="select-treatment">Select Treatment:</label>
            <select id="select-treatment" name="treatment" required class="form-control">
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
