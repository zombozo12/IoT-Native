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

if (!$sessionHandler->isRegistered()) {
    header('Location: /login.php');
    return;
}

$usr_id = $_GET['id'];

if (!isset($usr_id)) {
    ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Account',
            text: 'Account tidak ditemukan'
        }).then(function () {
            history.back();
        });
    </script>
    <?php
    return;
}

$delete = $initDb->deleteAccount($usr_id);

?>
<script>
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            <?php
            if (!$delete) {
                $message = $_SESSION['message'];
                echo "<script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Data Log',
                                text: '$message'
                            });
                        </script>";
                header('Location: /account-list.php');
                return;
            }
            ?>
            Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
            ).then(function(){
                window.location = '/account-list.php';
            });
        }else{
            history.back();
        }
    })
</script>