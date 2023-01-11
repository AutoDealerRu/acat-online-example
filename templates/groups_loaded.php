<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
    <script src="//code.jquery.com/jquery-1.7.2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.a2d--groups_lvl1 .a2d--groups_name .name:not(.end)').on('click', function() {
                if ($(this).hasClass('on')) {
                    $(this).parent().find('.on').removeClass('on');
                } else {
                    $(this).addClass('on').siblings().addClass('on');
                }
            });
        });
    </script>
</head>
<body>
<?php require __DIR__ . '/breadcrumbs.php'; ?>
<div class="a2d--model">
    <span class="a2d--model_image">
        <?php if ($model->image) { ?>
            <img src="<?php echo $model->image ?>">
        <?php } else { ?>
            <img src="https://acat.online/catalog-images/avtodiler.png">
        <?php } ?>
    </span>
    <span class="a2d--model_info">
        <ul>
            <li>Модель: <b><?php echo $model->name ?></b></li>
            <?php if ($model->relevance) { ?>
            <li>Актуальность: <b><?php echo $model->relevance ?></b></li>
            <?php } ?>
            <?php if ($model->modification) { ?>
            <li>Модификации: <b><?php echo $model->modification ?></b></li>
            <?php } ?>
        </ul>
    </span>
</div>
<div style="height: initial;">
    <span class="a2d--groups a2d--groups_lvl1">
        <?php foreach ($groups as $groupLvl1) {?>
            <span class="a2d--groups_name">
                <span class="name <?php echo $groupLvl1->subGroups ? '' : 'end' ?>">
                    <?php echo $groupLvl1->name ?>
                    <span class="beforePlus">+</span>
                    <span class="beforeMinus">-</span>
                </span>
                <?php if ($groupLvl1->subGroups) { ?>
                <span class="a2d--groups_lvl2">
                    <?php foreach ($groupLvl1->subGroups as $subgroup) {?>
                        <span class="a2d--groups_name">
                            <span class="name <?php echo $subgroup->subGroups ? '' : 'end' ?>">
                                <?php echo $subgroup->name ?>
                                <span class="beforePlus">+</span>
                                <span class="beforeMinus">-</span>
                            </span>
                            <?php if ($subgroup->subGroups) { ?>
                            <div class="a2d--groups_lvl3">
                                <div style="background: #eefce9; cursor: default">
                                    <div class="fiat_units">
                                        <?php $maxLength = 82; foreach ($subgroup->subGroups as $subgroup2) {?>
                                            <div class="fiat_units-block">
                                                <a href="<?php echo "{$hrefPrefix}/{$type->id}/{$mark->id}/{$model->id}/null/{$subgroup2->parentId}/{$subgroup2->id}"; ?>">
                                                    <div class="fiat_unit m-0" <?php echo $subgroup2->name && strlen($subgroup2->name) > $maxLength ? ' title="' . $subgroup2->name.'"' : ''?> >
                                                        <div class="fiat_units_image">
                                                            <img src="<?php echo $subgroup2->image?>" alt="<?php echo $subgroup2->name ?>">
                                                        </div>
                                                        <?php if ($subgroup2->name && strlen($subgroup2->name) > $maxLength) { ?>
                                                            <div class="fiat_units_name"><?php echo substr($subgroup2->name, 0, $maxLength - 3).'...' ?></div>
                                                        <?php }  else { ?>
                                                            <div class="fiat_units_name"><?php echo $subgroup2->name ?></div>
                                                        <?php } ?>
                                                    </div>
                                                </a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </span>
                    <?php } ?>
                </span>
                <?php } ?>
            </span>
        <?php } ?>
    </span>
</div>
</body>
</html>