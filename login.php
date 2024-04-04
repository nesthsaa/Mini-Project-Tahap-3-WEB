<?php
session_start();

// Jika pengguna sudah login, arahkan ke halaman sesuai perannya
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    if(isset($_SESSION["level"])) {
        if($_SESSION["level"] === 'admin'){
            header("location: index.php");
            exit;
        } elseif ($_SESSION["level"] === 'customer') {
            header("location: halamancustomer.php");
            exit;
        }
    }
}

// Periksa apakah pengguna telah mengirimkan formulir login
if($_SERVER["REQUEST_METHOD"] == "POST"){
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
    
    // Ambil data dari form login
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Query untuk mencari pengguna dengan username dan password yang cocok
    $query = "SELECT * FROM user WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);
    
    // Periksa apakah pengguna ditemukan
    if (mysqli_num_rows($result) == 1) {
        // Ambil informasi pengguna
        $user = mysqli_fetch_assoc($result);
        // Set session pengguna
        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $username;
        // Periksa apakah kolom 'level' ada dalam hasil query
        if(isset($user['level'])) {
            $_SESSION["level"] = $user['level'];
            // Redirect user ke halaman sesuai perannya
            if ($user['level'] == 'admin') {
                header("Location: index.php");
            } elseif ($user['level'] == 'customer') {
                header("Location: halamancustomer.php");
            }
        } else {
            // Jika kolom 'level' tidak ada, tampilkan pesan kesalahan
            $error = "Peran tidak valid.";
        }
    } else {
        // Jika tidak ditemukan, tampilkan pesan kesalahan
        $error = "Username atau password salah.";
    }
    // Tutup koneksi ke database
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        
    body {
	display: flex;
	justify-content: center;
	align-items: center;
	height: 100vh;
	flex-direction: column;
}

* {
	font-family: Arial, sans-serif;
	box-sizing: padding-box;
}

.container {
	width: 600px;
	padding: 20px;
    background-image: linear-gradient(to left, #fadadd, #ffff);
	background-position: center;
	border-radius: 20px;
}

h2 {
	text-align: center;
	margin-bottom: 40px;
}

input, select {
	display: block;
	width: 50%;
	padding: 10px;
	margin: 10px auto;
}

body {
    background-image: url(https://i2.wp.com/wallpapercave.com/wp/wp2973341.jpg);
    background-size: cover;
    background-repeat: no-repeat;
    margin: 0;
    padding: 0;
}

.error-message {
    display: block;
    color: red;
    text-align: center;
}

p {
    text-align: center;
}

a {
    color:#0033cc;
    text-decoration: underline;
}

.form-group {
        text-align: center;
    }

    </style>
</head>
<body>
    <section id="login">
        <div class="container">
            <h2>Hi There</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label></label>
                    <input type="text" name="username" class="form-control" placeholder="Enter your username">
                </div>
                <div class="form-group">
                    <label></label>
                    <input type="password" name="password" class="form-control" placeholder="Enter your password">
                </div>
                <div class="form-group">
                    <label>Select Role</label>
                    <select name="level" class="form-control">
                        <option value="admin">Admin</option>
                        <option value="customer">Customer</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn" value="Login" style="background-color: #ff69b4; border-radius: 10px; border: #ffff; width: 54%;" >
                </div>
                <p>Don't have an account? <a href="registration.php">Register now</a>.</p>
            </form>
        </div>
    </section>
</body>
</html>
