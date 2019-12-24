<link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.css">
<script src="../node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
<body></body>
<?php
require "../connection.php";
require "../session.php";
use iot\connection\connection;
use session\session;

if (!isset($_POST['btnRegister'])) {
    return;
}

$sessionHandler = new session();
$initDb = new connection();

if ($sessionHandler->isRegistered()){
    header('Location: index.php');
    return;
}

$email      = $_POST['email'];
$username   = $_POST['username'];
$password   = $_POST['password'];
$repassword = $_POST['repassword'];

if(empty($email) || empty($username) || empty($password) || empty($repassword)){
    ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Registration',
            text: 'Mohon cek kembali form tidak boleh kosong'
        });
    </script>
    <?php
    return;
}

if($password !== $repassword){
    ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Registration',
            text: 'Konfirmasi password tidak sama'
        });
    </script>
    <?php
    return;
}

if(!$initDb->addUser($username, $password, $email)){
    ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Registration',
            text: '<?= $_SESSION["message"]; ?>'
        });
    </script>
    <?php
    return;
}
?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Registration',
        text: 'Berhasil registrasi'
    });
    window.location.href('index.php');
</script>