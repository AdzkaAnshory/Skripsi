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
                    <li><a href="">Data Peralaman</a></li>
                </ul>
                <h4>Data Peralaman</h4>
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
                <button id="generate_btn" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Generate</button>
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
                        <th>Jumlah</th>
                    </tr>
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
                        <label for="kode">Kode Buku</label>
                        <input type="hidden" class="form-control" id="id" name="id">
                        <input class="form-control" id="kode" name="kode" placeholder="ISBN 978-602-8519-93-9">
                    </div>
                    <div class="form-group">
                        <label for="nama">Judul</label>
                        <input class="form-control" id="nama" name="nama" placeholder="Nama Buku">
                    </div>
                    <div class="form-group">
                        <label for="sales">Distributor</label>
                        <select class="form-control" id="sales" name="sales">
                            <option value="" selected>Pilih Sales</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="gudang">Gudang</label>
                        <select class="form-control" id="gudang" name="gudang">
                            <option value="" selected>Pilih Gudang</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="penyusun">Penyusun</label>
                        <input type="text" class="form-control" id="penyusun" name="penyusun" placeholder="Penyusun">
                    </div>
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <input type="text" class="form-control" id="kategori" name="kategori" placeholder="Kategori">
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="text" class="form-control" id="stok" name="stok" placeholder="Stok">
                    </div>
                    <div class="form-group">
                        <label for="harga_beli">Harga Beli</label>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">Rp</span>
                            <input type="text" class="form-control" placeholder="0" id="harga_beli" name="harga_beli" aria-describedby="basic-addon1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="harga_jual">Harga Jual</label>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">Rp</span>
                            <input type="text" class="form-control" placeholder="0" id="harga_jual" name="harga_jual" aria-describedby="basic-addon1">
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


    var jsonData = "";
    var selectedMonth = "";
    $('#generate_btn').hide();

    function loadData(m="", f=null) {
        removeSelected();
        $(f).addClass("active");
        selectedMonth = m;
        var y = $("#year").val();

        $.ajax({
            url: 'action/peramalan.php?load&m=' + m + '&y=' + y,
            data: $("#form").serialize(),
            method: "POST",
            dataType: "JSON",
            beforeSend: function (e) {
                $("#status").html("Mohon menunggu...");
            },
            success: function (v) {
                jsonData = v.data;
                if (jsonData == null) {
                    $('#generate_btn').show();
                    dataTable.clear().draw();
                } else {
                    for (i=0; i < jsonData.length; i++) {
                    dataTable.row.add( [
                        "",
                        jsonData[i].kd_baranggu,
                        jsonData[i].nama_baranggu,
                        jsonData[i].peramalan
                    ] ).draw( false );
                    }
                }
            }
        })
    }

    $("#generate_btn").on("click", function(){
        //  let dialog = bootbox.dialog({
        //     message: `<div class="d-flex align-items-center">
        //               <div class="spinner-border spinner-border-sm mr-2"></div> Mohon menunggu...
        //             </div>`
        // });

        var y = $("#year").val();

        $.ajax({
            url: "action/peramalan.php?generate&tahun=" + y + "&bulan=" + selectedMonth,
            data: $(this).serialize(),
            dataType: "JSON",
            method: "POST",
            success: function (data) {
                // dialog.modal("hide");
                loadData(selectedMonth)
            }
        });
    });


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
