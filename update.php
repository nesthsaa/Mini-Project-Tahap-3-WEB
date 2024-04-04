<?php
session_start();

// Include file konfigurasi database
include 'config.php';

// Periksa apakah pengguna sudah login sebagai admin
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["level"] !== 'admin') {
    header("location: login.php");
    exit;
}

// Menangani form submission untuk mengedit data pelanggan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_customers'])) {
    $id_user = $_POST['customers_id'];
    $username = $_POST['new_username'];
    $email = $_POST['new_email'];
    
    // Query untuk mengupdate data pelanggan di database
    $query_update_customers = "UPDATE user SET username='$new_username', email='$new_email' WHERE id_user=$id_user";
    
    if (mysqli_query($conn, $query_update_customers)) {
        // Redirect ke halaman customers setelah berhasil mengedit pelanggan
        header("location: index.php#customers");
        exit;
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <input type="hidden" name="customers_id" value="<?php echo $customer_id; ?>">
    <div class="form-group">
        <label for="new_username">New Username:</label>
        <input type="text" id="new_username" name="new_username" class="form-control" value="<?php echo $current_username; ?>">
    </div>
    <div class="form-group">
        <label for="new_email">New Email:</label>
        <input type="email" id="new_email" name="new_email" class="form-control" value="<?php echo $current_email; ?>">
    </div>
    <button type="submit" name="edit_customers" class="btn btn-primary">Submit</button>
</form>

</body>
</html>