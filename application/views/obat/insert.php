<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/style.css') ?>">
    <title>Tambah Data Obat!</title>
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
                                <a href="<?= base_url('dataobat/obat') ?>" class="nav-link link-dark active" aria-current="page">
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
                                <h2>Tambah Data Obat</h2>
                                <form method="POST" action="<?= base_url('dataobat/obat/insertDataObat') ?>">
                                    <div class="mb-3">
                                        <label for="NamaObat" class="form-label">Nama Obat</label>
                                        <input type="text" class="form-control" id="NamaObat" name="NamaObat">
                                    </div>
                                    <div class="mb-3">
                                        <label for="NamaObat" class="form-label">Satuan Obat</label>
                                        <select class="form-select" aria-label="Default select example" id="SatuanObat" name="SatuanObat">
                                            <option selected>Pilih satuan obat</option>
                                            <option value="tube">tube</option>
                                            <option value="tablet">tablet</option>
                                            <option value="botol">botol</option>
                                            <option value="amp">amp</option>
                                            <option value="pot">pot</option>
                                            <option value="ampul">ampul</option>
                                            <option value="kapsul">kapsul</option>
                                            <option value="suppo">suppo</option>
                                            <option value="pcs">pcs</option>
                                            <option value="lbr">lbr</option>
                                            <option value="lembar">lembar</option>
                                            <option value="set">set</option>
                                            <option value="roll">roll</option>
                                            <option value="kotak">kotak</option>
                                            <option value="cairan">cairan</option>
                                            <option value="strip">strip</option>
                                            <option value="vial">vial</option>
                                            <option value="paket">paket</option>
                                            <option value="carpule">carpule</option>
                                            <option value="inj">inj</option>
                                            <option value="drops">drops</option>
                                            <option value="tab">tab</option>
                                            <option value="serb inj">serb inj</option>
                                            <option value="ovula">ovula</option>
                                            <option value="syringe">syringe</option>
                                            <option value="softcap">softcap</option>
                                            <option value="degree">degree</option>
                                            <option value="plabot">plabot</option>
                                            <option value="susp">susp</option>
                                            <option value="nebules">nebules</option>
                                            <option value="sachet">sachet</option>
                                            <option value="lar">lar</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="HargaSatuanObat" class="form-label">Harga Satuan Obat</label>
                                        <input type="text" class="form-control" id="HargaSatuanObat" name="HargaSatuanObat">
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

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    -->
</body>

</html>