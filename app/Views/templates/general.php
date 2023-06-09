<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title><?= esc($title) ?></title>
    <link href="<?= esc(base_url('assets/css/styles.css')) ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= esc(base_url('assets/bootstrap-4.0.0/css/bootstrap.min.css')) ?>">
    <link rel="stylesheet" href="<?= esc(base_url('assets/css/dataTables.bootstrap4.css')) ?>">
    <script src="<?= esc(base_url('assets/js/all.min.js')) ?>"></script>
    <script>
        var csrfName = '<?= csrf_token() ?>';
        var csrfHash = '<?= csrf_hash() ?>';
    </script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" style="font-family: cursive;" href="<?= esc(base_url('/home')) ?>">DSS Admin Dashboard</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#">
            <i class="fas fa-bars"></i>
        </button>
        <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0"></div>

        <div class="small text-light"><?= session()->get('last_name') ?>
            <span
                class="font-italic text-primary">(<?= session()->get('user_ward') ? session()->get('user_ward') : 'Super' ?>)</span>
        </div>
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="javascript:void(0)">Settings</a>
                    <a class="dropdown-item" href="javascript:void(0)">Activity Log</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= base_url('/user-logout') ?>">Logout</a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="<?= esc(base_url('/home')) ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                            Home
                        </a>

                        <?php if(strtolower(session()->get('user_role')) == 'super'): ?>
                        <div class="sb-sidenav-menu-heading">Settings</div>
                        <a class="nav-link" href="<?= esc(base_url('/home/activities')) ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-list-alt"></i></div>
                            Activities
                        </a>

                        <a class="nav-link" href="<?= esc(base_url('/home/extension-officers')) ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-list-alt"></i></div>
                            Extension Officers
                        </a>
                        <?php endif ?>

                        <a class="nav-link" href="<?= esc(base_url('/home/sms-farmers')) ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-list-alt"></i></div>
                            SMS-Farmers
                        </a>
                        <?php if(strtolower(session()->get('user_role')) == 'super'): ?>
                        <a class="nav-link" href="<?= esc(base_url('/forecast2')) ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-list-alt"></i></div>
                            Data Fetching
                        </a>
                        <a class="nav-link" href="<?= esc(base_url('/api/get-weather2/1')) ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-list-alt"></i></div>
                            Dissemination (App)
                        </a>
                        <a class="nav-link" href="<?= esc(base_url('/send-sms')) ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-list-alt"></i></div>
                            Dissemination (SMS)
                        </a>
                        <?php endif ?>

                        <!-- <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFarmers"
    aria-expanded="false" aria-controls="collapseFarmers">
    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
    Farmers
    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="collapseFarmers" aria-labelledby="headingOne"
    data-parent="#sidenavAccordion">
    <nav class="sb-sidenav-menu-nested nav">
    <a class="nav-link" href="">Add Farmer</a>
    <a class="nav-link" href="">View Farmers</a>
    </nav>
    </div> -->
                        <!-- 
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
    aria-expanded="false" aria-controls="collapsePages">
    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
    Pages
    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="collapsePages" aria-labelledby="headingTwo"
    data-parent="#sidenavAccordion">
    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
    <a class="nav-link collapsed" href="#" data-toggle="collapse"
    data-target="#pagesCollapseAuth" aria-expanded="false"
    aria-controls="pagesCollapseAuth">
    Authentication
    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
    data-parent="#sidenavAccordionPages">
    <nav class="sb-sidenav-menu-nested nav">
    <a class="nav-link" href="login.html">Login</a>
    <a class="nav-link" href="register.html">Register</a>
    <a class="nav-link" href="password.html">Forgot Password</a>
    </nav>
    </div>
    <a class="nav-link collapsed" href="#" data-toggle="collapse"
    data-target="#pagesCollapseError" aria-expanded="false"
    aria-controls="pagesCollapseError">
    Error
    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne"
    data-parent="#sidenavAccordionPages">
    <nav class="sb-sidenav-menu-nested nav">
    <a class="nav-link" href="401.html">401 Page</a>
    <a class="nav-link" href="404.html">404 Page</a>
    <a class="nav-link" href="500.html">500 Page</a>
    </nav>
    </div>
    </nav>
    </div> -->
                        <!-- <div class="sb-sidenav-menu-heading">Addons</div> -->
                        <!-- <a class="nav-link" href="charts.html">
    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
    Charts
    </a>
    <a class="nav-link" href="tables.html">
    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
    Tables
    </a> -->
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">

            <?= $this->renderSection("body") ?>


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
    <script src="<?= esc(base_url('assets/js/dataTables.min.js')) ?>"></script>
    <script src="<?= esc(base_url('assets/js/dataTables.bootstrap4.min.js')) ?>"></script>
    <script src="<?= esc(base_url('assets/demo/datatables-demo.js')) ?>"></script>
    <script src="<?= esc(base_url('assets/js/jquery.validate.js')) ?>"></script>
    <script src="<?= esc(base_url('assets/js/bootbox/bootbox.min.js')) ?>"></script>

    <?= $this->renderSection("scripts") ?>
</body>

</html>