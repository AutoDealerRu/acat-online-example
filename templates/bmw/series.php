<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
</head>
<body>
<?php foreach ($series as $k => $seria) {?>
    <span class="tile-block">
        <a href="/<?php echo "{$hrefPrefix}{$seria->type}/{$seria->mark_short_name}/{$seria->short_name}" ?>">
            <div class="tile-block-image">
                <?php if ($seria->image) { ?>
                    <img src="<?php echo $seria->image ?>">
                <?php } else { ?>
                    <img src="https://212709.selcdn.ru/autocatalog-online/public/images/avtodiler.png">
                <?php } ?>
            </div>
            <div class="tile-block-name" style="min-height: 75px;"><?php echo $seria->name ?></div>
            <div class="tile-block-option" style="<?php echo $seria->catalog_type == 'VT' ? 'background: white;' : '' ?>">
                <span><?php echo $seria->catalog_type == 'VT' ? '' : 'Живая традиция' ?></span>
            </div>
        </a>
    </span>
<?php } ?>
</body>
</html>
