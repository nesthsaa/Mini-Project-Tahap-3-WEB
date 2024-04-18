<?php
session_start();

// Include file konfigurasi database
include 'config.php';

// Periksa apakah pengguna sudah login sebagai admin
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["level"] !== 'admin') {
    header("location: login.php");
    exit;
}

// Fungsi untuk menambahkan pelanggan baru
if (isset($_POST['submit'])) {
    // Ambil data yang dikirimkan dari form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Ambil password dari form

    // Query untuk menambahkan pelanggan baru
    $sql_add_customer = "INSERT INTO user (username, email, password, level) VALUES ('$username', '$email', '$password', 'customer')";

    // Eksekusi query
    if (mysqli_query($conn, $sql_add_customer)) {
        echo "<script>alert('Customer added successfully!');</script>";
    } else {
        echo "Error: " . $sql_add_customer . "<br>" . mysqli_error($conn);
    }
}



// Fungsi untuk mengubah status janji temu dalam basis data
function updateAppointmentStatus($appointment_id, $status) {
    global $conn; // Gunakan koneksi ke basis data yang sudah dibuat sebelumnya
    $sql = "UPDATE appointments SET status='$status' WHERE id='$appointment_id'";

    if ($conn->query($sql) === TRUE) {
        // Tampilkan pemberitahuan dengan skrip JavaScript jika pembaruan berhasil
        echo "<script>alert('Appointment status updated successfully');</script>";
    } else {
        // Tampilkan pesan error jika terjadi kesalahan dalam pembaruan
        echo "Error updating appointment status: " . $conn->error;
    }
}



// Jika ada permintaan form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Periksa apakah tombol aksi ditekan untuk menerima atau menolak janji temu
    if (isset($_POST["accept"])) { 
        $appointment_id = $_POST["appointment_id"];
        // Panggil fungsi untuk mengubah status janji temu menjadi diterima
        updateAppointmentStatus($appointment_id, "accepted");
        // Berikan notifikasi kepada pelanggan tentang status janji temu yang diterima
        // Anda dapat menggunakan email atau pesan teks untuk memberi tahu pelanggan
    } elseif (isset($_POST["reject"])) {
        $appointment_id = $_POST["appointment_id"];
        // Panggil fungsi untuk mengubah status janji temu menjadi ditolak
        updateAppointmentStatus($appointment_id, "rejected");
        // Berikan notifikasi kepada pelanggan tentang status janji temu yang ditolak
        // Anda dapat menggunakan email atau pesan teks untuk memberi tahu pelanggan
    }
}
// Periksa apakah tombol delete pelanggan ditekan
if (isset($_POST["delete_customer"])) {
    // Ambil ID pelanggan yang akan dihapus
    $customer_id = $_POST["customer_id"];

    // Query untuk mengambil informasi pelanggan sebelum dihapus (opsional)
    $query_customer_info = "SELECT * FROM user WHERE id_user = '$customer_id'";
    $result_customer_info = mysqli_query($conn, $query_customer_info);
    $customer_info = mysqli_fetch_assoc($result_customer_info);

    // JavaScript untuk konfirmasi penghapusan
    echo "<script>
            if (confirm('Are you sure you want to delete customer " . $customer_info['username'] . "?')) {
                // Jika pengguna menekan OK, lanjutkan dengan penghapusan
                window.location.href = '" . htmlspecialchars($_SERVER["PHP_SELF"]) . "?delete_id=$customer_id';
            } else {
                // Jika pengguna menekan Cancel, batalkan penghapusan
                alert('Deletion canceled');
            }
          </script>";
}

