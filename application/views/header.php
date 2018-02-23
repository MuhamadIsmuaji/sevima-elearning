<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sevima E-Learning</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- css libs -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/bulma.css') ?>">
</head>
<body>

<nav class="navbar container" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="<?= base_url('/') ?>">
            Sevima E-Learning
        </a>
        <div class="navbar-burger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <div class="navbar-menu">
        <div class="navbar-end">
            <a href="https://kelaslaravel.com" class="navbar-item">Kelas</a>
            <a href="https://kawankoding.com/course" class="navbar-item">Seri</a>
            <a href="https://kawankoding.com/post" class="navbar-item">Blog</a>
            
            <?php 
                if ($user = $this->session->userdata('sevima-elearning')) {
                    ?>

                    <div class="navbar-item has-dropdown is-hoverable">
                        <a class="navbar-link"><?= $user->name ?></a>
                        <div class="navbar-dropdown">
                            <a class="navbar-item">
                                Dasbor
                            </a>
                            <a class="navbar-item">
                                Pengaturan Profil
                            </a>
                            <hr class="navbar-divider">
                            <a href="<?= base_url('logout') ?>" class="navbar-item">Keluar</a>
                        </div>
                    </div>
            <?php
                } else {
                    ?>
                    <div class="navbar-item">
                        <div class="field is-grouped">
                            <p class="control">
                            <a href="<?= base_url('login') ?>" class="button is-primary is-outlined">Masuk</a>
                            <a href="<?= base_url('register') ?>" class="button is-primary">Daftar</a>
                            </p>
                        </div>
                    </div>
            <?php
                } ?>

        </div>
    </div>
</nav>