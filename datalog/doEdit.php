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

$dat_id     = $_POST['dat_id'];
$kodeAlat   = $_POST['kodeAlat'];
$soc        = $_POST['soc'];
$iac        = $_POST['iac'];
$vac        = $_POST['vac'];
$power_ac   = $_POST['powerac'];
$energi_ac  = $_POST['energiac'];
$ipv        = $_POST['ipv'];
$vpv        = $_POST['vpv'];
$tanggal    = $_POST['tanggal'];

$update = $initDb->editDataLog($dat_id, $kodeAlat, $soc, $iac, $vac, $power_ac, $energi_ac, $ipv, $vpv, $tanggal);

if(!$update){
    ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Data Log',
            text: 'Edit data log gagal'
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
        title: 'Data Log',
        text: 'Edit data log berhasil'
    }).then(function(){
        window.location = '/datalog-list.php';
    });
</script>
