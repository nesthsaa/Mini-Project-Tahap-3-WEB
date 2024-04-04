<?php
session_start();

// Include file konfigurasi database
include 'config.php';

// Periksa apakah pengguna sudah login sebagai admin
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["level"] !== 'admin') {
    header("location: login.php");
    exit;
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
        /* Tambahkan margin ke tombol di kolom "Actions" */
        .table .btn-primary,
        .table .btn-success,
        .table .btn-danger {
            margin-right: 10px; /* Memberikan jarak di sebelah kanan tombol */
            display: inline-block; /* Mengatur tombol agar memiliki lebar yang sesuai dengan kontennya */
            }

        .btn-primary, .btn-success {
            color: #0011a7; /* Warna teks tombol */   
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
                <a href="#customers"><span class="icon"><ion-icon name="person"></ion-icon></span> <span class="title"> user</span></a>
            </li>
            <li class="list">
                <a href="#appointments"><span class="icon"><ion-icon name="alarm"></ion-icon></ion-icon></span> <span class="title"> analytics</span></a>
            </li>
            <li class="list">
                <a href="#feedback"><span class="icon"><ion-icon name="chatbubbles"></ion-icon></span> <span class="title"> messages</span></a>
            </li>
            <li class="list">
                <a href="logout.php"><span class="icon"><ion-icon name="log-out"></ion-icon></span> <span class="title"> signout</span></a>
            </li>
        </ul>
    </div>

    <div class="toggle">
        <ion-icon name="menu" class="open"></ion-icon>
        <ion-icon name="close" class="close"></ion-icon>
    </div>
    <div class="container mt-5">
        <h1 class="mb-4">Admin Panel - Gloss&Glam</h1>
<!-- Bagian Home -->
<div id="home">
<h2 style="text-decoration: underline;  text-decoration-color: #ff1493;">Home</h2>
    <p>Welcome to the Admin Panel of Hair Studio! This panel provides you with all the tools and features you need to manage your salon business efficiently. Here, you can perform various tasks such as managing customers, handling appointments, and reviewing feedback from clients.</p>
    
    <h3>Features:</h3>
    <ul>
        <li><strong>Customers:</strong> View, edit, and delete customer information. Keep track of your loyal customers and their contact details.</li>
        <li><strong>Appointments:</strong> Manage appointments by approving or canceling them. Stay organized with a clear overview of upcoming appointments.</li>
        <li><strong>Feedbacks:</strong> Monitor client feedback and ratings for different treatments. Use this information to improve your salon services.</li>
    </ul>
    
    <h3>Tips for Effective Salon Management:</h3>
    <ol>
        <li><strong>Stay Organized:</strong> Use the appointment scheduler to manage your time effectively. Ensure that your staff is aware of their schedules and duties.</li>
        <li><strong>Provide Excellent Customer Service:</strong> Focus on delivering exceptional service to every customer. Address their needs and concerns promptly.</li>
        <li><strong>Keep Your Salon Clean and Hygienic:</strong> Maintain a clean and hygienic environment to ensure the comfort and safety of your clients.</li>
        <li><strong>Promote Your Services:</strong> Utilize social media platforms and other marketing channels to promote your salon services and attract new clients.</li>
        <li><strong>Seek Feedback:</strong> Encourage clients to provide feedback on their salon experience. Use their input to identify areas for improvement and enhance customer satisfaction.</li>
    </ol>
</div>

        <h2 style="text-decoration: underline;  text-decoration-color: #ff1493;">Customers</h2>
        <div class="table-responsive" id="customers">
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
                                    <a href='update.php' class='btn btn-primary btn-sm'>Edit</a>
                                    <a href='#' class='btn btn-danger btn-sm'>Delete</a>
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

        <h2 style="text-decoration: underline;  text-decoration-color: #ff1493;">Appointments</h2>
        <div class="table-responsive" id="appointments">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Service</th>
                        <th>Actions</th>
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
                            echo "<td>";
                            echo "<a href='approve_appointment.php?id=" . $row['id'] . "' class='btn btn-success btn-sm'>Approve</a>"; // Tautan untuk menyetujui janji
                            echo "<a href='cancel_appointment.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm'>Cancel</a>"; // Tautan untuk membatalkan janji
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No appointments found</td></tr>";
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
                
                function openEditForm(customer_id, username, email) {
                    // Semua form edit disembunyikan terlebih dahulu
                    let editForms = document.querySelectorAll('[id^=editForm]');
                    editForms.forEach(form => {
                        form.style.display = 'none';
                    });

                    // Form edit yang sesuai dengan customer_id akan ditampilkan
                    let editForm = document.getElementById('editForm-' + customer_id);
                    editForm.style.display = 'block';

                    // Isi nilai form dengan data pelanggan yang sesuai
                    editForm.querySelector('input[name="new_username"]').value = username;
                    editForm.querySelector('input[name="new_email"]').value = email;
                }
                </script>

</body>
</html>
