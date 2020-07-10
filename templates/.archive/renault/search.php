<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
</head>
<body>
<table class="table">
    <thead class="table-head">
    <tr class="table-row bottom-line">
        <td class="table-cell">Номер</td>
        <td class="table-cell">Описание</td>
    </tr>
    </thead>
    <tbody class="table-body">
    <?php foreach ($numbers as $k => $number) { ?>
        <tr class="table-row bottom-line">
            <td class="table-cell">
                <a href="<?php echo "/{$hrefPrefix}{$number->type}/{$number->mark}/{$number->model}/{$number->modification}/{$number->category}/{$number->subgroup_short_name}?number={$src}" ?>">
                    <?php echo $src ?>
                </a>
            </td>
            <td class="table-cell"><?php echo "{$number->model_name} ({$number->modification_name}) -> {$number->category_name}" ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</body>
</html>
