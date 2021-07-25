<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Obat Keluar Gudang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
</head>

<body>
    <section class="section">
        <div class="container">
            <h5>Data Obat Keluar Gudang Ke Satelit</h5>
            <div class="row">
                <div class="col">
                    <div class="filter">
                        <select class="form-select mb-2" name="BulanKeluar" id="BulanKeluar">
                            <option value="Bulan">Bulan</option>
                            <option value="Januari">Januari</option>
                            <option value="Februari">Februari</option>
                            <option value="Maret">Maret</option>
                            <option value="April">April</option>
                            <option value="Mei">Mei</option>
                            <option value="Juni">Juni</option>
                            <option value="Juli">Juli</option>
                            <option value="Agustus">Agustus</option>
                            <option value="September">September</option>
                            <option value="Oktober">Oktober</option>
                            <option value="November">November</option>
                            <option value="Desember">Desember</option>
                        </select>
                        <select class="form-select mb-2" name="TahunKeluar" id="TahunKeluar">
                            <option value="Tahun">Tahun</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                        </select>
                        <select class="form-select" name="IdSatelit" id="IdSatelit">
                            <option value="Satelit">Satelit</option>
                            <option value="SatA">Satelit A</option>
                            <option value="SatB">Satelit B</option>
                            <option value="SatC">Satelit C</option>
                            <option value="SatD">Satelit D</option>
                            <option value="SatE">Satelit E</option>
                            <option value="SatF">Satelit F</option>
                            <option value="SatG">Satelit G</option>
                            <option value="SatH">Satelit H</option>
                            <option value="SatI">Satelit I</option>
                            <option value="SatJ">Satelit J</option>
                        </select>
                        <div class="mt-2 mb-2">
                            <button type="button" id="btn-filter" class="btn btn-info">Filter</button>
                            <button type="button" id="btn-reset" class="btn btn-danger">Reset</button>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <a class="btn btn-warning float-right ml-1 mb-1" href="<?= base_url('dataobat/obatkeluar/generate') ?>">Generate Data</a>
                    <a class="btn btn-primary float-right ml-1 mb-1" href="<?= base_url('dataobat/obatkeluar/insert') ?>">Tambah Data</a>
                    <a class="btn btn-success float-right ml-1 mb-1" href="<?= base_url('dataobat/obatkeluar/exportExcelOKG') ?>">Export Excel</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="table-siswa">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Obat</th>
                            <th>Januari Dinkes</th>
                            <th>Januari Blud</th>
                            <th>Februari Dinkes</th>
                            <th>Februari Blud</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </section>
</body>
<script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        tableobatmasukgudang = $('#table-siswa').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url('dataobat/pivot/getDataTest') ?>",
                "type": "POST",
                "dataType": "JSON",
                "data": function(data) {
                    data.BulanKeluar = $("#BulanKeluar").val();
                    data.TahunKeluar = $("#TahunKeluar").val();
                    data.IdSatelit = $("#IdSatelit").val();
                },
            }
        });

        $('#btn-filter').click(function() {
            tableobatmasukgudang.ajax.reload();
        })
        $('#btn-reset').click(function() {
            $("#BulanMasuk").val('Bulan');
            $("#TahunMasuk").val('Tahun');
            tableobatmasukgudang.ajax.reload();
        })
    });
</script>

</html>