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

$pmj_id     = $_POST['pmj_id'];
$nama       = $_POST['nama'];
$alamat     = $_POST['alamat'];
$jenis_alat = $_POST['jenis_alat'];

//Foto
$fotoPmj = generateRandomString() . '.' . pathinfo($_FILES['foto_pmj']['name'], PATHINFO_EXTENSION);
$tmpFoto = $_FILES['foto_pmj']['tmp_name'];

$fotoDir = '../files/foto/';
$upload  = move_uploaded_file($tmpFoto, $fotoDir . $fotoPmj);

//KK
$fotoKk  = generateRandomString() . '.' . pathinfo($_FILES['foto_kk']['name'], PATHINFO_EXTENSION);
$tmpKk = $_FILES['foto_kk']['tmp_name'];

$kkDir = '../files/kk/';
$upload  = move_uploaded_file($tmpKk, $kkDir . $fotoKk);

//KTP
$fotoKtp  = generateRandomString() . '.' . pathinfo($_FILES['foto_ktp']['name'], PATHINFO_EXTENSION);
$tmpKtp = $_FILES['foto_ktp']['tmp_name'];

$ktpDir = '../files/ktp/';
$upload  = move_uploaded_file($tmpKtp, $ktpDir . $fotoKtp);


$tambah  = $initDb->editPeminjaman($pmj_id, $nama, $alamat, $fotoPmj, $fotoKk, $fotoKtp, $jenis_alat);
if(!$tambah){
    ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Peminjaman',
            text: '<?= $_SESSION['message']; ?>'
        });
    </script>
    <?php
    return;
}


?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Peminjaman',
        text: 'Peminjaman berhasil diubah'
    }).then(function(){
        window.location = '/peminjaman-list.php';
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