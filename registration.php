<?php
// Proses pendaftaran pengguna
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Koneksi ke database
    $host = "localhost"; // Ganti dengan host Anda
    $username = "root"; // Ganti dengan username database Anda
    $password = ""; // Ganti dengan password database Anda
    $database = "hairstudio2"; // Ganti dengan nama database Anda
    
    $conn = mysqli_connect($host, $username, $password, $database);
    
    // Cek koneksi
    if (!$conn) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }
    
    // Ambil data dari form registrasi
    $username = $_POST['username'];
    $email = $_POST['email']; // Alamat email pengguna
    $password = $_POST['password'];
    $level = 'customer';
    
    // Query untuk memasukkan pengguna baru ke dalam database
    $query = "INSERT INTO user (username, email, password, level) VALUES ('$username', '$email', '$password', '$level')";
    
    if (mysqli_query($conn, $query)) {
        echo '<script>alert("Registrasi berhasil. Silakan login.")</script>';
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
    
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: linear-gradient(to left, #fadadd, #ffff);
            background-size: cover;
            background-repeat: no-repeat;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            border-radius: 15px 15px 0 0;
            background-color: #ff69b4; /* Mengubah warna latar belakang card header */
            color: white; /* Mengubah warna teks pada card header */
        }

        .btn-primary {
            background-color: #ff69b4;
            border: none;
            border-radius: 10px;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #d34e92;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-white">
                    <h3 class="card-title">Registration Form</h3>
                </div>
                <div class="card-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter your username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <p class="mb-0">Already have an account? <a href="login.php">Login here</a>.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