// Jika ada parameter delete_id yang diterima dari JavaScript, hapus pelanggan
if (isset($_GET['delete_id'])) {
    // Ambil ID pelanggan yang akan dihapus dari parameter URL
    $customer_id = $_GET['delete_id'];

    // Query untuk menghapus pelanggan dari database
    $sql_delete_customer = "DELETE FROM user WHERE id_user = '$customer_id'";

    // Eksekusi query
    if (mysqli_query($conn, $sql_delete_customer)) {
        // Pemberitahuan setelah berhasil menghapus
        echo "<script>alert('Customer deleted successfully!');</script>";
        // Setelah menghapus, refresh halaman agar perubahan terlihat
        echo "<script>window.location.href = '" . htmlspecialchars($_SERVER["PHP_SELF"]) . "';</script>";
    } else {
        // Pemberitahuan jika terjadi kesalahan saat menghapus
        echo "<script>alert('Error deleting customer: " . mysqli_error($conn) . "');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Hair Studio</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5+zE3/xqdjZ0XmxVA5BapK8F5t/0eb5SkELOI4Ip" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
          body {
            background-color: #f6e7ea; /* Warna latar belakang */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            color: #555; /* Warna teks */
        }

        .container {
            max-width: 900px;
            margin: 20px auto; /* Menyesuaikan margin untuk membuat kontainer lebih masuk */
            padding: 5px;
            background-color: #fff; /* Latar belakang kontainer */
            border-radius: 10px; /* Sudut bulat */
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); /* Efek bayangan */
        }

        .container table {
            padding: 10px; /* Menambahkan padding di sekitar tabel */
            margin-left: 20px;
        }


        h1, h2 {
            color: #333; /* Warna judul */
            text-align: center;
        }


        .btn-danger {
            color: #fff; /* Warna teks tombol */
            border-radius: 5px; Sudut bulat tombol
        }

        .btn-danger {
            background-color: #dc143c; /* Warna latar belakang tombol hapus */
            border-color: #dc3545; /* Warna border tombol hapus */
            padding: 5px 10px; /* Menambahkan padding 5px di atas dan bawah, 10px di kiri dan kanan */
        }

        .btn-danger:hover {
            background-color: #c82333; /* Warna latar belakang tombol hapus saat dihover */
            border-color: #c82333; /* Warna border tombol hapus saat dihover */
        }

        /* Gaya tombol "Accept" */
        .btn-accept {
            background-color: green;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }

        /* Gaya tombol "Reject" */
        .btn-reject {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }

        /* Efek hover pada tombol */
        .btn-accept:hover,
        .btn-reject:hover {
            opacity: 0.8; /* Membuat sedikit transparan saat dihover */
        }


        #showAddCustomerForm {
        background-color: green;
        color: white;
        margin-bottom: 10px; /* Memberikan margin bawah */
        margin-left: 20px;
        border: none; /* Menghapus border */
        padding: 8px 16px; /* Padding tombol */
        cursor: pointer; /* Mengubah kursor saat diarahkan ke tombol */
        border-radius: 5px; /* Membuat sudut bulat */
        }

        /* Gaya tombol "Add Customer" saat dihover */
        #showAddCustomerForm:hover {
            background-color: darkgreen; /* Mengubah warna latar belakang saat dihover */
        }
        #customerForm {
            margin-left: 20px;
            margin-bottom: 10px;
        }

        /* Tabel */
        .table {
            background-color: #fff; /* Warna latar belakang tabel */
            border-radius: 16px; /* Sudut bulat tabel */
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); /* Efek bayangan tabel */
            font-size: 16px;
        }


        .table th,
        .table td {
            border-top: none; /* Hapus garis atas */'
            padding: 20px; /* Tambahkan padding di sekitar isi sel */
        }

        .table th {
            background-color: #ff1493; /* Warna latar belakang header tabel */
            color: #fff; /* Warna teks header tabel */
            font-weight: bold; /* Tebal pada header tabel */
            border-bottom: 2px solid #fff; /* Garis bawah */
            font-size: 16px;
        }
        .table-responsive {
            overflow-x: auto;
            margin-bottom: 20px; /* Tambahkan margin di bagian bawah untuk meninggalkan ruang antara tabel dengan elemen lain */
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f8f9fa; /* Warna latar belakang setiap baris ganjil */
        }

        /* Responsif */
        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
            }
        }

        .navbar{
            position: fixed;
            top: 2rem; left: 2rem;
            bottom: 2rem;
            width: 7rem;
            background: #ff1493; /* Ubah warna latar belakang menjadi pink */
            border-radius: 1rem;
            border-left: .5rem solid #db7093 ; /* Ubah warna border menjadi pink */
            box-sizing: initial;
            transition: width 0.5s;
            overflow-x: hidden;
        }

.navbar.active{
    width: 30rem;
}

.navbar ul{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    padding: 4rem .8rem 0 .3rem;
}

.navbar ul li{
    list-style: none;
    width: 100%;
    border-radius: 1rem;
}

.navbar ul li.active{
    background: #fff;
}

.navbar ul li a{
    display: flex;
    color: #fff; /* Ubah warna teks menjadi putih */
    text-decoration: none;
}

.navbar ul li.active a{
    color: #333;
}

.navbar ul li a .icon{
    min-width: 6rem;
    height: 6rem;
    line-height: 7.5rem;
    text-align: center;
}

