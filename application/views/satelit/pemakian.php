<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Pemakian Satelit</title>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/style.css') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
</head>

<body class="homepage">
    <div class="container-fluid">
        <div class="row min-vh-100 flex-column flex-md-row">
            <aside class="col-12 col-md-3 col-xl-2 flex-shrink-1 shadow samping">
                <nav class="navbar navbar-expand-md navbar-light flex-md-column flex-row py-2 sticky-top" id="sidebar">
                    <div class="d-flex justify-content-center align-items-center mt-4 mb-4">
                        <img src="<?= base_url('assets/img/test.jpg') ?>" alt="profile picture" class="img-fluid rounded-circle text-center d-none d-md-block p-2" width="60px">
                        <span class="d-flex align-items-center"><?= $this->session->userdata("nama");?></span>
                        <div class="btn-group">
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li><a class="dropdown-item" href="#">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse order-last" id="nav">
                        <ul class="nav nav-pills flex-column mb-auto menu">
                            <li class="nav-item">
                                <a href="<?= base_url('dashboard') ?>" class="nav-link link-dark" aria-current="page">
                                    Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('dataobat/obat') ?>" class="nav-link link-dark" aria-current="page">
                                    Data Obat
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('obatmasuk/data') ?>" class="nav-link link-dark" aria-current="page">
                                    Mutasi Masuk Gudang UPT
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url('obatkeluar/data') ?>" class="nav-link link-dark">
                                    Mutasi Keluar / Distribusi Gudang UPT
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url('satelit/data') ?>" class="nav-link link-dark">
                                    Mutasi Keluar Satelit - Satelit
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url('satelit/data/pemakainsatelit') ?>" class="nav-link link-dark active">
                                    Mutasi Keluar Satelit - Satelit - Rekap
                                </a>
                            </li>
                            <li><a class="btn btn-danger mt-2" href="<?= base_url('login/out')?>">Logout</a></li>
                        </ul>
                    </div>
                </nav>
            </aside>
            <main class="col-md-9 px-0 flex-grow-1">
                <div class="px-4 py-3">
                    <article>
                        <h2 class="text-white title-puskesmas">UPT PUSKESMAS SEMANU 1</h2>
                        <div class="px-4 py-4 mt-4 shadow halaman">
                            <div class="container">
                                <h5 id="title">Data Pemakian Satelit</h5>
                                <div class="row">
                                    <div class="col">
                                        <a class="btn btn-primary float-right ml-1 mb-1" href="<?= base_url('satelit/data/') ?>">Tambah Data atau Edit Data</a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="table-satelit-rekap">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Obat</th>
                                                <th>Januari</th>
                                                <th>Februari</th>
                                                <th>Maret</th>
                                                <th>April</th>
                                                <th>Mei</th>
                                                <th>Juni</th>
                                                <th>Juli</th>
                                                <th>Agustus</th>
                                                <th>September</th>
                                                <th>Oktober</th>
                                                <th>November</th>
                                                <th>Desember</th>
                                                <th>Total Pemakain</th>
                                                <th>Januari ED</th>
                                                <th>Februari ED</th>
                                                <th>Maret ED</th>
                                                <th>April ED</th>
                                                <th>Mei ED</th>
                                                <th>Juni ED</th>
                                                <th>Juli ED</th>
                                                <th>Agustus ED</th>
                                                <th>September ED</th>
                                                <th>Oktober ED</th>
                                                <th>November ED</th>
                                                <th>Desember ED</th>
                                                <th>Total ED Satelit</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </main>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script>
    $(document).ready(function() {
        tableobatmasukgudang = $('#table-satelit-rekap').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            dom: 'lBfrtip',
            buttons: [
                'excel'
            ],
            "lengthMenu": [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "All"]
            ],
            "ajax": {
                "url": "<?= base_url('satelit/data/getsatelitrekap/') ?>",
                "type": "POST",
                "dataType": "JSON"
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