<section class="content-header">
    <h1><?= __d('replays', 'Replays'); ?></h1>
    <ol class="breadcrumb">
        <li><a href='<?= site_url('admin/dashboard'); ?>'><i class="fa fa-dashboard"></i> <?= __d('dashboard', 'Dashboard'); ?></a></li>
        <li><i class="fa fa-file-video-o"></i> <?= __d('replays', 'Replays'); ?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

<?= Session::getMessages(); ?>

<div class="box box-widget">
    <div class="box-body">
        <h4><strong><?= __d('replays', 'Replays page'); ?></strong></h4>
        <p><?= __d('replays', 'Here we can see and manage replays. But this category was created mainly for requesting/downloading replays.'); ?></p>
    </div>
</div>

</section>
