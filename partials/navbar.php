<?php
    $usr_id       = $sessionHandler->get('usr_id');
    $usr_username = $sessionHandler->get('usr_username');
    $usr_email    = $sessionHandler->get('usr_email');
    $usr_foto     = $sessionHandler->get('usr_foto');
?>
<header class="mdc-top-app-bar">
    <div class="mdc-top-app-bar__row">
        <div class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
            <button class="material-icons mdc-top-app-bar__navigation-icon mdc-icon-button sidebar-toggler">menu
            </button>
            <span class="mdc-top-app-bar__title">Greetings <?= $usr_username; ?>!</span>

        </div>
        <div class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end mdc-top-app-bar__section-right">
            <div class="menu-button-container menu-profile d-none d-md-block">
                <button class="mdc-button mdc-menu-button">
                <span class="d-flex align-items-center">
                    <span class="figure">
                        <img src="/files/foto/<?= $usr_foto ?>" alt="user" class="user">
                    </span>
                  <span class="user-name"><?= $usr_username; ?></span>
                </span>
                </button>
                <div class="mdc-menu mdc-menu-surface" tabindex="-1">
                    <ul class="mdc-list" role="menu" aria-hidden="true" aria-orientation="vertical">
                        <li class="mdc-list-item" role="menuitem">
                            <div class="item-thumbnail item-thumbnail-icon-only">
                                <i class="mdi mdi-account-edit-outline text-primary"></i>
                            </div>
                            <div class="item-content d-flex align-items-start flex-column justify-content-center">
                                <h6 class="item-subject font-weight-normal">Edit profile</h6>
                            </div>
                        </li>
                        <li class="mdc-list-item" role="menuitem">
                            <div class="item-thumbnail item-thumbnail-icon-only">
                                <i class="mdi mdi-settings-outline text-primary"></i>
                            </div>
                            <div class="item-content d-flex align-items-start flex-column justify-content-center">
                                <a href="logout.php" class="item-subject font-weight-normal">Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>