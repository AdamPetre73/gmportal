<section class="content-header">
    <h1><?= __d('users', 'Create Role'); ?></h1>
    <ol class="breadcrumb">
        <li><a href='<?= site_url('admin/dashboard'); ?>'><i class="fa fa-dashboard"></i> <?= __d('users', 'Dashboard'); ?></a></li>
        <li><a href='<?= site_url('admin/roles'); ?>'><?= __d('users', 'Roles'); ?></a></li>
        <li><?= __d('users', 'Create Role'); ?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

<?= Session::getMessages(); ?>

<form action="<?= site_url('admin/forms'); ?>" method="POST" role="form">
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"><?= __d('forms', 'Create a new Form'); ?></h3>
    </div>
    <div class="box-body">
       
        <div class="row">
            <div class="col-md-3 text-right">
                <label class="control-label" for="name"><?= __d('forms', 'Form Name'); ?> <font color='#CC0000'>*</font></label>    
            </div>
            <div class="col-md-6">
                <input name="name" id="name" type="text" class="form-control" value="<?= Input::old('name'); ?>" placeholder="<?= __d('forms', 'Form Name'); ?>">
            </div>
        </div>
        <div class="row">
            <div class="clearfix"></div>
        </div>
        
        
    </div>
</div>
<input type="hidden" name="csrfToken" value="<?= $csrfToken; ?>">
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"><?= __d('forms', 'Add Questions'); ?></h3>
        <button type="button" class="btn btn-success add-question pull-right"><i class="fa fa-plus"></i> Add another question</button>
    </div>
    <div class="box-body">
        <div id="questions"></div>
        <div class="row text-center">
            <input type="submit" name="submit" class="btn btn-success" value="<?= __d('forms', 'Save'); ?>">
        </div>
    </div>
</div>

</form>

</section>

<template id="question-template">
    <div class="row question-row">
        <div class="col-md-3 text-right">
            <label class="control-label" for="question"><?= __d('forms', 'Question'); ?> <font color='#CC0000'>*</font></label>
        </div>
        <div class="col-md-6">
            <input name="questions[]" id="question" type="text" class="form-control" value="" placeholder="<?= __d('forms', 'Question'); ?>">
        </div>
    </div>
    <div class="row answer-type-row">
        <div class="col-md-3 text-right">
            <label class="control-label" for="answer-type"><?= __d('forms', 'Answer Type'); ?> <font color='#CC0000'>*</font></label>
        </div>
        <div class="col-md-6">
            <select name="answer-types[]" id="answer-type" class="form-control answer-type" onchange="answerType(event);" required>
                <option value=""><?= __d('forms', 'Select Answer Type'); ?></option>
                <?php foreach($answerTypes as $aType){ ?>
                <option value="<?= $aType->id; ?>"><?= $aType->answer_type; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="row answers"></div>
    <div class="row separator-row">
        <hr>
    </div>

</template>

<template id="answer-template">
    <div class="row answer">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <input type="text" name="answers[]" class="form-control">
        </div>
        <div class="col-md-3">
            <button type="button" onclick="addAnswer(event);" class="btn btn-sm btn-info"><i class="fa fa-plus"></i></button>
        </div>
    </div>
</template>

<script type="text/javascript" src="<?= template_url('js/createForm.js', 'AdminLte'); ?>" defer></script>