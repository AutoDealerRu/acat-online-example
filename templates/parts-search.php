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
    <?php foreach ($numbers as $item) {
        $modification = $item->modification ? $item->modification->id : 'null';
        $url = "$hrefPrefix/{$item->type->id}/{$item->mark->id}/{$item->model->id}/$modification/{$item->group->parentId}/{$item->group->id}?number={$item->number->number}"
        ?>
        <tr class="table-row bottom-line">
            <td class="table-cell">
                <a href="<?php echo $url ?>">
                    <?php echo $item->number->number ?>
                </a>
            </td>
            <td class="table-cell"><?php echo $item->number->name ?></td>
            <td class="table-cell"><?php echo $item->number->description ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</body>
</html>
