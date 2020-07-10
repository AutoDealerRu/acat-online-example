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
        <td class="table-cell">Название</td>
        <td class="table-cell">Описание</td>
    </tr>
    </thead>
    <tbody class="table-body">
    <?php foreach ($numbers as $k => $number) { ?>
        <tr class="table-row bottom-line">
            <td class="table-cell">
                <a href="<?php echo "/{$hrefPrefix}{$number->type}/{$number->mark}/{$number->country}/{$number->model}/{$number->year}/{$number->catalog_code}/{$number->dir}/{$number->group}/{$number->group_id}/{$number->subgroup}".( $number->group == 'group' ? "/{$number->detail}":'')."?number={$number->number}" ?>">
                    <?php echo $number->number ?>
                </a>
            </td>
            <td class="table-cell"><?php echo $number->number_name ?></td>
            <td class="table-cell">
                <?php echo "{$number->model_full_name} ({$number->country_name}) -> {$number->group_name} -> " ?>
                <?php if ($number->subgroup_names && count($number->subgroup_names) > 0) foreach ($number->subgroup_names as $k => $sg) {
                    echo "{$sg->name} ({$sg->option})";
                    if ($k < count($number->subgroup_names) -1 ) echo ' / ';
                } ?>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</body>
</html>
