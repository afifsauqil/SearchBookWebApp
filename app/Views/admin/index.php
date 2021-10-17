<?= $this->extend('template/index'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Users List</h1>

    <div class="row">
        <div class="col-lg-8">
            <table class="table">
                <thead class="bg-primary text-light">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <th><?= $user->username; ?></th>
                            <th><?= $user->email; ?></th>
                            <th><?= $user->name; ?></th>
                            <th>
                                <a href="<?= base_url('admin/' . $user->userid); ?>" class="btn btn-info"><i class="fas fa-search"></i></a>
                            </th>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<?= $this->endSection(); ?>