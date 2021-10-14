<?php
session_start();
if(!isset($_SESSION["username"])) header("Location:signin.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>RSIA AL-ISLAM</title>

    <link href="css/style.default.css" rel="stylesheet">
    <link href="css/morris.css" rel="stylesheet">
    <link href="css/jquery.gritter.css" rel="stylesheet">
    <link href="css/select2.css" rel="stylesheet" />

    <link href="css/style.datatables.css" rel="stylesheet">
    <link href="css/dataTables.responsive.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<style type="text/css">
    .font {
        color: white;
    }
</style>
<body>

<header>
    <div class="headerwrapper">
        <div class="header-left">
            <h4 class="font">RSIA AL-ISLAM</h4>
            <div class="pull-right">
                <a href="" class="menu-collapse">
                    <i class="fa fa-bars"></i>
                </a>
            </div>
        </div><!-- header-left -->

        <div class="header-right">

            <div class="pull-right">

                <div class="btn-group btn-group-option">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-caret-down"></i>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                       
                        <li><a href="signout.php"><i class="glyphicon glyphicon-log-out"></i>Sign Out</a></li>
                    </ul>
                </div><!-- btn-group -->

            </div><!-- pull-right -->

        </div><!-- header-right -->

    </div><!-- headerwrapper -->
</header>

<section>
    <div class="mainwrapper">
        <div class="leftpanel">
            <div class="media profile-left">
                <!-- <a class="pull-left profile-thumb" href=""> -->
                    <img class="img-circle" src="images/logo.jpg" alt="" width="60px">
                <div class="media-body">
                    <h4 class="media-heading"><?= $_SESSION["nama"] ?></h4>
                    <small class="text-muted">Tim Pengadaan</small>
                </div>
            </div><!-- media -->
            <ul class="nav nav-pills nav-stacked">
                <li class="active"><a href="TPengadaan.php"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
                <li class=""><a href="T_obat.php"><i class="fa fa-suitcase"></i> <span>Kelola Barang</span></a></li>
                <li class="parent"><a href=""><i class="glyphicon glyphicon-file"></i> <span>Pengadaan</span></a>
                    <ul class="children">
                        <li><a href="T_listpengadaan.php">Lihat Pengadaan</a></li>
                        <!-- <li><a href="T_pengadaan.php">Tambah Pengadaan</a></li> -->
                    </ul>
                </li>
                <li class="parent"><a href=""><i class="glyphicon glyphicon-file"></i> <span>Permintaan Farmasi</span></a>
                    <ul class="children">
                        <li><a href="T_lihatpermintaan.php">Lihat Permintaan</a></li>
                        <li><a href="T_permintaan.php">Catat Permintaan</a></li>
                    </ul>
                </li>
                <li class=""><a href="supplier.php"><i class="fa fa-suitcase"></i> <span>Supplier</span></a></li>
                <li class="parent"><a href=""><i class="glyphicon glyphicon-exclamation-sign"></i> <span>Laporan</span></a>
                    <ul class="children">
                        <li><a href="T_lappengadaan.php">Laporan Pengadaan</a></li>
                        <li><a href="T_lappermintaan.php">Laporan Permintaan</a></li>
                    </ul>
                </li>
            </ul>

        </div><!-- leftpanel -->