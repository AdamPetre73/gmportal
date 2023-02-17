<link rel="stylesheet" href="<?= template_url('css/heroPage.css', 'AdminLte'); ?>">
<link rel="stylesheet" href="<?= template_url('css/fonts.css', 'AdminLte'); ?>">
<section class="content-header">
    <h1><?= __d('wiki', 'Wiki'); ?></h1>
    <ol class="breadcrumb">
        <li><a href='<?= site_url('admin/dashboard'); ?>'><i class="fa fa-dashboard"></i> <?= __d('dashboard', 'Dashboard'); ?></a></li>
        <li><a href="<?= site_url('admin/wiki'); ?>"><i class="fa fa-wikipedia-w"></i> <?= __d('wiki', 'Wiki'); ?></a></li>
        <li><i class="fa fa-male"></i> <?= __d('wiki', $hero->name); ?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

<?= Session::getMessages(); ?>

<div class="hero-wrapper">
    <div class="col-md-6">
        <div class="info">
            <h1 class="name"><?= $hero->name; ?></h1>
            <p class="lore"><?= $hero->lore; ?></p>
        </div>
        <div class="avatars">
            <h2 class="subtitle">Avatars</h2>
            <?php foreach($images['icons'] as $k => $icon){ ?>
            <img src="<?= site_url() . 'assets/images/' . $hero->id . '/' . $icon; ?>" alt="<?= $hero->name . ' - Avatar ' . ($k + 1); ?>" class="avatar-icon" id="icon-<?= $k; ?>">
            <?php } ?>
        </div>
        <div class="abilities">
            <h2 class="subtitle">Abilities</h2>


            <?php foreach($abilities as $k => $ability){ ?>
            <div class="box ability no-border">
                <div class="box-body">
                    <div class="col-md-2">
                        <?php if($ability->icon != 'boost_50.gif'){ ?>
                        <img src="<?= site_url() . 'assets/images/' . $hero->id . '/' . $ability->icon; ?>" alt="<?= $ability->name; ?>" class="ability-icon">
                        <?php } else { ?>
                        <img src="<?= site_url() . 'assets/images/' . $ability->icon; ?>" alt="<?= $ability->name; ?>" class="ability-icon">
                        <?php } ?>
                    </div>
                    <div class="col-md-10">
                        <h4 class="ability-name"><?= $ability->name; ?> <?php if(!empty($ability->ability_key)){ ?> [<span><?= $ability->ability_key; ?></span>] <?php } ?></h4>
                        Range: <?= !empty($ability->ability_range) ? $ability->ability_range : '-';?><br>
                        Mana Cost: <?= !empty($ability->mana_cost) ? $ability->mana_cost : '-';?><br>
                    </div>
                </div>
                <div class="box-footer">
                    <?= $ability->description; ?>
                    <hr>
                    <?= $ability->description2; ?>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="info">
            <h2 class="subtitle">Info</h2>
            <div class="row">
                <div class="col-md-2">Faction: </div>
                <div class="col-md-2"><?= $hero->faction; ?></div>
            </div>
            <div class="row">
                <div class="col-md-2">Main attribute: </div>
                <div class="col-md-2"><?= $hero->main_attribute; ?></div>
            </div>
            <div class="row">
                <div class="col-md-2">Attack range: </div>
                <div class="col-md-2"><?= $hero->attack_range; ?> (<?= $hero->ranged; ?>)</div>
            </div>
        </div>
        <div class="stats">
            <h2 class="subtitle">Stats</h2>
            <div class="row">
                <div class="col-md-2 stat-name">Strength: </div>
                <div class="col-md-2 stat-value"><?= $hero->strength; ?></div>
            </div>
            <div class="row">
                <div class="col-md-2 stat-name">Agility: </div>
                <div class="col-md-2 stat-value"><?= $hero->agility; ?></div>
            </div>
            <div class="row">
                <div class="col-md-2 stat-name">Intelligence: </div>
                <div class="col-md-2 stat-value"><?= $hero->inteligence; ?></div>
            </div>
            <div class="row">
                <div class="col-md-2 stat-name">Health: </div>
                <div class="col-md-2 stat-value"><?= $hero->health; ?></div>
            </div>
            <div class="row">
                <div class="col-md-2 stat-name">Mana: </div>
                <div class="col-md-2 stat-value"><?= $hero->mana; ?></div>
            </div>
            <div class="row">
                <div class="col-md-2 stat-name">Damage: </div>
                <div class="col-md-2 stat-value"><?= $hero->damage; ?></div>
            </div>
            <div class="row">
                <div class="col-md-2 stat-name">Armor: </div>
                <div class="col-md-2 stat-value"><?= $hero->armor; ?></div>
            </div>
            <div class="row">
                <div class="col-md-2 stat-name">Magic armor: </div>
                <div class="col-md-2 stat-value"><?= $hero->magic_armor; ?></div>
            </div>
            <div class="row">
                <div class="col-md-2 stat-name">Movement speed: </div>
                <div class="col-md-2 stat-value"><?= $hero->movement_speed; ?></div>
            </div>
            <div class="row">
                <div class="col-md-2 stat-name">Health regen: </div>
                <div class="col-md-2 stat-value"><?= $hero->health_regen; ?></div>
            </div>
            <div class="row">
                <div class="col-md-2 stat-name">Base attack time: </div>
                <div class="col-md-2 stat-value"><?= $hero->base_attack_time; ?></div>
            </div>
            <div class="row">
                <div class="col-md-2 stat-name">Attack animation: </div>
                <div class="col-md-2 stat-value"><?= $hero->attack_animation; ?></div>
            </div>
            <div class="row">
                <div class="col-md-2 stat-name">Turn rate: </div>
                <div class="col-md-2 stat-value"><?= $hero->turn_rate; ?></div>
            </div>
        </div>
        
    </div>
    <div class="col-md-6 avatar" style="background-image: url('<?= site_url() . 'assets/images/' . $hero->id . '/' . $images['avatars'][0]; ?>');">
        
    </div>
</div>


</section>
<script>
let avatars = <?php echo json_encode($images['avatars']); ?>;
</script>
<script>
$('#content').ready(function(){
    let avatarDiv = document.querySelector('.avatar');
    console.log(avatarDiv);

    $('.avatar-icon').on('click', function(event){
        let icon = event.target;
        let key = icon.id.replace('icon-','');
        if(avatars[key] == undefined || avatars[key] == ''){
            avatarDiv.style = "background-image: url('/assets/images/store_missing.png');";
        } else {
            avatarDiv.style = "background-image: url('" + '/assets/images/' + <?php echo $hero->id; ?> + '/' + avatars[key] + "');";
        }
    });
});
</script>