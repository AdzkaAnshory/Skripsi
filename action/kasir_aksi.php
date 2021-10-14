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

if (isset($_GET["cari"])) { cariBuku($conn); }
if (isset($_GET["tambah_keranjang"])) { tambah_keranjang($conn, $id_admin); }
if (isset($_GET["clear_keranjang"])) { clear_keranjang($conn, $id_admin); }
if (isset($_GET["get_keranjang"])) { loadKeranjang($conn, $id_admin); }
if (isset($_GET["hapus"])) { hapus($conn, $id_admin); }
if (isset($_GET["bayar"])) { bayar($conn, $id_admin); }

function cariBuku($conn) {
    $response["status"] = 1;

    $kode = $_POST['kode_buku'];

    if ($kode != "") {
        $query = "SELECT barang_gu.*, IFNULL(barang_gf.stok,0) as stok FROM barang_gu LEFT JOIN barang_gf ON barang_gu.id = barang_gf.idbaranggu WHERE kd_baranggu = '$kode'";
        $get = mysqli_query($conn,$query) or die(mysqli_error($conn));

        if(mysqli_num_rows($get) > 0) {
            $data = mysqli_fetch_object($get);

            $response["msg"] = "Data ditemukan";
            $response["data"] = $data;

            echo json_encode($response);
        } else {
            $response["status"] = 0;
            $response["msg"] = "Data tidak ditemukan";

            echo json_encode($response);
        }
    }  else {
        $response["status"] = 0;
        $response["msg"] = "Kode buku harus diisi";

        echo json_encode($response);
    }
}

function hapus($conn, $id_admin) {
    $response["status"] = 1;

    $id = $_POST["id"];

    $query = "DELETE FROM keranjang WHERE id = $id";
    $hapus = mysqli_query($conn,$query);

    if($hapus) {
        loadKeranjang($conn, $id_admin);
    } else {
        $response["status"] = 0;
        $response["msg"] = "Gagal menghapus item";

        echo json_encode($response);
    }
}

function clear_keranjang($conn, $id_admin) {
    mysqli_query($conn, "TRUNCATE TABLE keranjang");
    loadKeranjang($conn, $id_admin);
}

function tambah_keranjang($conn, $id_admin) {
    $response["status"] = 1;

    $id_buku = $_POST["id_buku"];
    $diskon = isset($_POST["diskon"]) ? $_POST["diskon"] : 0;
    $stok = $_POST["jumlah_stok"];
    $kode = $_POST['kode_buku'];

    if ($kode != "") {
        $query_cek = mysqli_query($conn, "SELECT * FROM keranjang WHERE id_admin = '$id_admin' AND id_barang = '$id_buku'");
        if ($query_cek->num_rows > 0) {
            $query_update = mysqli_query($conn, "UPDATE keranjang SET jumlah=jumlah+$stok, diskon='$diskon' WHERE id_admin = '$id_admin' AND id_barang = '$id_buku'");
            if ($query_update) {

                loadKeranjang($conn, $id_admin);
            }
        } else {
            $query_insert = "INSERT INTO keranjang (id_admin, id_barang, diskon, jumlah) VALUES ('$id_admin', '$id_buku', '$diskon', '$stok')";
            $insert = mysqli_query($conn,$query_insert) or die(mysqli_error($conn));

            if($insert) {
                loadKeranjang($conn, $id_admin);
            } else {
                $response["status"] = 0;
                $response["msg"] = "Gagal menambah barang";

                echo json_encode($response);
            }
        }

    } else {
        $response["status"] = 0;
        $response["msg"] = "Kode buku harus diisi";

        echo json_encode($response);
    }
}

function loadKeranjang($conn, $id_admin) {
    $response["status"] = 1;

    $query_buku = "SELECT a.*, b.kd_baranggu, b.nama_baranggu, b.hargagu FROM keranjang a LEFT JOIN barang_gu b ON a.id_barang = b.id WHERE a.id_admin = '$id_admin'";
    $get_buku = mysqli_query($conn,$query_buku);

    $lits = array();

    if ($get_buku->num_rows > 0) {
        while ($r = $get_buku->fetch_assoc()) {
            array_push($lits, $r);
        }

        $response["data"] = $lits;
        $response["msg"] = "Berhasil menambahkan barang";

        echo json_encode($response);
    } else {
        $response["status"] = 0;
        $response["msg"] = "Keranjang Kosong";

        echo json_encode($response);
    }
}

function bayar($conn, $id_admin) {
    $response["status"] = 1;

    $date = new DateTime('now');
    $inv = "INV-".$date->format('ymdHiss');

    $instalasi = $_POST["instalasi"];
    $tunai = $_POST["tunai"];
    $kembalian = $_POST["kembalian"];
    $jumlah_harga= $_POST["total_harga"];
    $jumlah_total = $_POST["total_stok"];

    //INSERT TB ORDER
    $query_insert_oder = "INSERT INTO tb_penjualan (invoice, total, harga, instalasi, tunai, kembalian) 
                      VALUES ('$inv', '$jumlah_total', '$jumlah_harga', '$instalasi', '$tunai', '$kembalian')";

    $insert_order = mysqli_query($conn,$query_insert_oder) or die(mysqli_error($conn));

    if ($insert_order) {
        $last_order_id = $conn->insert_id;

        //Move from cart to order table
        $query_cart = "SELECT a.*, b.id as id_barang, b.nama_baranggu, b.hargagu FROM keranjang a LEFT JOIN barang_gu b ON a.id_barang = b.id WHERE a.id_admin = '$id_admin'";
        $get_cart = mysqli_query($conn,$query_cart);

        if ($get_cart->num_rows > 0) {
            while($row = $get_cart->fetch_assoc()) {
                $diskon = $row["diskon"] / 100;
                $sub_harga = $row["hargagu"] * $row["jumlah"];
                $total_harga = $sub_harga - ($sub_harga*$diskon);

                $id_barang = $row["id_barang"];
                $diskon2 = $row["diskon"];
                $jumlah_total = $row["jumlah"];
                $harga = $row["hargagu"];

                $query_move_tb = "INSERT INTO tb_penjualan_detail (id_penjualan, id_barang, jumlah, harga, diskon, total) 
                      VALUES ('$last_order_id', '$id_barang', '$jumlah_total', '$harga', '$diskon2', '$total_harga')";

                $query_kurang_stok = "UPDATE barang_gf SET stok = stok-$jumlah_total WHERE idbaranggu =$id_barang";

                $insert_move = mysqli_query($conn,$query_move_tb) or die(mysqli_error($conn));
                $update_stok = mysqli_query($conn,$query_kurang_stok) or die(mysqli_error($conn));
            }
        }

        $response["id_order"] = $last_order_id;
        $response["msg"] = "Pembayaran Sukses";

        echo json_encode($response);
    }


}