.navbar ul li a .icon ion-icon{
    font-size: 2.2rem;
}

.navbar ul li a .title{
    padding-left: 1rem;
    height: 6rem;
    line-height: 6rem;
    text-transform: capitalize;
    font-size: 1.5rem;
}

.toggle{
    position: fixed;
    top: 2rem; right: 5rem;
    height: 5rem;
    width: 5rem;
    background: #ff1493;  /* Ubah warna latar belakang menjadi pink */
    border-radius: 1rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.toggle ion-icon{
    position: absolute;
    color: #fff; /* Ubah warna ikon menjadi putih */
    font-size: 3.4rem;
    display: none;
}

.toggle ion-icon.open,
.toggle.active ion-icon.close{
    display: block;
}

.toggle ion-icon.close,
.toggle.active ion-icon.open{
    display: none;
}

</style>
</head>
<body>
<div class="navbar">
        <ul>
            <li class="list active">
                <a href="#"><span class="icon"><ion-icon name="home"></ion-icon></span> <span class="title"> Home</span></a>
            </li>
            <li class="list">
                <a href="#customers"><span class="icon"><ion-icon name="person"></ion-icon></span> <span class="title"> User</span></a>
            </li>
            <li class="list">
                <a href="#appointments"><span class="icon"><ion-icon name="alarm"></ion-icon></ion-icon></span> <span class="title"> Appointment</span></a>
            </li>
            <li class="list">
                <a href="#feedback"><span class="icon"><ion-icon name="chatbubbles"></ion-icon></span> <span class="title"> Feedback</span></a>
            </li>
            <li class="list">
                <a href="logout.php"><span class="icon"><ion-icon name="log-out"></ion-icon></span> <span class="title"> Log Out</span></a>
            </li>
        </ul>
    </div>

    <div class="toggle">
        <ion-icon name="menu" class="open"></ion-icon>
        <ion-icon name="close" class="close"></ion-icon>
    </div>
    <div class="container mt-5">
        <h1 class="mb-4"> Halaman Admin - Gloss&Glam</h1>
<!-- Bagian Home -->
<div id="home">
<h2 style="text-decoration: underline;  text-decoration-color: #ff1493;">Home</h2>
    <p>Selamat datang di Halaman Admin! Halaman ini menyediakan fitur yang Anda butuhkan untuk mengelola bisnis hair studio Anda dengan efisien. Di sini, Anda dapat melakukan berbagai task seperti mengelola pelanggan, melakukan penyetujuan dan pembatalan appointment, dan meninjau feedback dari customer.</p>

    <h3>Tips for Effective Salon Management:</h3>
    <ol>
    <li><strong>Stay Organized:</strong> Gunakan penjadwalan appointment untuk mengelola waktu Anda dengan efektif. Pastikan bahwa staf dan stylist mengetahui jadwal dan tugas mereka.</li>
        <li><strong>Provide Excellent Customer Service:</strong> Fokuslah pada memberikan layanan yang luar biasa kepada setiap customer. Tanggapi kebutuhan dan kekhawatiran mereka dengan cepat.</li>
        <li><strong>Keep Your Hair Studio Clean and Hygienic:</strong>Pertahankan lingkungan yang bersih dan higienis untuk menjamin kenyamanan dan keamanan customer Anda.</li>
        <li><strong>Promote Your Services:</strong> Manfaatkan platform media sosial dan saluran pemasaran lainnya untuk mempromosikan layanan hair studio dan menarik customer baru.</li>
        <li><strong>Seek Feedback:</strong> Dorong customer untuk memberikan feedback tentang pengalaman mereka di hair studio. Gunakan masukan mereka untuk mengidentifikasi bagian yang perlu diperbaiki dan meningkatkan kepuasan pelanggan.</li>
    </ol>
</div>


<h2 style="text-decoration: underline;  text-decoration-color: #ff1493;">Customers</h2>
<div id="customers">
<button id="showAddCustomerForm" class="btn btn-success">Add Customer</button>

    <!-- Form Add Customer (sembunyikan awalnya menggunakan inline CSS) -->
    <!-- Form Add Customer -->
    <div id="addCustomerForm" style="display: none;">
        <form id="customerForm" action="" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" name="submit" class="btn btn-success" style="background-color: green; color: white;">Add Customer</button>
        </form>
    </div>

</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Query untuk mengambil data pelanggan dari database
            $query_customers = "SELECT * FROM user WHERE level = 'customer'";
            $result_customers = mysqli_query($conn, $query_customers);

            if (mysqli_num_rows($result_customers) > 0) {
                while ($row_customer = mysqli_fetch_assoc($result_customers)) {
                    echo "<tr>";
                    echo "<td>" . $row_customer['id_user'] . "</td>";
                    echo "<td>" . $row_customer['username'] . "</td>";
                    echo "<td>" . $row_customer['email'] . "</td>";
                    echo "<td>
                        <form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>
                            <input type='hidden' name='customer_id' value='" . $row_customer['id_user'] . "'>
                            <button type='submit' name='delete_customer' class='btn btn-danger'>Delete</button>
                        </form>
                    </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No customers found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>


<h2 style="text-decoration: underline; text-decoration-color: #ff1493;">Appointments</h2>
<div class="table-responsive" id="appointments">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Date</th>
                <th>Time</th>
                <th>Service</th>
                <th>Status</th>
                <th>Action</th> <!-- Menambahkan kolom aksi -->
            </tr>
        </thead>

        <tbody>
            <?php
            // Fetch appointments data from database
            $query_appointments = "SELECT * FROM appointments";
            $result_appointments = mysqli_query($conn, $query_appointments);

            if (mysqli_num_rows($result_appointments) > 0) {
                while ($row = mysqli_fetch_assoc($result_appointments)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['date'] . "</td>";
                    echo "<td>" . $row['time'] . "</td>";
                    echo "<td>" . $row['service'] . "</td>";
                    echo "<td>" . $row['status'] . "</td>";

                    // Kolom aksi untuk menerima atau menolak janji temu
                    echo "<td>";
                    echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
                    echo "<input type='hidden' name='appointment_id' value='" . $row['id'] . "'>";
                    echo "<input type='submit' name='accept' value='Accept' class='btn-accept'>";
                    echo "<input type='submit' name='reject' value='Reject' class='btn-reject'>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No appointments found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>


        <h2 style="text-decoration: underline;  text-decoration-color: #ff1493;">Feedbacks</h2>
        <div class="table-responsive" id="feedback">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Treatment</th>
                        <th>Feedback</th>
                        <th>Rating</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Query untuk mengambil data umpan balik dari database
                    $query_feedback = "SELECT * FROM feedback";
                    $result_feedback = mysqli_query($conn, $query_feedback
                );
                if (mysqli_num_rows($result_feedback) > 0) {
                while ($row_feedback = mysqli_fetch_assoc($result_feedback)) {
                echo "<tr>";
                echo "<td>" . $row_feedback['id'] . "</td>";
                echo "<td>" . $row_feedback['treatment'] . "</td>";
                echo "<td>" . $row_feedback['feedback'] . "</td>";
                echo "<td>" . $row_feedback['rating'] . "</td>";
                echo "</tr>";
                }
                } else {
                echo "<tr><td colspan='4'>No feedbacks found</td></tr>";
                }
                ?>
                </tbody>
                </table>
                </div>
                </div>
                <!-- Bootstrap Bundle with Popper -->
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-6zIgT3lOy6VrO5/dGh3Q5zJpfwsR83qo1cx2T0c1jHLWphREo7TM+hXWQ2jKRbta" crossorigin="anonymous"></script>
                <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
                <script>
                let menu = document.querySelector('.toggle');
                let navbar = document.querySelector('.navbar');

                menu.onclick = function(){
                    menu.classList.toggle('active');
                    navbar.classList.toggle('active');
                }

                let list = document.querySelectorAll('.list');

                for(let i=0; i<list.length; i++){
                    list[i].onclick = function(){
                        let j=0;
                        while(j<list.length){
                            list[j++].className = 'list'
                        }
                        list[i].className = 'list active';
                    }
                }
 // Fungsi untuk menampilkan formulir tambah pelanggan
 function showAddCustomerForm() {
        var form = document.getElementById("addCustomerForm");
        form.style.display = "block"; // Tampilkan formulir
    }

    // Ketika tombol "Add Customer" diklik, tampilkan formulir
    document.getElementById("showAddCustomerForm").addEventListener("click", function() {
        showAddCustomerForm();
    });

    // Fungsi untuk menyembunyikan formulir tambah pelanggan
    function hideAddCustomerForm() {
        var form = document.getElementById("addCustomerForm");
        form.style.display = "none"; // Sembunyikan formulir
    }

    // Ketika formulir tambah pelanggan dikirim, sembunyikan formulir
    document.getElementById("customerForm").addEventListener("submit", function() {
        hideAddCustomerForm();
    });
    </script>
</body>
</html>