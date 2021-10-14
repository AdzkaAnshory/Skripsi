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
                    <li><a href="">Data Obat dan Alat Medis</a></li>
                </ul>
                <h4>Farmasi</h4>
            </div>
        </div><!-- media -->
    </div><!-- pageheader -->

    <div class="contentpanel">
        <div class="row row-stat">
            <div class="col-md-12">
                <table id="TableMain" class="table table-striped">
                    <thead>
                    <tr>
                        <th width="50px">#</th>
                        <th width="120px">Kode</th>
                        <th width="150px">Nama</th>
                        <th>Harga</th>
                        <th>Stok</th>
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
                        <label for="kode">Stok</label>
                        <input type="hidden" class="form-control" id="id" name="id">
                        <input class="form-control" id="stok" name="stok" placeholder="Masukkan jumlah stok">
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
    var jsonBuku ="";
    var jsonSales ="";

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

    loadData();
    loadSalesDanGudang();

    function loadData() {
        dataTable.clear().draw();
        $.ajax({
            url: "action/databarang.php?load",
            data: $("#form").serialize(),
            method: "POST",
            dataType: "JSON",
            beforeSend: function (e) {
                $("#status").html("Mohon menunggu...");
            },
            success: function (v) {
                jsonBuku = v.data;
                for (i=0; i < v.data.length; i++) {
                    dataTable.row.add( [
                        "",
                        jsonBuku[i].kd_baranggu,
                        jsonBuku[i].nama_baranggu,
                        jsonBuku[i].hargagu,
                        jsonBuku[i].stok,
                        ' <button onclick="ubahBuku('+i+')" class="btn btn-success btn-sm" style="margin: 2px"><i class="fa fa-plus"></i></button>'+
                        ' <button onclick="hapusBuku('+i+')" title="Hapus halaman" class="btn btn-danger btn-sm" style="margin: 2px"><i class="fa fa-trash-o"></i></button>'
                    ] ).draw( false );
                }
            }
        })
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

    function ubahBuku(i) {
        $("#bukuModal").modal("show");
        $("#titleModal").html("Tambah Stok");
        $("#id").val(jsonBuku[i].id);
        $("#stok").val("");

        $("#status").html("");
        $("#btn-modal").attr("disabled", false);
        $("#btn-modal").html("Tambah");
    }

    $("#form").on("submit", function (e) {
        e.preventDefault();
        var url = "action/obat.php?tambahstok";
        var msg = "Stok Berhasil di Tambah";
        
        $.ajax({
            url: url,
            data: $("#form").serialize(),
            method: "POST",
            dataType: "JSON",
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
