<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title><?= esc($title) ?></title>
    <link href="<?= esc(base_url('assets/css/styles.css')) ?>" rel="stylesheet" />
    <script src="<?= esc(base_url('assets/js/all.min.js')) ?>"></script>
    </script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4" style="font-family: cursive;">Decision Support System <br />Login Screen</h3>
                                </div>
                                <div class="card-body">
                                    <?php if(session()->getFlashdata('err_msg')):?>
                                    <div class="alert alert-danger"><?= session()->getFlashdata('err_msg') ?></div>
                                    <?php endif;?>
                                    <?php if(session()->getFlashdata('success_msg')):?>
                                    <div class="alert alert-success"><?= session()->getFlashdata('success_msg') ?></div>
                                    <?php endif;?>
                                    <form action="/login/auth" method="post">
                                        <?= csrf_field() ?>
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputEmailAddress">Username</label>
                                            <input
                                                class="form-control py-4 <?= (isset($validation) && $validation->hasError('username')) != null ? ' is-invalid' : '' ?>"
                                                name="username" id="inputEmailAddress" type="text"
                                                value="<?= set_value('username') ?>" placeholder="Enter username"
                                                required />
                                            <?= (isset($validation) && $validation->hasError('username')) != null ? '<div class="invalid-feedback">'.$validation->getError('username').'</div>' : '' ?>
                                        </div>
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputPassword">Password</label>
                                            <input
                                                class="form-control py-4 <?= (isset($validation) && $validation->hasError('password')) != null ? ' is-invalid' : '' ?>"
                                                name="password" id="inputPassword" type="password"
                                                placeholder="Enter password" required />
                                            <?= (isset($validation) && $validation->hasError('password')) != null ? '<div class="invalid-feedback">'.$validation->getError('password').'</div>' : '' ?>
                                        </div>
                                        <div
                                            class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button class="btn btn-primary btn-block" type="submit">Login</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center">
                                    <a class="small" href="<?= esc(base_url('app')) ?>">Download App (Android)</a>

                                    <!-- <div class="small"><a href="/register">Need an account? Sign up!</a></div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Smart-Kilimo <?= date("Y") ?></div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    <script src="<?= esc(base_url('assets/js/jquery.min.js')) ?>"></script>
    <script src="<?= esc(base_url('assets/js/popper.min.js')) ?>"></script>
    <script src="<?= esc(base_url('assets/bootstrap-4.0.0/js/bootstrap.min.js')) ?>"></script>
    <script src="<?= esc(base_url('assets/js/scripts.js')) ?>"></script>
</body>

</html>