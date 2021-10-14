<?php include 'header.php'; ?>
<div class="mainpanel">
    <div class="pageheader">
        <div class="media">
            <div class="pageicon pull-left">
                <i class="fa fa-th-list"></i>
            </div>
            <div class="media-body">
                <ul class="breadcrumb">
                    <li><a href=""><i class="glyphicon glyphicon-home"></i></a></li>
                    <li><a href="">Kasir</a></li>
                </ul>
                <h4>Kasir</h4>
            </div>
        </div><!-- media -->
    </div><!-- pageheader -->

    <div class="contentpanel">
        <div class="panel panel-success-head">
            <div class="panel-heading">
                <h4 class="panel-title">Detail Transaksi</h4>
                <br>
                <div class="row">
                    <div class="col-md-3">
                        <form id="form" method="post">
                            <div class="form-group">
                                <label for="admin" style="color: white;">Admin</label>
                                <input class="form-control" id="admin" name="admin" value="<?= $_SESSION['nama'] ?>" disabled>
                            </div>

                            <div class="form-group">
                                <label for="kode_buku" style="color: white;">Kode Obat/Alat Medis</label>
                                <div class="input-group">
                                    <input type="hidden" class="form-control" id="id_buku" name="id_buku">
                                    <input type="text" class="form-control" id="kode_buku" name="kode_buku" placeholder="Masukkan kode obat">
                                    <span class="input-group-btn">
                                        <button id="cari_kode" class="btn btn-default" type="button">Cari</button>
                                    </span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jumlah_stok" style="color: white;">Jumlah</label>
                                        <input class="form-control" id="jumlah_stok" name="jumlah_stok" placeholder="0">
                                    </div>
                                </div>
                            </div>

                            <div>
                                <button type="submit" class="btn btn-default" style="float: left;">Tambah</button>
                                <div style="text-align: right;padding-top: 10px" id="status"></div>
                            </div>

                        </form>
                    </div>

                    <div class="col-md-3" id="detail_buku" style="visibility: hidden;">
                        <div class="form-group">
                            <label for="judul_buku" style="color: white;">Nama Obat/Alat Medis</label>
                            <input class="form-control" id="judul_buku" name="judul_buku" placeholder="Judul Buku" disabled>
                        </div>

                        <div class="form-group">
                            <label for="sisa_stok" style="color: white;">Sisa Stok</label>
                            <input class="form-control" id="sisa_stok" name="sisa_stok" placeholder="Sisa Stok" disabled>
                        </div>

                        <div class="form-group">
                            <label for="harga_jual" style="color: white;">Harga</label>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Rp</span>
                                <input type="text" class="form-control" placeholder="0" id="harga_jual" name="harga_jual" aria-describedby="basic-addon1" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- panel-heading -->
            <div class="panel-body">
                <table id="tableCart" class="table table-striped table-bordered responsive">
                    <thead class="">
                    <tr>
                        <th style="text-align: center; width: 40px">#</th>
                        <th style="text-align: center">Nama Obat/Alat Medis</th>
                        <th style="text-align: center">Kode</th>
                        <th style="text-align: center">jumlah</th>
                        <th style="text-align: center">Harga Satuan</th>
                        <th style="text-align: center">Total Harga</th>
                        <th style="text-align: center">Aksi</th>
                    </tr>
                    </thead>

                    <tbody id="tableBody">

                    </tbody>
                </table>

                <div class="row">
                    <div class="col-md-6"><b>Jumlah Total</b></div>
                    <div class="col-md-6" style="text-align: right"><b id="jumlah_total">Rp 0</b></div>
                </div>

                <div class="row">
                    <div class="col-md-6"><b>Harga Total</b></div>
                    <div class="col-md-6" style="text-align: right"><b id="harga_total">Rp 0</b></div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <br>
                        <button id="btn-modal" class="btn btn-primary pull-right">BAYAR</button>
                        <button onclick="clearKeranjang()" class="btn btn-default pull-right" style="margin-right: 10px;">Clear</button>
                    </div>
                </div>
            </div>
        </div><!-- panel -->
    </div><!-- contentpanel -->
</div><!-- mainpanel -->

<!--//BAYAR MODAL-->
<div class="modal fade" id="bayarModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="overflow: hidden;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="titleModal">Pembayaran</h4>
            </div>
            <form id="form-bayar">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="instalasi">instalasi</label>
                        <select name="instalasi" class="form-control">    
                            <option value="" selected>Pilih Instalasi</option>
                            <option value="Rawat Inap" >Rawat Inap</option>
                            <option value="Rawat Jalan" >Rawat Jalan</option>
                            <option value="Gawat Darurat" >Gawat Darurat</option>
                            <option value="Umum" >Umum</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tunai">Tunai</label>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">Rp</span>
                            <input type="text" class="form-control" placeholder="0" id="tunai" name="tunai" aria-describedby="basic-addon1">
                        </div>
                    </div>

                    <input type="hidden" class="form-control" id="total_harga" name="total_harga">
                    <input type="hidden" class="form-control" id="total_stok" name="total_stok">

                    <div class="form-group">
                        <label for="kembalian">Kembalian</label>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">Rp</span>
                            <input type="text" class="form-control" placeholder="0" id="kembalian" name="kembalian" aria-describedby="basic-addon1" readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-8">
                            <div id="status" style="padding-top: 10px;text-align: left"></div>
                        </div>
                        <div class="col-md-4">
                            <button id="btn-modal" type="submit" class="btn btn-primary">Bayar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "footer.php" ?>

