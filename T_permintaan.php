<?php include 'T_header.php'; ?>
<div class="mainpanel">
    <div class="pageheader">
        <div class="media">
            <div class="pageicon pull-left">
                <i class="fa fa-th-list"></i>
            </div>
            <div class="media-body">
                <ul class="breadcrumb">
                    <li><a href=""><i class="glyphicon glyphicon-home"></i></a></li>
                    <li><a href="">Data Obat dan Alat Medis</a></li>
                </ul>
                <h4>Farmasi</h4>
            </div>
        </div><!-- media -->
    </div><!-- pageheader -->

    <div class="contentpanel">
        <div class="row row-stat">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-10">
        <!-- Button date Tab -->
        <div class="btn-group btn-group-sm" role="group">
            <button type="button" class="btn btn-faded-success" id="mont1" onclick="loadData('1', this)">Jan
            </button>
            <button type="button" class="btn btn-faded-success" id="mont2" onclick="loadData('2', this)">Feb
            </button>
            <button type="button" class="btn btn-faded-success" id="mont3" onclick="loadData('3', this)">Mar
            </button>
            <button type="button" class="btn btn-faded-success" id="mont4" onclick="loadData('4', this)">Apr
            </button>
            <button type="button" class="btn btn-faded-success" id="mont5" onclick="loadData('5', this)">May
            </button>
            <button type="button" class="btn btn-faded-success" id="mont6" onclick="loadData('6', this)">Jun
            </button>
            <button type="button" class="btn btn-faded-success" id="mont7" onclick="loadData('7', this)">Jul
            </button>
            <button type="button" class="btn btn-faded-success" id="mont8" onclick="loadData('8', this)">Agu
            </button>
            <button type="button" class="btn btn-faded-success" id="mont9" onclick="loadData('9', this)">Sep
            </button>
            <button type="button" class="btn btn-faded-success" id="mont10" onclick="loadData('10', this)">Okt
            </button>
            <button type="button" class="btn btn-faded-success" id="mont11" onclick="loadData('11', this)">Nov
            </button>
            <button type="button" class="btn btn-faded-success" id="mont12" onclick="loadData('12', this)">Dec
            </button>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <select class="form-control" id="year" name="year">
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020" selected>2020</option>
            </select>
        </div>
    </div>
                </div>
            </div>
            <div class="col-md-4">
                <button id="addBuku" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Tambah</button>
                <br>
                <br>
                <br>
            </div>
            <div class="col-md-12">
                <table id="TableMain" class="table table-striped">
                    <thead>
                    <tr>
                        <th width="50px">#</th>
                        <th width="120px">Kode</th>
                        <th width="150px">Nama</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total harga</th>
                        <th>Aksi</th>
                    </tr>
                    <?php

                    ?>
                    </thead>
                    <tbody id="bodytable">

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div><!-- mainpanel -->

<!--//ADD MODAL-->
<div class="modal fade" id="bukuModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="overflow: hidden;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="titleModal"></h4>
            </div>
            <div class="modal-body">
                <form id="form" method="post">
                    <div class="form-group">
                        <label for="kode">Kode</label>
                        <input type="hidden" class="form-control" id="id" name="id">
                        <input class="form-control" id="kd_baranggu" name="kd_baranggu" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input class="form-control" id="nama_baranggu" name="nama_baranggu" placeholder="Nama Obat/Alat Medis">
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="text" class="form-control" id="stok" name="stok" placeholder="Stok">
                    </div>
                    <div class="form-group">
                        <label for="harga_beli">Harga</label>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">Rp</span>
                            <input type="text" class="form-control" placeholder="0" id="harga" name="harga" aria-describedby="basic-addon1">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-8">
                        <div id="status" style="padding-top: 10px;text-align: left"></div>
                    </div>
                    <div class="col-md-4">
                        <button id="btn-modal" type="submit" class="btn btn-primary"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php" ?>

