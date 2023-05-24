<?= $this->extend("templates/general") ?>

<?= $this->section("body") ?>

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Extension Officers</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
            <li class="breadcrumb-item active"><?= esc($title) ?></li>
        </ol>


        <div class="card mb-4">
            <header class="card-header">
                <h4 class="card-title">Agricultural Extension Officer Registration Form</h4>
            </header>
            <article class="card-body">
                <?= isset($success_redirect_data) ? '<div class="alert alert-success">'.esc($success_redirect_data).'</div>' : "" ?>
                <?= isset($error_redirect_data) ? '<div class="alert alert-danger">'.esc($error_redirect_data).'</div>' : "" ?>
                <?= session()->getFlashdata('err_msg') ? '<div class="alert alert-danger">'.session()->getFlashdata('err_msg').'</div>' : '' ?>
                <?php if(session()->getFlashdata('success_msg')):?>
                <div class="alert alert-success"><?= session()->getFlashdata('success_msg') ?></div>
                <?php endif;?>
                <?= isset($validation) ? '<div class="alert alert-danger">'.$validation->listErrors().'</div>' : '' ?>
                <form action="/dashboard/add-user" method="post">
                    <?= csrf_field() ?>
                    <div class="form-row">
                        <div class="col form-group">
                            <label>First name </label>
                            <input type="text" name="first_name" value="<?= set_value('first_name') ?>"
                                class="form-control" placeholder="">
                        </div>
                        <div class="col form-group">
                            <label>Last name</label>
                            <input type="text" name="last_name" value="<?= set_value('last_name') ?>"
                                class="form-control" placeholder=" ">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col form-group">
                            <label>Email address</label>
                            <input type="email" name="email" value="<?= set_value('email') ?>" class="form-control"
                                placeholder="">
                        </div>
                        <div class="col form-group">
                            <label>Mobile Phone</label>
                            <input type="tel" pattern="^\+[1-9]\d{1,14}$" name="phone"
                                value="<?= set_value('phone') ?>" class="form-control" placeholder=" ">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Role</label>
                            <select name="role" id="inputState" class="form-control">
                                <option> Choose...</option>
                                <?php foreach($user_roles as $row): ?>
                                <option
                                    <?= (session()->get('user_role') == 'super') ? "" : ((strtolower($row['role']) == "farmer")  ? "" : "hidden") ?>
                                    value="<?= esc($row['role_id']) ?>"><?= esc(ucwords($row['role'])) ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Ward</label>
                            <select name="ward" id="inputState" class="form-control">
                                <option disabled> Choose...</option>
                                <?php foreach($list_of_wards as $row): ?>
                                <option <?= (session()->get('user_role') == 'super') ? "" : ((strtolower($row['ward_id']) == session()->get('user_ward_id'))  ? "" : "hidden") ?> value="<?= (session()->get('user_role') == 'normal') ? session()->get('user_ward_id') : esc($row['ward_id']) ?>"><?= esc(ucwords($row['ward_name'])) ?>
                                </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input class="form-control" value="<?= set_value('username') ?>" name="username" type="text"
                            placeholder="">
                    </div>
                    <div class="form-row">
                        <div class="col form-group">
                            <label>Create password</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="col form-group">
                            <label>Confirm password</label>
                            <input type="password" name="confpassword" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block"> Register </button>
                    </div>
                </form>
            </article>
        </div>


    </div>
</main>


<?= $this->endSection() ?>