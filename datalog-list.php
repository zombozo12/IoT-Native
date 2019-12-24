<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Material Dash</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/jvectormap/jquery-jvectormap.css">
    <!-- End plugin css for this page -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/demo/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.png"/>
</head>
<body>
<script src="assets/js/preloader.js"></script>
<?php

require "connection.php";
require "session.php";

use iot\connection\connection;
use session\session;

$sessionHandler = new session();
$initDb = connection::initDatabase();


if (!$sessionHandler->isRegistered()) {
    header('Location: login.php');
    return;
}

?>
<div class="body-wrapper">
    <!-- partial:partials/sidebar.php -->
    <?php
    include 'partials/sidebar.php';
    ?>
    <!-- partial -->
    <div class="main-wrapper mdc-drawer-app-content">
        <!-- partial:partials/navbar.php -->
        <?php
        include 'partials/navbar.php';
        ?>
        <!-- partial -->
        <div class="page-wrapper mdc-toolbar-fixed-adjust">
            <main class="content-wrapper">
                <div class="mdc-layout-grid">
                    <div class="mdc-layout-grid__inner">
                        <div class="mdc-layout-grid__cell--span-10">
                            <div class="mdc-card">
                                <h6 class="card-title card-padding pb-0">Data Peminjaman</h6>
                                <div class="table-responsive">
                                    <table class="table table-hoverable">
                                        <thead>
                                        <tr>
                                            <th class="text-left">No.</th>
                                            <th>Kode Alat</th>
                                            <th>SOC (%)</th>
                                            <th>Arus AC</th>
                                            <th>Tegangan AC</th>
                                            <th>Power AC</th>
                                            <th>Energi AC</th>
                                            <th>Arus PV</th>
                                            <th>Tegangan PV</th>
                                            <th>Tanggal</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $usr_id = $sessionHandler->get('usr_id');
                                        $role   = $sessionHandler->get('usr_role');
                                        $logData = $initDb->getDataLog($role, $usr_id);
                                        $no = 1;

                                        foreach ($logData as $data) {
                                            ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $data['kodeAlat']; ?></td>
                                                <td><?= $data['soc']; ?></td>
                                                <td><?= $data['iac']; ?></td>
                                                <td><?= $data['vac']; ?></td>
                                                <td><?= $data['power_ac']; ?></td>
                                                <td><?= $data['energi_ac']; ?></td>
                                                <td><?= $data['ipv']; ?></td>
                                                <td><?= $data['vpv']; ?></td>
                                                <td><?= $data['tanggal']; ?></td>
                                                <td>
                                                    <a href="/datalog-edit.php?id=<?= $data['dat_id'] ?>"
                                                           class="mdc-button mdc-button--raised icon-button filled-button--primary"><i
                                                                class="material-icons mdc-button__icon">edit</i>
                                                    </a>
                                                    <a href="/datalog/doDelete.php?id=<?= $data['dat_id'] ?>"
                                                       class="mdc-button mdc-button--raised icon-button filled-button--secondary"><i
                                                                class="material-icons mdc-button__icon">delete</i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>
<!-- plugins:js -->
<script src="assets/vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<script src="assets/vendors/chartjs/Chart.min.js"></script>
<script src="assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
<script src="assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="assets/js/material.js"></script>
<script src="assets/js/misc.js"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="assets/js/dashboard.js"></script>
<!-- End custom js for this page-->
</body>
</html>