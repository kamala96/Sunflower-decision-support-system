<?= $this->extend("templates/general") ?>

<?= $this->section("body") ?>


<main>
    <div class="container-fluid">
        <h1 class="mt-4">Profile</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Profile</li>
        </ol>

        <div class="container" style="margin-top:20px;">
            <div class="row">
                <div class="panel panel-primary">
                    <div class="panel-body">
                        <h3>Hi, <?= $user['first_name'] ?></h3>
                        <hr>
                        <p>Email: <?= $user['email'] ?></p>
                        <p>Phone No: <?= $user['phone'] ?></p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<?= $this->endSection() ?>