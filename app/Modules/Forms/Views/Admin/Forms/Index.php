<section class="content-header">
    <h1><?= __d('dashboard', 'Dashboard'); ?></h1>
    <ol class="breadcrumb">
        <li><a href='<?= site_url('admin/dashboard'); ?>'><i class="fa fa-dashboard"></i> <?= __d('dashboard', 'Dashboard'); ?></a></li>
        <li><i class="fa fa-dashboard"></i> <?= __d('forms', 'Forms'); ?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

<?= Session::getMessages(); ?>

<?php if(empty($forms)){ ?>
<div class="box box-widget">
    <div class="box-header with-border">
        <h4>
            <strong><?= __d('forms', 'Forms'); ?></strong>
            <a href="/admin/forms/create" class="btn btn-success pull-right"><i class="fa fa-plus"></i> <?= __d('forms','Add form'); ?></a>
        </h4>
    </div>
    <div class="box-body">
        <p><?= __d('forms', 'You\'ll see all the forms here'); ?></p>
    </div>
</div>
<?php } else { ?>
<div class="box box-widget">
    <div class="box-header with-border">
        <h4>
            <strong><?= __d('forms', 'Forms'); ?></strong>
            <a href="/admin/forms/create" class="btn btn-success pull-right"><i class="fa fa-plus"></i> <?= __d('forms','Add form'); ?></a>
        </h4>
    </div>
    <div class="box-body">
        
    </div>
</div>
<?php } ?>
</section>
