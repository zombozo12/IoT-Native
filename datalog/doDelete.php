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

$dat_id = $_GET['id'];

if (!isset($dat_id)) {
    ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Data Log',
            text: 'Data log tidak ditemukan'
        }).then(function () {
            history.back();
        });
    </script>
    <?php
    return;
}

$delete = $initDb->deleteDatalogByID($dat_id);

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
                header('Location: /datalog-list.php');
                return;
            }
            ?>
            Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
            ).then(function(){
                window.location = '/datalog-list.php';
            });
        }else{
            history.back();
        }
    })
</script>