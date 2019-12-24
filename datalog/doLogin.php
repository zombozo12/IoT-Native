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

if ($sessionHandler->isRegistered()){
    header('Location: /index.php');
    return;
}

$username   = $_POST['username'];
$password   = $_POST['password'];

if(empty($username) || empty($password)){
    ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Login',
            text: 'Mohon cek kembali form tidak boleh kosong'
        });
    </script>
    <?php
    return;
}
$login = $initDb->login($username, $password);
if(!$login){
    ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Login',
            text: '<?= $_SESSION["message"]; ?>'
        });
    </script>
    <?php
    return;
}
$sessionHandler->register();
$sessionHandler->set('usr_id', $login[0]['id']);
$sessionHandler->set('usr_username', $login[0]['username']);
$sessionHandler->set('usr_email', $login[0]['email']);
$sessionHandler->set('usr_foto', $login[0]['foto']);

$role = $login[0]['role'];

if($role == 'Super Admin'){
    $role = true;
}else{
    $role = false;
}
$sessionHandler->set('usr_role', $role);

?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Login',
        text: 'Login Berhasil'
    }).then(function(){
        window.location = '/index.php';
    });
</script>
