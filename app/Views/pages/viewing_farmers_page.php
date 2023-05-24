<?= $this->extend("templates/general") ?>

<?= $this->section("body") ?>

<main>
    <div class="container-fluid">
        <!-- <h1 class="mt-4">SMS-Farmers</h1> -->
        <ol class="breadcrumb mb-4 mt-2">
            <li class="breadcrumb-item"><a href="<?= esc(base_url('/dashboard')) ?>">Home</a></li>
            <li class="breadcrumb-item active"><?= esc($title) ?></li>
        </ol>

        <?= $success_redirect_data ? '<div class="alert alert-success">'.$success_redirect_data.'</div>' : "" ?>
        <?= $error_redirect_data ? '<div class="alert alert-danger">'.$error_redirect_data.'</div>' : "" ?>


        <div class="card mb-4">
            <div class="card-header text-center">
                <strong>Import SMS-Farmers (CSV File)</strong>
            </div>

            <div class="card-body">

                <form action="<?= base_url('home/sms-farmers') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="form-group mb-3">
                        <div class="mb-3">
                            <input type="file" name="file" class="form-control" id="file" required>
                        </div>
                    </div>
                    <div class="d-grid">
                        <input type="submit" name="submit" value="Import" class="btn btn-dark" />
                    </div>
                </form>
            </div>
        </div>


        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-list-alt mr-1"></i>
                Available Farmers
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Mobile</th>
                                <th>Ward</th>
                                <th>District</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Mobile</th>
                                <th>Ward</th>
                                <th>District</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php if( ! empty($sms_farmers)): ?>
                            <?php foreach($sms_farmers as $row): ?>
                            <tr id="<?php echo $row['v_id']; ?>">
                                <td><?= "+255" . esc($row['v_phone']) ?></td>
                                <td><?= esc($row['ward_name']) ?></td>
                                <td><?= esc($row['district_name']) ?></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a class="btn btn-outline-primary"
                                            href="<?= esc(base_url('home/sms-farmers/trash/'.$row['v_id'])) ?>">Trash</a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach ?>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>


<?= $this->endSection() ?>