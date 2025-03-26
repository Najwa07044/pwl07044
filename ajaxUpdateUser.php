<!DOCTYPE html>
<html>

<head>
    <title>Selamat Datang</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/styleku.css">
    <link rel="stylesheet" href="bootstrap533/css/bootstrap.min.css">
    <script src="bootstrap533/jquery/jquery-3.7.1.min.js"></script>
    <script src="bootstrap533/js/bootstrap.js"></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .custom-combobox {
            position: relative;
            display: inline-block;
        }

        .custom-combobox select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            padding-right: 30px;
        }

        .custom-combobox::after {
            content: "";
            position: absolute;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
            pointer-events: none;
            width: 0;
            height: 0;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 5px solid #000;
        }
    </style>
</head>

<body>
    <?php
    require "fungsi.php";
    require "head.html";

    $dataPerHalaman = 10; // default 10

    if (isset($_GET['dataPerHalaman'])) {
        $dataPerHalaman = $_GET['dataPerHalaman'];
    }

    $cari = isset($_GET['cari']) ? $_GET['cari'] : '';

    if ($cari) {
        $sql = "SELECT * FROM user WHERE username LIKE '%$cari%' OR password LIKE '%$cari%' OR status LIKE '%$cari%'";
    } else {
        $sql = "SELECT * FROM user";
    }

    $qry = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
    $jmlData = mysqli_num_rows($qry);
    $jmlHal = ceil($jmlData / $dataPerHalaman);

    $halAktif = isset($_GET['hal']) ? $_GET['hal'] : 1;
    $awalData = ($dataPerHalaman * $halAktif) - $dataPerHalaman;

    $kosong = false;
    if (!$jmlData) {
        $kosong = true;
    }

    if ($cari) {
        $sql = "SELECT * FROM user WHERE username LIKE '%$cari%' OR password LIKE '%$cari%' OR status LIKE '%$cari%' LIMIT $awalData, $dataPerHalaman";
    } else {
        $sql = "SELECT * FROM user LIMIT $awalData, $dataPerHalaman";
    }

    $hasil = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
    ?>

    <div class="utama">
        <h2 class="text-center">Daftar Mahasiswa</h2>
        <div class="text-center"><a href="cetakUserPdf.php"><span class="fas fa-print">&nbsp;Print</span></a></div>
        <div class="float-left mb-3">
            <a class="btn btn-success" href="addUser.php">Tambah Data</a>
        </div>

        <div class="float-right mb-3">
            <form action="" method="get" class="form-inline">
                <div class="form-group">
                    <input class="form-control me-2 mb-2" type="text" name="cari" placeholder="cari data user..." autofocus autocomplete="off" id="keyword" value="<?php echo $cari; ?>">
                    <button class="btn btn-success me-2 mb-2" type="submit" id="tombol-cari">Cari</button>
                </div>
                <div class="form-group">
                    <div class="custom-combobox">
                        <select name="dataPerHalaman" id="dataPerHalaman" class="form-control me-2 mb-2" style="width: 80px;" onchange="this.form.submit()">
                            <option value="5" <?php if ($dataPerHalaman == 5) echo 'selected'; ?>>5</option>
                            <option value="10" <?php if ($dataPerHalaman == 10) echo 'selected'; ?>>10</option>
                            <option value="30" <?php if ($dataPerHalaman == 30) echo 'selected'; ?>>30</option>
                            <option value="70" <?php if ($dataPerHalaman == 70) echo 'selected'; ?>>70</option>
                            <option value="100" <?php if ($dataPerHalaman == 100) echo 'selected'; ?>>100</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <div class="clearfix"></div>

        <div id="container">
            <table class="table table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>No.</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    if ($kosong) {
                    ?>
                        <tr>
                            <th colspan="6">
                                <div class="alert alert-info alert-dismissible fade show text-center">
                                    Data tidak ada
                                </div>
                            </th>
                        </tr>
                        <?php
                    } else {
                        $no = $awalData + 1;
                        while ($row = mysqli_fetch_assoc($hasil)) {
                        ?>
                            <tr>
                                <td><?php echo $no ?></td>
                                <td><?php echo $row["username"] ?></td>
                                <td><?php echo $row["password"] ?></td>
                                <td><?php echo $row["status"] ?></td>
                                <td>
                                    <a class="btn btn-outline-primary btn-sm" href="editUser.php?kode=<?php echo $row['iduser'] ?>">Edit</a>
                                    <a class="btn btn-outline-danger btn-sm" href="hpsUser.php?kode=<?php echo $row["iduser"] ?>" id="deleteLink">Hapus</a>
                                </td>
                            </tr>
                    <?php
                            $no++;
                        }
                    }
                    ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <nav>
                <ul class="pagination">
                    <?php if ($halAktif > 1) : ?>
                        <li class="page-item">
                            <a class="page-link" href="?hal=<?php echo $halAktif - 1; ?>&cari=<?php echo $cari; ?>&dataPerHalaman=<?php echo $dataPerHalaman; ?>">Previous</a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $jmlHal; $i++) : ?>
                        <li class="page-item <?php echo ($i == $halAktif) ? 'active' : ''; ?>">
                            <a class="page-link" href="?hal=<?php echo $i; ?>&cari=<?php echo $cari; ?>&dataPerHalaman=<?php echo $dataPerHalaman; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($halAktif < $jmlHal) : ?>
                        <li class="page-item">
                            <a class="page-link" href="?hal=<?php echo $halAktif + 1; ?>&cari=<?php echo $cari; ?>&dataPerHalaman=<?php echo $dataPerHalaman; ?>">Next</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>

    <script src="js/script.js"> </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.btn-outline-danger').on('click', function(e) {
                e.preventDefault();
                var deleteLink = $(this).attr('href');
                var row = $(this).closest('tr');

                if (confirm('Yakin dihapus nih?')) {
                    $.ajax({
                        url: deleteLink,
                        type: 'GET',
                        success: function(response) {
                            row.remove();
                            refreshPaginationAndCount();
                        },
                        error: function() {
                            alert('Gagal menghapus data');
                        }
                    });
                }
            });

            function refreshPaginationAndCount() {
                $('.table tbody tr').each(function(index) {
                    $(this).find('td:first').text(index + 1);
                });

                var totalRows = $('.table tbody tr').length;

                if (totalRows === 0) {
                    $('.table tbody').html(`
                    <tr>
                        <th colspan="6">
                            <div class="alert alert-info alert-dismissible fade show text-center">
                                Data tidak ada
                            </div>
                        </th>
                    </tr>
                `);
                }
            }
        });
    </script>

</body>

</html>