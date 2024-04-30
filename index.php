<?php
include 'library.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan PHP | Maria Delvina</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <div class="p-5 mb-4 bg-body-tertiary rounded-3 jumbotron">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold">Perpustakaan Online</h1>
            <p class="col-md-8 fs-4">Baca dimanapun dan kapanpun melalui genggaman tangan. komunikasikan pikiran dengan buku untuk wawasan yang luas</p>
            <form action="" method="GET" class="row">
                <div class="col-4">
                    <label for="search" class="visually-hidden">Search title or author</label>
                    <input name="katakunci" type="text" class="form-control" id="Search" placeholder="Cari judul atau penulis">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-success">Search</button>
                </div>
            </form>
        </div>
    </div>
    <h1 class="text-center">DAFTAR BUKU</h1>
    <div class="container-fluid d-flex flex-wrap justify-content-evenly align-items-center">
        <?php foreach ($hasilPencarian as $bukunya) { ?>
            <div class="card mb-3" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title"><?= $bukunya->judul ?></h5>
                    <p class="card-text"><?= $bukunya->pengarang ?></p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><?= $bukunya->tahun_terbit ?></li>
                    <li class="list-group-item"><?= $bukunya->penerbit ?></li>
                    <li class="list-group-item"><?= $bukunya->isbn ?></li>
                </ul>
                <div class="card-body d-flex justify-content-between align-items-center">
                    <?php if ($bukunya->status == 1) : ?>
                        <form action="" method="POST">
                            <input type="hidden" name="book_id" value="<?= $bukunya->id ?>">
                            <button type="submit" name="borrow" class="btn btn-primary">Pinjam</button>
                        </form>
                    <?php else : ?>
                        <form action="" method="POST">
                            <input type="hidden" name="book_id" value="<?= $bukunya->id ?>">
                            <button type="submit" name="borrow" class="btn btn-warning">Kembali</button>
                        </form>
                    <?php endif; ?>
                    <p class="card-text"><?= $bukunya->id ? 'Tersedia' : 'Dipinjam' ?></p>
                </div>
            </div>
        <?php } ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>