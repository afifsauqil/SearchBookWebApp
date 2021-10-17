<?= $this->extend('template/index'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">

    <div class="row">
        <div class="col-lg-8">
            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800">Detail Buku</h1>

            <div class="row">
                <div class="col">
                    <div class="card mb-3" style="max-width: 540px;">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                <img src="/img/<?= $buku['sampul']; ?>" alt="" class="card-img">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $buku['judul']; ?></h5>
                                    <p class="card-text"><b>Penulis : </b><?= $buku['penulis']; ?></p>
                                    <p class="card-text"><small class="text-muted"><b>Penerbit : </b><?= $buku['penerbit']; ?></small></p>
                                    <p class="card-text"><small class="text-muted"><b>Sinopsis : </b><?= $buku['sinopsis']; ?></small></p>

                                    <a href="/menu">&laquo; kembali ke daftar buku</a>

                                    <?php if (in_groups('admin')) : ?>
                                        <a href="/menu/edit/<?= $buku['slug']; ?>" class="btn btn-warning">Edit</a>
                                        <form action="/menu/<?= $buku['id']; ?>" method="post" class="d-inline">
                                            <?= csrf_field(); ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('apakah anda yakin?');">Delete</button>
                                        </form>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?= $this->endSection(); ?>