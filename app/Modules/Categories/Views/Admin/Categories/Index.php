<section class="content-header">
    <h1><?= __d('categories', 'Categories'); ?></h1>
    <ol class="breadcrumb">
        <li><a href='<?= site_url('admin/dashboard'); ?>'><i class="fa fa-dashboard"></i> <?= __d('dashboard', 'Dashboard'); ?></a></li>
        <li><i class="fa fa-th-list"></i> <?= __d('categories', 'Categories'); ?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

<?= Session::getMessages(); ?>

<div class="box box-widget">
    <div class="box-body">
        <h4><strong><?= __d('categories', 'Categories page'); ?></strong></h4>
        <p><?= __d('categories', 'Here we can configure tickets categories.'); ?></p>
    </div>
</div>

</section>
