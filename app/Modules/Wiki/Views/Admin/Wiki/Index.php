<section class="content-header">
    <h1><?= __d('wiki', 'Wiki'); ?></h1>
    <ol class="breadcrumb">
        <li><a href='<?= site_url('admin/dashboard'); ?>'><i class="fa fa-dashboard"></i> <?= __d('dashboard', 'Dashboard'); ?></a></li>
        <li><i class="fa fa-wikipedia-w"></i> <?= __d('wiki', 'Wiki'); ?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

<?= Session::getMessages(); ?>

<div class="row">
    <div class="col-md-7">
        <div class="box box-info">
            <div class="box-header">
                <h3>Heroes</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body heroes-container">
                <?= $heroes; ?>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="box box-info">
            <div class="box-header">
                <h3>Items</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body items-container">
                Items Table
            </div>
        </div>
    </div>
</div>

</section>
