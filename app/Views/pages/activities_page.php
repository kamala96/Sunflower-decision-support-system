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
                    Add Seasonal Activity
                </div>
                <div class="card-body">
                    <form id="addActicity" method="post" action="javascript:void(0);">
                        <?= csrf_field() ?>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Week</label>
                                <select name="week" id="week" class="form-control">
                                    <option selected disabled> Choose...</option>
                                    <?php foreach($weeks as $row): ?>
                                    <option value="<?= esc($row['week_id']) ?>">
                                        <?= esc(ucwords($row['week_description'])) ?>
                                    </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Month</label>
                                <select name="month" id="month" class="form-control">
                                    <option selected disabled> Choose...</option>
                                    <?php foreach($months as $row): ?>
                                    <option value="<?= esc($row['month_id']) ?>">
                                        <?= esc(ucwords($row['month_name'])) ?>
                                    </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Constraint</label>
                                <select name="requiremet" id="requiremet" class="form-control">
                                    <option selected disabled> Choose...</option>
                                    <?php foreach($classifiers as $row): ?>
                                    <option value="<?= esc($row['c_id']) ?>"> <?= esc(ucwords($row['c_desc'])) ?>
                                    </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Activity description</label>
                                <textarea id="description" name="description" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"> Submit </button>
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
                        <h6>Sunflower Seasonal Activity in Singida Region</h6>
                    </div>
                    <div class="col-md-2 float-right">
                        <button class="btn btn-sm btn-primary float-right" data-toggle="collapse"
                            data-target="#newCollapse">
                            <span data-feather="fa fa-plus-circle"></span> Add Actvity
                        </button>
                    </div>
                </div>


            </div>
            <div class="card-body">
                <?php if(empty($activities)) : ?>
                <?= '<p> No activity! </p>' ?>
                <?php else : ?>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Week</th>
                                <th>Month</th>
                                <th>Activity</th>
                                <th>Constraint</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Week</th>
                                <th>Month</th>
                                <th>Activity</th>
                                <th>Constraint</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php foreach($activities as $row): ?>
                            <tr id="<?= $row['act_id'] ?>">
                                <td><?= esc($row['week_description']) ?></td>
                                <td><?= esc($row['month_name']) ?></td>
                                <td><?= esc($row['act_desc']) ?></td>
                                <td>
                                    <?= $row['fullReq'] ?>

                                    <button class="btn btn-sm btn-outline-primary addBtn" data-id="<?= $row['act_id'] ?>"
                                        title="Add Requirement">
                                        <i class="fas fa-plus-circle"></i>
                                    </button>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-primary deleteBtn"
                                            id="<?= esc($row['act_id']) ?>" title="Delete Activity">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>

<?= $this->section("scripts") ?>
<script type="text/javascript">
    $(function () {
        $("#addActicity").validate({
            rules: {
                week: {
                    required: true,
                    number: true,
                },
                month: {
                    required: true,
                    number: true,
                },
                description: {
                    required: true,
                },
                requiremet: {
                    required: true,
                }
            },
            messages: {},

            submitHandler: function () {
                var formdata = $('#addActicity').serialize();
                $.ajax({
                    url: "<?= esc(base_url('home/activities')) ?>",
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
                    url: "<?= esc(base_url('home/activities/delete')) ?> ",
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


    var options = <?= json_encode($classifiers2) ?> ;
    $('.addBtn').click(function () {
        var el = this;
        var id = $(this).attr('data-id');
        bootbox.prompt({
            title: "Select Additional Constraint",
            inputType: "select",
            inputOptions: options,
            callback: function (result) {
                showResult(result, id);
            }
        });
    });

    function showResult(result, id) {
        if (typeof result !== "undefined" && result !== null) {
                $("#isloading").show();
                $.ajax({
                    url: "<?= esc(base_url('home/activities_json')) ?>",
                    type: 'POST',
                    dataType: "JSON",
                    data: {
                        [csrfName]: csrfHash,
                        id: id,
                        add: result,
                    },
                    success: function (response) {
                        $("#isloading").hide();
                        if (response.status) {
                            bootbox.alert(response.data.toString(), function (action) {
                                location.reload();
                            });
                        } else {
                            bootbox.alert(response.data.toString());
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $("#isloading").hide();
                        bootbox.alert(errorThrown.toString());
                    }
                });
        }
    }
</script>
<?= $this->endSection() ?>