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
<?php require __DIR__ . '/../breadcrumbs.php'; ?>
<div style="height: initial;">
    <span class="a2d--groups a2d--groups_lvl1">
        <?php foreach ($groups as $item) {?>
            <span class="a2d--groups_name">
                <span class="name <?php echo $item->subgroups ? '' : 'end' ?>">
                    <?php echo $item->name ?>
                    <span class="beforePlus">+</span>
                    <span class="beforeMinus">-</span>
                </span>
                <span class="a2d--groups_lvl2">
                    <?php foreach ($item->subgroups as $subgroup) {?>
                        <span class="a2d--groups_name">
                            <span class="name end">
                                <a href="/<?php echo "{$hrefPrefix}{$item->type}/{$item->mark_short_name}/{$item->model_short_name}/{$subgroup->short_name}" ?>">
                                    <?php echo $subgroup->name ?>
                                </a>
                            </span>
                        </span>
                    <?php } ?>
                </span>
            </span>
        <?php } ?>
    </span>
</div>
</body>
</html>
