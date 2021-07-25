<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/style.css')?>">
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>

    <title>Tambah Data Obat Masuk Gudang UPT!</title>
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
                                <a href="<?= base_url('obatmasuk/data') ?>" class="nav-link link-dark active" aria-current="page">
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
                                <a href="<?= base_url('satelit/data/pemakainsatelit') ?>" class="nav-link link-dark">
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
                                <h5>Tambah Data Obat Masuk Gudang</h5>
                                <form method="POST" action="<?= base_url('obatmasuk/data/insertOMG') ?>">
                                    <div class="mb-3">
                                        <label for="NamaObat" class="form-label">Masukan Nama Obat</label>
                                        <div class="row">
                                            <div class="col">
                                                <input type="text" class="form-control" id="InputNamaObat" name="InputNamaObat">
                                            </div>
                                            <div class="col">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text" for="IdObat">Nama Obatnya</label>
                                                    </div>
                                                    <select class="custom-select" id="IdObat" name="IdObat">
                                                        <option selected>Pilih Nama Obat Disini Wajib!</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="Dinkes" class="form-label">Dinkes</label>
                                        <input type="text" class="form-control" id="Dinkes" name="Dinkes">
                                    </div>
                                    <div class="mb-3">
                                        <label for="Blud" class="form-label">Blud</label>
                                        <input type="text" class="form-control" id="Blud" name="Blud">
                                    </div>
                                    <div class="mb-3 row">
                                        <div class="bulanmasuk col">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text" for="BulanMasuk">Bulan Masuk</label>
                                                </div>
                                                <select name="BulanMasuk" id="BulanMasuk" class="custom-select">
                                                    <option value="Januari">Januari</option>
                                                    <option value="Februari">Februari</option>
                                                    <option value="Maret">Maret</option>
                                                    <option value="April">April</option>
                                                    <option value="Mei">Mei</option>
                                                    <option value="Juni">Juni</option>
                                                    <option value="Agustus">Agustus</option>
                                                    <option value="September">September</option>
                                                    <option value="November">November</option>
                                                    <option value="Desember">Desember</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="tahunmasuk col">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text" for="TahunMasuk">Tahun Masuk</label>
                                                </div>
                                                <input type="text" class="form-control" id="TahunMasuk" name="TahunMasuk">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                    </article>
                </div>
            </main>
        </div>
    </div>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#InputNamaObat').on('click', () => {
                loadanggota();
            })

            function loadanggota() {
                $('#InputNamaObat').keyup(function() {
                    var search = $(this).val();
                    $.ajax({
                        url: "<?php echo site_url('obatmasuk/data/getobatinsert'); ?>",
                        method: "POST",
                        async: true,
                        data: {
                            query: search
                        },
                        dataType: 'json',
                        success: function(data) {
                            console.log(data);
                            var html = '';
                            var i;
                            for (i = 0; i < data.length; i++) {
                                html += '<option value=' + data[i].IdObat + '>' + (i + 1) + '. ' + data[i].NamaObat + '</option>';
                            }
                            $('#IdObat').html(html);
                        }
                    })

                })
            }
        });
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    -->
</body>

</html>