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
    <!--  На поиск без уточнения по ID модели стоит ограничение в 100 результатов  -->
    <?php foreach ($numbers as $k => $number) { ?>
        <tr class="table-row bottom-line">
            <td class="table-cell">
                <a href="<?php echo "/{$hrefPrefix}{$number->type}/{$number->mark}/{$number->series}/{$number->model}/{$number->rule}/{$number->transmission}/{$number->group}/{$number->subgroup}?number={$number->number}" ?>">
                    <?php echo $number->number ?>
                </a>
            </td>
            <td class="table-cell"><?php echo $number->number_name ?></td>
            <td class="table-cell"><?php echo "{$number->series_name} ({$number->country_name}) -> {$number->model_name} -> {$number->group_name} -> {$number->subgroup_name}" ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</body>
</html>
