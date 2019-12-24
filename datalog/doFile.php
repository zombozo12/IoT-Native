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

$namaFile = generateRandomString() . '.' . pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
$tmpFile = $_FILES['file']['tmp_name'];

$pathDir = '../files/';
$upload = move_uploaded_file('/files/' . $namaFile, $pathDir . $namaFile);

$openFile = fopen($tmpFile, 'rb');

while (($line = fgets($openFile)) !== false) {
    $split = explode(',', $line);

    if (sizeof($split) !== 9) {
        ?>
        <script>
            Swal.fire({
                icon: 'error'
                title: 'Data Log',
                text: 'Isi file tidak sesuai'
            });
        </script>
        <?php
        header('Location: /datalog-in.php');
        return;
    }

    $usr_id     = $sessionHandler->get('usr_id');
    $kodeAlat   = $split[0];
    $soc        = $split[1];
    $iac        = $split[2];
    $vac        = $split[3];
    $power_ac   = $split[4];
    $energi_ac  = $split[5];
    $ipv        = $split[6];
    $vpv        = $split[7];
    $tanggal    = $split[8];

    $tanggal = trim(preg_replace('/\s+/', ' ', $tanggal));

    $addDataLog = $initDb->addDataLog($usr_id, $kodeAlat, $soc, $iac, $vac, $power_ac, $energi_ac, $ipv, $vpv, $tanggal);
    if (!$addDataLog) {
        ?>
        <script>
            Swal.fire({
                icon: 'error'
                title: 'Data Log',
                text: '<?= $_SESSION["message"]; ?>'
            });
        </script>
        <?php
        header('Location: /datalog-in.php');
        return;
    }
}

fclose($openFile);
?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Data Log',
        text: 'Data Log berhasil ditambahkan'
    }).then(function(){
        window.location = '/datalog-in.php';
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