<link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.css">
<script src="../node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
<body></body>

<?php
require "../connection.php";
require "../session.php";
use iot\connection\connection;
use session\session;

$sessionHandler = new session();
$initDb = connection::initDatabase();

if (!$sessionHandler->isRegistered()){
    header('Location: /login.php');
    return;
}

$username   = $_POST['username'];
$password   = $_POST['password'];
$repassword = $_POST['repassword'];
$email      = $_POST['email'];
$alamat     = $_POST['alamat'];

if($password !== $repassword){
    ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Account',
            text: 'Password tidak sama'
        }).then(function(){
            history.back();
        });
    </script>
    <?php
    return;
}

//Foto
$fotoAcc = generateRandomString() . '.' . pathinfo($_FILES['foto_acc']['name'], PATHINFO_EXTENSION);
$tmpFoto = $_FILES['foto_acc']['tmp_name'];

$fotoDir = '../files/foto/';
$upload  = move_uploaded_file($tmpFoto, $fotoDir . $fotoAcc);

//KTP
$fotoKtp  = generateRandomString() . '.' . pathinfo($_FILES['foto_ktp']['name'], PATHINFO_EXTENSION);
$tmpKtp = $_FILES['foto_ktp']['tmp_name'];

$ktpDir = '../files/ktp/';
$upload  = move_uploaded_file($tmpKtp, $ktpDir . $fotoKtp);

$role = $_POST['role'];

$tambah  = $initDb->addAccount($username, $email, $password, $alamat, $fotoAcc, $fotoKtp, $role);
if(!$tambah){
    ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Account',
            text: '<?= $_SESSION['message']; ?>'
        }).then(function(){
            history.back();
        });
    </script>
    <?php
    return;
}


?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Account',
        text: 'Account berhasil ditambahkan'
    }).then(function(){
        window.location = '/account-list.php';
    });
</script>
<?php
function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>