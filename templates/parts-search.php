<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
</head>
<body>
<table class="table" style="<?php echo $page > 1 || $hasNextPage ? 'margin-bottom: 24px' : '' ?>">
    <thead class="table-head">
    <tr class="table-row bottom-line">
        <td class="table-cell">Номер</td>
        <td class="table-cell">Название</td>
        <td class="table-cell">
            <div style="display: flex; justify-content: space-between">
                <div>Описание</div>
                <?php if ($totalCount) { ?>
                    <div style="text-transform: initial;">
                        <div>Всего: <?php echo $totalCount?></div>
                    </div>
                <?php } ?>
            </div>
        </td>
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
<?php if ($page > 1 || $hasNextPage) { ?>
    <div style="display: flex; flex-direction: row; align-items: center; justify-content: start">
    <?php if ($page > 1) {?>
        <form class="catalog_search" method='GET' action='<?php echo "$hrefPrefix/parts-search" ?>'>
            <?php if (is_array($qp) && $qp['type']) { ?><input type="hidden" name="type" value="<?php echo $qp['type'] ?>"> <?php } ?>
            <?php if (is_array($qp) && $qp['mark']) { ?> <input type="hidden" name="mark" value="<?php echo $qp['mark'] ?>"> <?php } ?>
            <?php if (is_array($qp) && $qp['model']) { ?> <input type="hidden" name="model" value="<?php echo $qp['model'] ?>"> <?php } ?>
            <input type="hidden" name="search" value="<?php echo $qp['search'] ?>">
            <input type="hidden" name="page" value="<?php echo (int)$page - 1 ?>">
            <input class="button button--green" type='submit' value="Назад" style="margin-left: 0">
        </form>
    <?php } ?>
    <?php if ($hasNextPage) {?>
        <form class="catalog_search" method='GET' action='<?php echo "$hrefPrefix/parts-search" ?>'>
            <?php if (is_array($qp) && $qp['type']) { ?><input type="hidden" name="type" value="<?php echo $qp['type'] ?>"> <?php } ?>
            <?php if (is_array($qp) && $qp['mark']) { ?> <input type="hidden" name="mark" value="<?php echo $qp['mark'] ?>"> <?php } ?>
            <?php if (is_array($qp) && $qp['model']) { ?> <input type="hidden" name="model" value="<?php echo $qp['model'] ?>"> <?php } ?>
            <input type="hidden" name="search" value="<?php echo $qp['search'] ?>">
            <input type="hidden" name="page" value="<?php echo (int)$page + 1 ?>">
            <input class="button button--green" type='submit' value="Вперед" style="<?php echo !($page > 1) ? 'margin-left: 0' : '' ?>">
        </form>
    <?php } ?>
    </div>
<?php } ?>

</body>
</html>
