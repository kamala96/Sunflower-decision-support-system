<?= $this->extend("templates/general") ?>

<?= $this->section("body") ?>

<main>
    <div class="container-fluid">
        <ol class="breadcrumb mt-4 mb-4">
            <li class="breadcrumb-item"><a href="<?= esc(base_url('home')) ?>">Home</a></li>
            <li class="breadcrumb-item active"><?= esc($title) ?></li>
        </ol>

        <?= isset($success_redirect_data) ? '<div class="alert alert-success">'.esc($success_redirect_data).'</div>' : "" ?>
        <?= isset($error_redirect_data) ? '<div class="alert alert-danger">'.esc($error_redirect_data).'</div>' : "" ?>
        <div id="error_message" class="ajax_response alert alert-danger" style="display:none;"></div>
        <div id="success_message" class="ajax_response alert alert-success" style="display:none;"></div>
        <!-- Errors end -->

        <!-- Form Start -->
        <div class="collapse mb-2" id="newCollapse">
            <div class="card">
                <div class="card-header container-fluid">
                    Add Agricultural Extension Officer
                </div>
                <div class="card-body">
                    <form id="addUser" method="post" action="javascript:void(0);">
                        <?= csrf_field() ?>
                        <div class="form-row">
                            <div class="col form-group">
                                <label>First name </label>
                                <input type="text" id="first_name" name="first_name" class="form-control"
                                    placeholder="">
                            </div>
                            <div class="col form-group">
                                <label>Last name</label>
                                <input type="text" id="last_name" name="last_name" class="form-control" placeholder=" ">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col form-group">
                                <label>Email address</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="">
                            </div>
                            <div class="col form-group">
                                <label>Mobile Phone</label>
                                <input type="tel" pattern="^\+[1-9]\d{1,14}$" id="phone" name="phone"
                                    class="form-control" placeholder=" ">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Username</label>
                                <input class="form-control" id="username" name="username" type="text" placeholder="">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Ward</label>
                                <select name="ward" id="ward" class="form-control">
                                    <option selected disabled> Choose...</option>
                                    <?php foreach($list_of_wards as $row): ?>
                                    <option value="<?= esc($row['ward_id']) ?>"> <?= esc(ucwords($row['ward_name'])) ?>
                                    </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col form-group">
                                <label>Create password</label>
                                <input type="password" id="password" name="password" class="form-control">
                            </div>
                            <div class="col form-group">
                                <label>Confirm password</label>
                                <input type="password" id="confpassword" name="confpassword" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"> Register </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Form End -->

        <div class="card mb-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-10">
                        <h6>Agricultural Extension Officers</h6>
                    </div>
                    <div class="col-md-2 float-right">
                        <button class="btn btn-sm btn-primary float-right" data-toggle="collapse"
                            data-target="#newCollapse">
                            <span data-feather="fa fa-plus-circle"></span> New
                        </button>
                    </div>
                </div>


            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Mail</th>
                                <th>Mobile</th>
                                <th>Ward</th>
                                <th>District</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Mail</th>
                                <th>Mobile</th>
                                <th>Ward</th>
                                <th>District</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php foreach($extension_oficcers as $row): ?>
                            <tr id="<?php echo $row['user_id']; ?>">
                                <td><?= esc($row['first_name']) ?></td>
                                <td><?= esc($row['last_name']) ?></td>
                                <td><?= esc($row['email']) ?></td>
                                <td><?= esc($row['phone']) ?></td>
                                <td><?= esc($row['ward_name']) ?></td>
                                <td><?= esc($row['district_name']) ?></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-primary deleteBtn"
                                            id="<?= esc($row['user_id']) ?>">Trash</button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>

<?= $this->section("scripts") ?>
<script type="text/javascript">
    $(function () {
        $("#addUser").validate({
            rules: {
                first_name: {
                    required: true,
                    minlength: 3,
                },
                last_name: {
                    required: true,
                    minlength: 3,
                },
                ward: {
                    required: true,
                    number: true,
                },
                phone: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true,
                },
                password: {
                    required: true,
                    minlength: 6,
                    maxlength: 15,
                },
                confpassword: {
                    required: true,
                    minlength: 6,
                    maxlength: 15,
                    equalTo: "#password",
                },
            },
            messages: {},

            submitHandler: function () {
                var formdata = $('#addUser').serialize();
                $.ajax({
                    url: "<?= esc(base_url('home/extension-officers')) ?>",
                    type: "POST",
                    data: formdata,
                    dataType: "JSON",
                    success: function (data) {
                        if (data.status) {
                            location.reload();
                        } else {
                            $('#error_message').fadeIn().html(data.data);
                            setTimeout(function () {
                                $('#error_message').fadeOut("slow");
                            }, 4000);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $('#error_message').fadeIn().html(
                            'An error occured, request not sent' + textStatus);
                        setTimeout(function () {
                            $('#error_message').fadeOut("slow");
                        }, 3000);
                    }
                });
            }
        });
    });


    // Delete 
    $('.deleteBtn').click(function () {
        var el = this;
        var deleteid = $(this).attr('id');

        bootbox.confirm("Do you really want to delete this record?", function (result) {
            if (result) {
                $.ajax({
                    url: "<?= esc(base_url('home/extension-officers/delete')) ?> ",
                    type: 'POST',
                    dataType: "JSON",
                    data: {
                        [csrfName]: csrfHash,
                        id: deleteid
                    },
                    success: function (response) {
                        if (response.status) {
                            $(el).closest('tr').css('background', 'tomato');
                            $(el).closest('tr').fadeOut(800, function () {
                                $(this).remove();
                            });
                        } else {
                            bootbox.alert(responce.data);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        bootbox.alert(responce.data);
                    }
                });
            }
        });
    });
</script>
<?= $this->endSection() ?>