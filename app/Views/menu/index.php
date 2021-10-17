<?= $this->extend('template/index'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">

    <div class="row">
        <div class="col-lg-10">
            <!-- Page Heading -->
            <?php if (in_groups('admin')) : ?>
                <a href="/menu/create" class="btn btn-primary">Add</a>
            <?php endif; ?>

            <h1 class="h3 mb-4 text-gray-800 mt-2">Daftar Buku</h1>
            <?php if (session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan'); ?>
                </div>
            <?php endif; ?>

            <table class="table mt-2">
                <thead class="bg-primary text-light">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Sampul</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($buku as $b) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><img src="/img/<?= $b['sampul']; ?>" alt="" class="sampul"></td>
                            <td><?= $b['judul']; ?></td>
                            <td>
                                <a href="/menu/<?= $b['slug']; ?>" class="btn btn-info"><i class="fas fa-search"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>

</div>
<?= $this->endSection(); ?>