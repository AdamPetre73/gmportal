<section class="content-header">
    <h1><?= __d('tickets', 'Tickets'); ?></h1>
    <ol class="breadcrumb">
        <li><a href='<?= site_url('admin/dashboard'); ?>'><i class="fa fa-dashboard"></i> <?= __d('dashboard', 'Dashboard'); ?></a></li>
        <li><i class="fa fa-ticket"></i> <?= __d('tickets', 'Tickets'); ?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

<?= Session::getMessages(); ?>

<?php if(empty($tickets)){ ?>
    <div class="box box-widget">
        <div class="box-body">
            <h4><strong><?= __d('tickets', 'Tickets page'); ?></strong></h4>
            <p><?= __d('tickets', 'We\'ll see the list of tickets here.'); ?></p>
        </div>
    </div>
<?php } else { ?>
    <div class="box box-widget">
        <div class="box-body">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Ticket #</th>
                        <th scope="col">Match #</th>
                        <th scope="col">Reporter</th>
                        <th scope="col">Reported</th>
                        <th scope="col">Category</th>
                        <th scope="col" colspan="3">User Description</th>
                        <th scope="col" colspan="3">Decisions</th>
                        <th scope="col" class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($tickets as $ticket){ ?>
                    <tr>
                        <td scope="col"><?= $ticket->id; ?></td>
                        <td scope="col"><?= $ticket->match_id; ?></td>
                        <td scope="col"><?= $ticket->reporter; ?></td>
                        <td scope="col"><?= $ticket->reported; ?></td>
                        <td scope="col"><?= $ticket->category; ?></td>
                        <td scope="col" colspan="3"><?= $ticket->user_description; ?></td>
                        <td scope="col" colspan="3"><?= !empty($decisions) ? $decisions : ''; ?></td>
                        <td scope="col" class="text-right">
                            <!-- Simple button for GM -->
                            <?php if($currentRole >= 5){ ?>
                            <button type="button" class="btn btn-secondary"><i class="fa fa-eye"></i> View</button>
                            <?php } ?>
                            <!-- Button group for superior roles -->
                            <?php if($currentRole < 5){ ?>
                            <div class="btn-group">
                                <button type="button" class="btn btn-secondary"><i class="fa fa-eye"></i> View</button>
                                <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Separated link</a>
                                </div>
                            </div>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php } ?>

</section>
