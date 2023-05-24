<?= $this->extend("templates/general") ?>

<?= $this->section("body") ?>
<style>
h5 {
  font-weight: 300;
  display: inline-block;
  padding-bottom: 5px;
  position: relative;
}
h5:before{
    content: "";
    position: absolute;
    width: 50%;
    height: 1px;
    bottom: 0;
    left: 25%;
    border-bottom: 1px solid white;
}</style>

<main>
    <div class="container-fluid">
        <ol class="breadcrumb mt-4 mb-4">
            <li class="breadcrumb-item active"><?= esc($title) ?></li>
        </ol>

        <div class="card mb-2">
            <?php if (session()->get('user_role') == 'super'): ?>
            <div class="card-header">
            <?= $pager->links() ?> 
            </div>
            <?php endif ?>
            <div class="card-body">
                <div class="row">
                    <?php if(empty($wardsWeather)) : ?>
                    <?= '<p class="ml-2"> No data </p>' ?>
                    <?php else: ?>
                    <?php foreach($wardsWeather as $row) : ?>
                    <div class="col-xl-3">
                        <div class="card bg-dark text-white mb-4">
                            <img class="card-img" style="opacity: 0.4;" height="200" src="assets/gifs/<?= $row['c_img'] ?>" alt="No image">
                            <div class="card-img-overlay">
                                <h5 class="card-title">
                                <?= esc($row['ward_name']) . '&nbsp;<small>[' . esc($row['district_name']) . ']</small>' ?>
                                </h5>
                                    <h6 class="h6 card-text"><?= esc($row['c_desc']) ?></h6>
                                    <small class="card-text">Activity:&nbsp;<?= $row['act_desc']!= NULL ? $row['act_desc']: 'Not Set' ?></small><br />
                                    <small class="card-text"><?= $row['week_description'] . '&nbsp;of&nbsp;' . $row['month_name'] ?></small>
                            </div>
                        </div>
                    </div>


                    <!-- <div class="col-xl-3">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-area mr-1"></i>
                            </div>
                            <div class="card-body">
                                <div style="width:100%;height:40;" class="card-img-overlay">
                                    <h6 class="h6"></h6>
                                    <small>Activity:
                                        </small><br />
                                    <small></small>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <?php endforeach ?>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?= $this->endSection() ?>