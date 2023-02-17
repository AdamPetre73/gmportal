<link rel="stylesheet" href="<?= template_url('css/dashboard_heroes_grid.css', 'AdminLte'); ?>">

<div class="heroes-grid">
    <div class="grid-item legion-agility">
        <?php
            foreach($heroes['legion']['agility'] as $hero){
        ?>
        <a href="/admin/wiki/heroes/<?= $hero->id; ?>">
            <img src="<?= template_url('Heroes/Archive/' . $hero->id . '/' . $hero->icon ,'AdminLte'); ?>" alt="<?= $hero->name; ?>" class="hero-icon">
        </a>
        <?php
            }
        ?>
    </div>
    <div class="grid-item hellbourne-agility">
        <?php
            foreach($heroes['hellbourne']['agility'] as $hero){
        ?>
        <a href="/admin/wiki/heroes/<?= $hero->id; ?>">
            <img src="<?= template_url('Heroes/Archive/' . $hero->id . '/' . $hero->icon ,'AdminLte'); ?>" alt="<?= $hero->name; ?>" class="hero-icon">
        </a>
        <?php
            }
        ?>
    </div>
    <div class="grid-item legion-intelligence">
        <?php
            foreach($heroes['legion']['intelligence'] as $hero){
        ?>
        <a href="/admin/wiki/heroes/<?= $hero->id; ?>">
            <img src="<?= template_url('Heroes/Archive/' . $hero->id . '/' . $hero->icon ,'AdminLte'); ?>" alt="<?= $hero->name; ?>" class="hero-icon">
        </a>
        <?php
            }
        ?>
    </div>
    <div class="grid-item hellbourne-intelligence">
        <?php
            foreach($heroes['hellbourne']['intelligence'] as $hero){
        ?>
        <a href="/admin/wiki/heroes/<?= $hero->id; ?>">
            <img src="<?= template_url('Heroes/Archive/' . $hero->id . '/' . $hero->icon ,'AdminLte'); ?>" alt="<?= $hero->name; ?>" class="hero-icon">
        </a>
        <?php
            }
        ?>
    </div>
    <div class="grid-item legion-strength">
        <?php
            foreach($heroes['legion']['strength'] as $hero){
        ?>
        <a href="/admin/wiki/heroes/<?= $hero->id; ?>">
            <img src="<?= template_url('Heroes/Archive/' . $hero->id . '/' . $hero->icon ,'AdminLte'); ?>" alt="<?= $hero->name; ?>" class="hero-icon">
        </a>
        <?php
            }
        ?>
    </div>
    <div class="grid-item hellbourne-strength">
        <?php
            foreach($heroes['hellbourne']['strength'] as $hero){
        ?>
        <a href="/admin/wiki/heroes/<?= $hero->id; ?>">
            <img src="<?= template_url('Heroes/Archive/' . $hero->id . '/' . $hero->icon ,'AdminLte'); ?>" alt="<?= $hero->name; ?>" class="hero-icon">
        </a>
        <?php
            }
        ?>
    </div>
</div>