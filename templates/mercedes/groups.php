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
<div style="height: initial;">
    <span class="a2d--groups a2d--groups_lvl1">
        <?php foreach ($groups as $group) {?>
            <span class="a2d--groups_name">
                <span class="name">
                    <span><?php echo $group->name ?></span>
                    <span class="beforePlus">+</span>
                    <span class="beforeMinus">-</span>
                </span>
                <span class="a2d--groups_lvl2">
                <?php foreach ($group->subgroups as $subgroup) {?>
                    <?php if (!property_exists($subgroup,'items')) { ?>
                        <span class="a2d--groups_name">
                            <a href="<?php echo "/{$hrefPrefix}{$group->type}/{$group->mark}/{$group->country}/{$group->aggregation}/{$group->model}/{$group->catalog}/{$group->short}/{$subgroup->short}" ?>">
                                <span class="name end"><?php echo $subgroup->name ?></span>
                            </a>
                        </span>
                    <?php } else {?>
                        <span class="a2d--groups_name">
                            <span class="name">
                                <span><?php echo $subgroup->name.($subgroup->codes ? ' (Коды: '.implode(',', $subgroup->codes).')' : '') ?></span>
                                <span class="beforePlus">+</span>
                                <span class="beforeMinus">-</span>
                            </span>
                            <span class="a2d--groups_lvl3">
                                <?php foreach ($subgroup->items as $stroke) {?>
                                    <a href="<?php echo "/{$hrefPrefix}{$group->type}/{$group->mark}/{$group->country}/{$group->aggregation}/{$group->model}/{$group->catalog}/{$group->short}/{$stroke->subgroup_id}/{$subgroup->short}/{$stroke->stroke_id}" ?>">
                                        <span class="name end"><?php echo $stroke->description ?></span>
                                    </a>
                                <?php } ?>
                            </span>
                        </span>
                    <?php } ?>
                <?php } ?>
                </span>
            </span>
        <?php } ?>
    </span>
</div>
</body>
</html>