<script>
    var jsonData ="";
    var jsonSales ="";

    var selectedMonth = "";
    var dataTable = $("#TableMain").DataTable({
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": "no-sort"
        } ],
        // "order": [[ 1, 'asc' ]]
    });
    dataTable.on( 'order.dt search.dt', function () {
        dataTable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = "<span style='display:block' class='text-center'>"+(i+1)+"</span>";
        } );
    } ).draw();

    function loadData(m="", f=null) {
        removeSelected();
        $(f).addClass("active");
        selectedMonth = m;
        var y = $("#year").val();
        var url = "action/keluar.php?load&m=" + m + "&y=" + y;

        dataTable.clear().draw();
        $.ajax({
            url: url,
            data: $("#form").serialize(),
            method: "POST",
            dataType: "JSON",
            beforeSend: function (e) {
                $("#status").html("Mohon menunggu...");
            },
            success: function (v) {
                jsonData = v.data;
                for (i=0; i < jsonData.length; i++) {
                    dataTable.row.add( [
                        "",
                        jsonData[i].kd_baranggu,
                        jsonData[i].nama_baranggu,
                        jsonData[i].hargagu,
                        jsonData[i].jumlah_kgu,
                        jsonData[i].total,
                        ' <button onclick="ubahBuku('+i+')" class="btn btn-success btn-sm" style="margin: 2px"><i class="fa fa-pencil"></i></button>'+
                        ' <button onclick="hapusBuku('+i+')" title="Hapus halaman" class="btn btn-danger btn-sm" style="margin: 2px"><i class="fa fa-trash-o"></i></button>'
                    ] ).draw( false );
                }
            }
        })
    }

    function removeSelected() {
        $('#mont1').removeClass("active");
        $('#mont2').removeClass("active");
        $('#mont3').removeClass("active");
        $('#mont4').removeClass("active");
        $('#mont5').removeClass("active");
        $('#mont6').removeClass("active");
        $('#mont7').removeClass("active");
        $('#mont8').removeClass("active");
        $('#mont9').removeClass("active");
        $('#mont10').removeClass("active");
        $('#mont11').removeClass("active");
        $('#mont12').removeClass("active");
    }

    function loadSalesDanGudang() {
        $.ajax({
            url: "action/buku_aksi.php?load_sales_gudang",
            data: $("#form").serialize(),
            method: "POST",
            dataType: "JSON",
            beforeSend: function (e) {
                $("#status").html("Mohon menunggu...");
            },
            success: function (json) {
                var sales = json.sales;
                var gudang = json.gudang;

                //LOAD SALES
                var s = '<option value="" selected>Pilih Sales</option>';
                for (i=0; i < sales.length; i++) {
                    s += '<option value="'+sales[i].id+'">'+sales[i].nama+'</option>'
                }
                $("#sales").html(s);

                //LOAD GUDANG
                var g = '<option value="" selected>Pilih Gudang</option>';
                for (j=0; j < gudang.length; j++) {
                    g += '<option value="'+gudang[j].id+'">'+gudang[j].nama+'</option>'
                }
                $("#gudang").html(g);
            }
        })
    }

    $("#addBuku").on("click", function () {
        addBuku()
    })

    function addBuku() {
        $("#bukuModal").modal("show");
        $("#titleModal").html("Tambah Buku");
        $("#id").val("");
        $("#nama").val("");
        $("#email").val("");
        $("#stok").val("");
        $("#hp").val("");
        $("#alamat").val("");
        $("#status").html("");
        $("#btn-modal").attr("disabled", false);
        $("#btn-modal").html("Tambah");
    }

    function ubahBuku(i) {
        $("#bukuModal").modal("show");
        $("#titleModal").html("Ubah Buku");
        $("#id").val(jsonBuku[i].id);
        $("#kode").val(jsonBuku[i].kode);
        $("#nama").val(jsonBuku[i].judul);
        $("#penyusun").val(jsonBuku[i].penyusun);
        $("#kategori").val(jsonBuku[i].kategori);
        $("#stok").val(jsonBuku[i].stok);
        $("#harga_jual").val(jsonBuku[i].harga_jual);
        $("#harga_beli").val(jsonBuku[i].harga_beli);
        $("#sales").val(jsonBuku[i].id_sales);
        $("#gudang").val(jsonBuku[i].id_gudang);

        $("#status").html("");
        $("#btn-modal").attr("disabled", false);
        $("#btn-modal").html("Ubah");
    }

    $("#form").on("submit", function (e) {
        e.preventDefault();
        var url = "action/buku_aksi.php?tambah";
        var msg = "Buku Berhasil di Tambah";


        if ($("#id").val() != "") {
            url = "action/buku_aksi.php?ubah";
            msg = "Berhasil mengubah data Buku";
        }

        $.ajax({
            url: url,
            data: $("#form").serialize(),
            method: "POST",
            dataType: "JSON",
            beforeSend: function (e) {
                $("#btn-modal").attr("disabled", true);
                $("#status").html("Mohon menunggu...");
            },
            success: function (v) {
                if (v.status == 1) {
                    $("#bukuModal").modal("hide");

                    $.gritter.add({
                        title: 'Success!',
                        text: msg,
                        class_name: 'growl-success',
                        image: 'images/screen.png',
                        sticky: false,
                        time: ''
                    });

                    jsonBuku = v.data;
                    loadData()
                } else {

                }
            }
        })
    })

    function hapusBuku(i) {
        var id = jsonBuku[i].id;
        var url = "action/buku_aksi.php?hapus";

        console.log(jsonBuku[i]);

        var confrim = confirm(jsonBuku[i].judul+", akan dihapus ?");

        if (confrim) {
            $.ajax({
                url: url,
                data: { "id" : id },
                method: "POST",
                dataType: "JSON",
                beforeSend: function (e) {
                    $("#btn-modal").attr("disabled", true);
                    $("#status").html("Mohon menunggu...");
                },
                success: function (v) {
                    if (v.status == 1) {
                        $("#bukuModal").modal("hide");

                        $.gritter.add({
                            title: 'Success!',
                            text: "Berhasil menghapus buku",
                            class_name: 'growl-success',
                            image: 'images/screen.png',
                            sticky: false,
                            time: ''
                        });

                        jsonBuku = v.data;
                        loadData()
                    } else {

                    }
                }
            })
        }
    }


</script>
