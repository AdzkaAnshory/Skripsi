<?php
/**
 * Created by PhpStorm.
 * User: radhs
 * Date: 9/8/2018
 * Time: 2:23 PM
 */

session_start();
$id_admin = $_SESSION["id"];
include "../net/koneksi.php";

if (isset($_GET["load"])) { loadData($conn); }
if (isset($_GET["load_sales_gudang"])) { load_sales_gudang($conn); }
if (isset($_GET["tambah"])) { tambah($conn, $id_admin); }
if (isset($_GET["ubah"])) { ubah($conn); }
if (isset($_GET["hapus"])) { hapus($conn); }

function tambah($conn, $id_admin) {
    $response["status"] = 1;

    $kode = $_POST["kd_baranggu"];
    $nama = $_POST["nama_baranggu"];
    $stok = $_POST["stok"];
    $harga = $_POST['harga'];

    $query_insert = "INSERT INTO tb_barang (kd_baranggu, nama_baranggu, stok, harga, add_by) VALUES 
                    ('$kode', '$nama', '$stok', '$harga', '$id_admin')";
    $insert = mysqli_query($conn,$query_insert) or die(mysqli_error($conn));

    if($insert) {
        loadData($conn);
    } else {
        $response["status"] = 0;
        $response["msg"] = "Gagal menambah barang";

        echo json_encode($response);
    }
}

function ubah($conn) {
    $response["status"] = 1;

    $id = $_POST["id"];
    $kode = $_POST["kd_baranggu"];
    $nama = $_POST["nama_baranggu"];
    $stok = $_POST["stok"];
    $harga = $_POST['harga'];

    $query = "UPDATE tb_barang SET kd_baranggu='$kode', nama_baranggu='$nama', stok='$stok', harga='$harga' WHERE id = $id";
    $update = mysqli_query($conn,$query) or die(mysqli_error($conn));

    if($update) {
        loadData($conn);
    } else {
        $response["status"] = 0;
        $response["msg"] = "Gagal mengubah barang";

        echo json_encode($response);
    }
}

function hapus($conn) {
    $response["status"] = 1;

    $id = $_POST["id"];

    $query = "UPDATE tb_barang SET deleted=0 WHERE id = $id";
    $update = mysqli_query($conn,$query) or die(mysqli_error($conn));

    if($update) {
        loadData($conn);
    } else {
        $response["status"] = 0;
        $response["msg"] = "Gagal menambah barang";

        echo json_encode($response);
    }
}

function loadData($conn) {
    $response["status"] = 1;


    $query = "SELECT a.*, IFNULL(b.stok,0) as stok FROM barang_gu a LEFT JOIN barang_gf b ON b.idbaranggu = a.id WHERE b.stok < 5 OR b.stok IS NULL";

    $get = mysqli_query($conn,$query) or die(mysqli_error($conn));

    $data = array();

    if ($get->num_rows > 0) {
        while ($r = $get->fetch_assoc()) {
            array_push($data, $r);
        }

        $response["data"] = $data;

        echo json_encode($response);
    } else {
        $response["status"] = 0;
    }

}