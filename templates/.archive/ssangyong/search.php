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
                    <a href="<?php echo "/{$hrefPrefix}CARS_FOREIGN/SSANGYONG/{$number->model}/{$number->subgroup}?number={$number->number}" ?>">
                        <?php echo $number->number ?>
                    </a>
                </td>
                <td class="table-cell"><?php echo $number->number_name ?></td>
                <td class="table-cell"><p><?php echo "{$number->model_name} -> {$number->group_name} -> {$number->subgroup_name}" ?></p></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</body>
</html>
