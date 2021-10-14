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
if (isset($_GET["generate"])) { generate($conn); }

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

    $m = $_GET["m"];
    $y = $_GET["y"];

    if ($m < 10) {
        $m = "0".$m;
    }

    $where = $y."-".$m."-01";


    $query = "SELECT a.*, b.* FROM list_pengadaan a LEFT JOIN barang_gu b ON a.idbaranggu = b.id WHERE a.tanggal = '$where'";

    $get = mysqli_query($conn,$query) or die(mysqli_error($conn));

    $data = array();

    if ($get->num_rows > 0) {
        while ($r = $get->fetch_assoc()) {
            array_push($data, $r);
        }

        $response["data"] = $data;
    } else {
        $response["status"] = 0;
    }


    echo json_encode($response);
}

function generate($conn) {

    //Get Date Range
    $y = $_GET['tahun'];
    $m = $_GET['bulan'];
    $currentDate = $y . "-" . $m . "-01";


    if ($m < 10) {
        $currentDate = $y . "-0" . $m . "-01";
    }

    $dateEnd = $y . "-" . $m . "-31";

    //Get StartDate
    $dateToDiff = "1" . "-" . $m . "-" . $y;
    $formatDateToDiff = "1" . "-" . $m . "-" . $y;
    $dateToDiff = DateTime::createFromFormat('d-m-Y', $formatDateToDiff)->format('Y-m-d');
    $dateStart = date('Y-m-d', strtotime('-3 months', strtotime($dateToDiff)));

    //Get End Date
    $dateToDiff = "1" . "-" . $m . "-" . $y;
    $formatDateToDiff = "1" . "-" . $m . "-" . $y;
    $dateToDiff = DateTime::createFromFormat('d-m-Y', $formatDateToDiff)->format('Y-m-d');
    $dateEnd = date('Y-m', strtotime('-1 months', strtotime($dateToDiff)));
    $dateEnd = $dateEnd . "-31";

    //Start transaction
    $conn->begin_transaction();

    # STEP 0 : GET ALL BAHAN
    $sqlBahan = "SELECT id FROM `barang_gu`";
    $getBahan = mysqli_query($conn,$sqlBahan) or die(showError($conn, "Error get Bahan"));
    while ($r = $getBahan->fetch_array()) {
        $id_bahan = $r["id"];
        # STEP 1.1 : Generate rata2 kebutuhan bedasarkan bulan
        $sqlGetRata = 'SELECT AVG(jumlah_kgu) as rata FROM `barang_keluargu` WHERE (tgl_kgu BETWEEN "' . $dateStart . '" AND "' . $dateEnd . '") AND idbaranggu = '.$id_bahan;

        $getRata = mysqli_query($conn,$sqlGetRata) or die(showError($conn, "Error get rata"));
        while ($r = $getRata->fetch_array()) {
            $avg = $r["rata"];
            # Insert to table Peramalan
            $sqlInsertPermalan = 'INSERT INTO list_pengadaan(idbaranggu, peramalan, tanggal) VALUES("' . $id_bahan . '", "' . $avg . '", "' . $currentDate . '")';
            $insertPeramalan = mysqli_query($conn,$sqlInsertPermalan) or die(showError($conn, "Error insert peramalan"));
        }
    }   

    $conn->commit();
    $res["msg"] = "Generate berhasil";
    echo json_encode($res);
}

function showError($mysql, $res, $msg = "")
{
    $mysql->rollback();
    $res["error"] = "1";
    $res["msg"] = $msg;
    echo json_encode($res);
    return;
}