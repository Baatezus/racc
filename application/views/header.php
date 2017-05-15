<?php
    $asso = $this->session->userdata('association');
    $user = $this->session->userdata('user');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.1/js/materialize.min.js"></script>
    <script src="<?= base_url() ?>js/angular/angular.min.js"></script>
    <script src="<?= base_url() ?>js/angular/app.js"></script>
    <script src="<?= base_url() ?>js/jquerycommands.js"></script>
    <script src="<?= base_url() ?>js/function.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.1/css/materialize.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>css/form.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="icon" href="<?=base_url()?>images/favico.png" alt="" />
    <script>

    </script>
    <style>
    </style>
</head>
<body ng-app="films">
<noscript><meta http-equiv="refresh" content="0;url=index.php/noscript" /></noscript>
<ul id="dropdown1" class="dropdown-content">
    <li><a class="blue-text" href="<?= base_url() ?>index.php/admin"><i class="material-icons left">reorder</i>Déclarations de créances</a></li>
    <li><a class="blue-text" href="<?= base_url() ?>index.php/admin/associations"><i class="material-icons left">list</i>Liste des associations</a></li>
    <li><a class="blue-text" href="<?= base_url() ?>index.php/admin/stats"><i class="material-icons left">show_chart</i>Statistiques</a></li>
</ul>
<nav class='main-nav blue'>
    <div class="nav-wrapper">
        <a href="#!" class="brand-logo"><?= $title ?></a>
        <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
            <li><a href="<?= base_url() ?>"><i class="material-icons left">home</i>Accueil</a></li>
            <?php if(!$user) { ?>
                <li><a class="" href="<?= base_url() ?>index.php/user/login"><i class="material-icons left">perm_identity</i>Se connecter</a></li>
                <li><a class="" href="<?= base_url() ?>index.php/user/register"><i class="material-icons left">toc</i>Inscrire son association</a></li>
            <?php } else { ?>
                <?php if($user->type === "admin") { ?>
                    <li>
                        <a class="dropdown-button" href="#!" data-activates="dropdown1">
                            <i class="material-icons left">supervisor_account</i>
                            Administration
                            <i class="material-icons right">arrow_drop_down</i>
                        </a>
                    </li>                       
                <?php } else { ?>
                    <li><a href="<?= base_url() ?>index.php/debt_statement/add"><i class="material-icons left">reorder</i>Déclaration de créance</a></li>
                    <li><a href="<?= base_url() ?>index.php/user/mypage"><i class="material-icons left">account_circle</i>Page de l'association</a></li>
                <?php } ?>
                <li><a href="<?= base_url() ?>index.php/user/logout"><i class="material-icons left">exit_to_app</i>Se déconnecter</a></li>
            <?php } ?>         
        </ul>
    </div>
</nav> 

          