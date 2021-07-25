<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Obat Keluar Gudang Ke Satelit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/style.css') ?>">
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
                        <span class="d-flex align-items-center"><?= $this->session->userdata("nama"); ?></span>
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
                                <a href="<?= base_url('obatkeluar/data') ?>" class="nav-link link-dark active">
                                    Mutasi Keluar / Distribusi Gudang UPT
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url('satelit/data') ?>" class="nav-link link-dark">
                                    Mutasi Keluar Satelit - Satelit
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url('satelit/data/pemakainsatelit') ?>" class="nav-link link-dark">
                                    Mutasi Keluar Satelit - Satelit - Rekap
                                </a>
                            </li>
                            <li><a class="btn btn-danger mt-2" href="<?= base_url('login/out') ?>">Logout</a></li>
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
                                <?php
                                if ($this->session->flashdata('success')) {
                                ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong><?= $this->session->flashdata('success') ?>!</strong>
                                        <button type="button" class="close" data-bs-dismiss="alert" aria-label="close">&times;</button>
                                    </div>
                                <?php
                                    $this->session->unset_userdata('success');
                                } else if ($this->session->flashdata('failed')) {
                                ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong><?= $this->session->flashdata('failed') ?>!</strong>
                                        <button type="button" class="close" data-bs-dismiss="alert" aria-label="close">&times;</button>
                                    </div>
                                <?php
                                    $this->session->unset_userdata('failed');
                                } else if ($this->session->flashdata('notfound')) {
                                ?>
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>Gagal Proses Data, Data Tidak Ditemukan!</strong>
                                        <button type="button" class="close" data-bs-dismiss="alert" aria-label="close">&times;</button>
                                    </div>
                                <?php
                                    $this->session->unset_userdata('notfound');
                                }else if($this->session->flashdata('duplicated')){
                                ?>
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong><?= $this->session->flashdata('duplicated');?></strong>
                                        <button type="button" class="close" data-bs-dismiss="alert" aria-label="close">&times;</button>
                                    </div>
                                <?php
                                }
                                ?>
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
                                        <a class="btn btn-warning float-right ml-1 mb-1" href="<?= base_url('obatkeluar/data/generate') ?>">Generate Data</a>
                                        <a class="btn btn-primary float-right ml-1 mb-1" href="<?= base_url('obatkeluar/data/insert') ?>">Tambah Data</a>
                                        <a class="btn btn-success float-right ml-1 mb-1" href="<?= base_url('obatkeluar/data/exportExcelOKG') ?>">Export Excel</a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="table-siswa">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Obat</th>
                                                <th>Satelit</th>
                                                <th>Distribusi</th>
                                                <th>Bulan Keluar</th>
                                                <th>Tahun Keluar</th>
                                                <th>Aksi</th>
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
<script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        tableobatmasukgudang = $('#table-siswa').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url('obatkeluar/data/getObatKeluar') ?>",
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