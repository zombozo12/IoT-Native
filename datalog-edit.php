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

$dat_id = $_GET['id'];
if(!isset($dat_id)){
    header('Location: /datalog-in.php');
    return;
}

$datalog = $initDb->getDataLogByID($dat_id);
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
                                <h6 class="card-title">Data Log</h6>
                                <div class="template-demo">
                                    <form action="datalog/doEdit.php" method="post">
                                        <?php
                                            foreach ($datalog as $data) {
                                                ?>
                                                <input type="hidden" name="dat_id" value="<?= $data['dat_id']; ?>">
                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                    <div class="mdc-text-field mdc-text-field--outlined">
                                                        <input class="mdc-text-field__input" id="text-field-hero-input"
                                                               maxlength="5" type="text" name="kodeAlat" value="<?= $data['kodeAlat'] ?>">
                                                        <div class="mdc-notched-outline">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch">
                                                                <label for="text-field-hero-input"
                                                                       class="mdc-floating-label">Kode Alat (Max. 5
                                                                    karakter)</label>
                                                            </div>
                                                            <div class="mdc-notched-outline__trailing"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                    <div class="mdc-text-field mdc-text-field--outlined">
                                                        <input class="mdc-text-field__input" id="text-field-hero-input"
                                                               type="text" name="soc" value="<?= $data['soc']; ?>">
                                                        <div class="mdc-notched-outline">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch">
                                                                <label for="text-field-hero-input"
                                                                       class="mdc-floating-label">SOC</label>
                                                            </div>
                                                            <div class="mdc-notched-outline__trailing"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                    <div class="mdc-text-field mdc-text-field--outlined">
                                                        <input class="mdc-text-field__input" id="text-field-hero-input"
                                                               type="text" name="iac" value="<?= $data['iac']; ?>">
                                                        <div class="mdc-notched-outline">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch">
                                                                <label for="text-field-hero-input"
                                                                       class="mdc-floating-label">Arus AC</label>
                                                            </div>
                                                            <div class="mdc-notched-outline__trailing"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                    <div class="mdc-text-field mdc-text-field--outlined">
                                                        <input class="mdc-text-field__input" id="text-field-hero-input"
                                                               type="text" name="vac" value="<?= $data['vac']; ?>">
                                                        <div class="mdc-notched-outline">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch">
                                                                <label for="text-field-hero-input"
                                                                       class="mdc-floating-label">Tegangan AC</label>
                                                            </div>
                                                            <div class="mdc-notched-outline__trailing"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                    <div class="mdc-text-field mdc-text-field--outlined">
                                                        <input class="mdc-text-field__input" id="text-field-hero-input"
                                                               type="text" name="powerac" value="<?= $data['power_ac']; ?>">
                                                        <div class="mdc-notched-outline">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch">
                                                                <label for="text-field-hero-input"
                                                                       class="mdc-floating-label">Power AC</label>
                                                            </div>
                                                            <div class="mdc-notched-outline__trailing"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                    <div class="mdc-text-field mdc-text-field--outlined">
                                                        <input class="mdc-text-field__input" id="text-field-hero-input"
                                                               type="text" name="energiac" value="<?= $data['energi_ac']; ?>">
                                                        <div class="mdc-notched-outline">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch">
                                                                <label for="text-field-hero-input"
                                                                       class="mdc-floating-label">Energy AC</label>
                                                            </div>
                                                            <div class="mdc-notched-outline__trailing"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                    <div class="mdc-text-field mdc-text-field--outlined">
                                                        <input class="mdc-text-field__input" id="text-field-hero-input"
                                                               type="text" name="ipv" value="<?= $data['ipv']; ?>">
                                                        <div class="mdc-notched-outline">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch">
                                                                <label for="text-field-hero-input"
                                                                       class="mdc-floating-label">Arus PV</label>
                                                            </div>
                                                            <div class="mdc-notched-outline__trailing"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                    <div class="mdc-text-field mdc-text-field--outlined">
                                                        <input class="mdc-text-field__input" id="text-field-hero-input"
                                                               type="text" name="vpv" value="<?= $data['vpv']; ?>">
                                                        <div class="mdc-notched-outline">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch">
                                                                <label for="text-field-hero-input"
                                                                       class="mdc-floating-label">Tegangan PV</label>
                                                            </div>
                                                            <div class="mdc-notched-outline__trailing"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                    <div class="mdc-text-field mdc-text-field--outlined">
                                                        <input class="mdc-text-field__input" id="text-field-hero-input"
                                                               type="date" name="tanggal" value="<?= $data['tanggal']; ?>">
                                                        <div class="mdc-notched-outline">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch">
                                                                <label for="text-field-hero-input"
                                                                       class="mdc-floating-label">Tanggal</label>
                                                            </div>
                                                            <div class="mdc-notched-outline__trailing"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button class="mdc-button mdc-button--raised" type="submit"
                                                        name="btnSubmit">
                                                    Edit
                                                </button>
                                                <?php
                                            }
                                        ?>
                                    </form>
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