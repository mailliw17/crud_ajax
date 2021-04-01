<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="<?= base_url() ?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <title>Data Barang</title>
</head>

<body>


    <div class="container my-5">
        <h1>Data Barang</h1>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary my-3" data-toggle="modal" data-target="#modalTambahBarang" onclick="submit('tambah')">
            Tambah Barang
        </button>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Kode Barang</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>

            <tbody id="targetData">
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalTambahBarang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <center>
                        <p id="validasi" style="color: red;"></p>
                    </center>
                    <form>
                        <input type="hidden" class="form-control" id="id" name="id" value="" aria-describedby="emailHelp">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Kode Barang</label>
                            <input type="text" class="form-control" id="kode_barang" name="kode_barang" aria-describedby="emailHelp" placeholder="Kode Barang">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Nama Barang</label>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Nama Barang">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Harga</label>
                            <input type="text" class="form-control" id="harga" name="harga" placeholder="Nama Barang">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Stok</label>
                            <input type="text" class="form-control" id="stok" name="stok" placeholder="Nama Barang">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="btn-tambah" onclick="tambahdata()" class="btn btn-primary">Tambah</button>
                    <button type="button" id="btn-edit" onclick="editdata()" class="btn btn-primary">Edit</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script src="<?= base_url() ?>vendor/jquery/jquery.min.js"></script>

    <script src="<?= base_url() ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script>
        ambildata();

        function ambildata() {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/crud/ambildata',
                dataType: 'json',
                success: function(data) {
                    var baris = '';
                    for (var i = 0; i < data.length; i++) {
                        baris += '<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td>' + data[i].kode_barang + '</td>' +
                            '<td>' + data[i].nama_barang + '</td>' +
                            '<td>' + data[i].harga + '</td>' +
                            '<td>' + data[i].stok + '</td>' +
                            '<td><a href="#modalTambahBarang" data-toggle="modal" class="btn btn-info" onclick="submit(' + data[i].id + ')">Edit</a> <a class="btn btn-danger" onclick="hapusdata(' + data[i].id + ')">Hapus</a></td>' +
                            '</tr>'
                    }
                    $('#targetData').html(baris)
                }
            })
        }

        function tambahdata() {
            var kode_barang = $("[name='kode_barang']").val();
            var nama_barang = $("[name='nama_barang']").val();
            var harga = $("[name='harga']").val();
            var stok = $("[name='stok']").val();

            $.ajax({
                type: 'POST',
                data: 'kode_barang=' + kode_barang + '&nama_barang=' + nama_barang + '&harga=' + harga + '&stok=' + stok + '',
                url: '<?= base_url() ?>index.php/crud/tambahdata',
                dataType: 'json',
                success: function(hasil) {
                    $("#validasi").html(hasil.pesan);

                    // kalau lolos validasi
                    if (hasil.pesan == '') {
                        $('#modalTambahBarang').modal('hide');
                        ambildata();

                        // untuk kosongin kolom setelah menginput
                        $("[name='kode_barang']").val('');
                        $("[name='nama_barang']").val('');
                        $("[name='harga']").val('');
                        $("[name='stok']").val('');

                        $("#validasi").html('');
                    }
                }
            })
        }

        // untuk membedakan modal ketika tombol edit atau tombol tambah di klik
        function submit(x) {
            if (x == 'tambah') {
                $('#btn-tambah').show();
                $('#btn-edit').hide();
            } else {
                // kalau edit
                $('#btn-tambah').hide();
                $('#btn-edit').show();

                $.ajax({
                    type: "POST",
                    data: "id=" + x,
                    url: '<?= base_url() ?>index.php/crud/ambilID',
                    dataType: 'json',
                    success: function(data) {
                        // untuk kirim data ke kolom inputan
                        // ini ke dalam parameter val nya
                        var id = $("[name='id']").val(data[0].id);
                        var kode_barang = $("[name='kode_barang']").val(data[0].kode_barang);
                        var nama_barang = $("[name='nama_barang']").val(data[0].nama_barang);
                        var harga = $("[name='harga']").val(data[0].harga);
                        var stok = $("[name='stok']").val(data[0].stok);
                    }
                })
            }
        }

        function editdata() {
            var id = $("[name='id']").val();
            var kode_barang = $("[name='kode_barang']").val();
            var nama_barang = $("[name='nama_barang']").val();
            var harga = $("[name='harga']").val();
            var stok = $("[name='stok']").val();

            $.ajax({
                type: "post",
                data: 'id=' + id + '&kode_barang=' + kode_barang + '&nama_barang=' + nama_barang + '&harga=' + harga + '&stok=' + stok + '',
                url: "<?= base_url() ?>index.php/crud/editdata",
                dataType: "json",
                success: function(hasil) {
                    // ga lolos validasi
                    $("#validasi").html(hasil.pesan);

                    // kalau lolos validasi
                    if (hasil.pesan == '') {
                        $('#modalTambahBarang').modal('hide');
                        ambildata();

                        // untuk kosongin kolom setelah menginput
                        $("[name='kode_barang']").val('');
                        $("[name='nama_barang']").val('');
                        $("[name='harga']").val('');
                        $("[name='stok']").val('');

                        $("#validasi").html('');
                    }
                }
            })
        }

        // kalau delete gausah pake dataType JSON
        function hapusdata(id) {

            var tanya = confirm('Apakah anda yakin menghapus data?');

            if (tanya) {
                $.ajax({
                    type: "POST",
                    data: "id=" + id,
                    url: "<?= base_url() ?>index.php/crud/hapusdata",
                    success: function() {
                        ambildata();
                    }
                })
            }
        }
    </script>
</body>

</html>