<script>
    var json= "";
    var gharga_total = 0;
    var stok = 0;

    loadDataKeranjang();
    function loadDataKeranjang() {
        var jumlah_total = 0;
        var harga_total = 0;
        $.ajax({
            url: "action/kasir_aksi.php?get_keranjang",
            data: $("#form").serialize(),
            method: "POST",
            dataType: "JSON",
            beforeSend: function (e) {
                $("#status").html("Mohon menunggu...");
                $("#tableBody").html("<tr>" +
                    "<td colspan='7' style='text-align: center'>Loading...</td>" +
                    "</tr>");
            },
            success: function (v) {
                var a = "";

                if (v.status == 1) {
                    json = v.data

                    var h = 0;

                    for (i=0; i < v.data.length; i++) {
                        var diskon = json[i].diskon / 100;
                        var sub_harga = json[i].hargagu * json[i].jumlah;
                        var total_harga = sub_harga - (sub_harga*diskon);
                        harga_total = harga_total + sub_harga
                        jumlah_total = jumlah_total + parseInt(json[i].jumlah);
                        gharga_total = gharga_total+total_harga;
                        a += "<tr>" +
                            "<td>"+(i+1)+"</td>" +
                            "<td>"+json[i].nama_baranggu+"</td>" +
                            "<td>"+json[i].kd_baranggu+"</td>" +
                            "<td>"+json[i].jumlah+"</td>" +
                            "<td>"+json[i].hargagu+"</td>" +
                            "<td>"+total_harga+"</td>" +
                            "<td><center><button onclick='hapusPelanggan("+i+")' title='Hapus halaman' class='btn btn-danger btn-sm'><i class='fa fa-trash-o'></i></button></td>" +
                            "</tr>"
                    }

                    $("#tableBody").html(a);
                    $("#jumlah_total").html("x"+jumlah_total);
                    $("#harga_total").html("Rp"+gharga_total);

                    $("#total_harga").val(gharga_total);
                    $("#total_stok").val(jumlah_total);

                    $("#status").html("");
                    $("#btn-modal").attr("disabled", false);
                } else {
                    $("#btn-modal").attr("disabled", true);

                    $("#tableBody").html("<tr>" +
                        "<td colspan='8' style='text-align: center'>Belum ada transaksi</td>" +
                        "</tr>");

                    $("#jumlah_total").html("x0");
                    $("#harga_total").html("Rp 0");
                    $("#status").html("");
                }
            }
        })
    }

    $("#cari_kode").on("click",function () {
        $.ajax({
            url: "action/kasir_aksi.php?cari",
            data: { "kode_buku" : $("#kode_buku").val()},
            method: "POST",
            dataType: "JSON",
            beforeSend: function (e) {
                $("#status").html("Sedang mencari...")
            },
            success: function (v) {
                if (v.status == 1) {
                    stok = v.data.stok;
                    $("#detail_buku").css("visibility", "visible");
                    $("#id_buku").val(v.data.id);
                    $("#judul_buku").val(v.data.nama_baranggu);
                    $("#sisa_stok").val(v.data.stok);
                    $("#harga_jual").val(v.data.hargagu);
                } else {
                    $("#detail_buku").css("visibility", "hidden");
                    $("#id_buku").val("");
                    $("#judul_buku").val("");
                    $("#sisa_stok").val("");
                    $("#harga_jual").val("");
                }

                $("#status").html(v.msg)
            }
        })
    })

    $("#form").on("submit", function (e) {
        e.preventDefault();

        if ($("#id_buku").val() == 0) {
            $("#status").html("Harap memilih buku")
            return false;
        }

        if ($("#jumlah_stok").val() == 0) {
            $("#status").html("Stok harus diisi")
            return false;
        }

        if ( parseInt($("#jumlah_stok").val()) > parseInt(stok)) {
            console.log($("#jumlah_stok").val());
            console.log(stok);
            $("#status").html("Stok tidak mencukupi")
            return false;
        }

        $.ajax({
            url: "action/kasir_aksi.php?tambah_keranjang",
            data: $("#form").serialize(),
            method: "POST",
            dataType: "JSON",
            beforeSend: function (e) {
                $("#status").html("Mohon menunggu...");
            },
            success: function (v) {
                json = v.data;
                $("#status").html("Berhasil menambah barang");
                loadDataKeranjang();
            }
        })
    })

    function clearKeranjang() {
        $.ajax({
            url: "action/kasir_aksi.php?clear_keranjang",
            data: $("#form").serialize(),
            method: "POST",
            dataType: "JSON",
            beforeSend: function (e) {
                $("#status").html("Mohon menunggu...");
            },
            success: function (v) {
                loadDataKeranjang()
                $("#status").html("");

            }
        })
    }

    $("#btn-modal").on("click",function () {
        $("#bayarModal").modal("show");
        $("#btn-bayar").html("Bayar");
        $("#btn-bayar").attr("disabled", false);
    })
    
    $("#tunai").on("keyup",function () {
        if ($("#tunai").val().length > 3) {
            $("#kembalian").val(parseInt($("#tunai").val()) - parseInt(gharga_total));
        }
    })
    
    $("#form-bayar").on("submit", function (e) {
        e.preventDefault();
        $.ajax({
            url: "action/kasir_aksi.php?bayar",
            data: $("#form-bayar").serialize(),
            method: "POST",
            dataType: "JSON",
            beforeSend: function (e) {
                $("#btn-bayar").html("Mohon menunggu");
                $("#btn-bayar").attr("disabled", true);
            },
            success: function (v) {
                if (v.status == 1) {
                    $("#bayarModal").modal("hide");
                    $("#status").html(v.msg);
                    clearKeranjang();
                    gharga_total = 0;
                    stok = 0;
                    window.open('invoice.php?id='+v.id_order,'_blank');
                }
            }
        })
    })

</script>
