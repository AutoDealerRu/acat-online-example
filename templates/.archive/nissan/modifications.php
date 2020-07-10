<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
</head>
<body>
<?php require __DIR__ . '/../breadcrumbs.php'; ?>
<table class="table active">
    <thead class="table-head">
    <tr class="table-row bottom-line">
        <td class="table-cell">Двигатель</td>
        <td class="table-cell">Производство</td>
        <td class="table-cell">Кузов</td>
        <td class="table-cell">Привод</td>
        <td class="table-cell">Трансмиссия</td>
        <td class="table-cell">Другое</td>
    </tr>
    </thead>
    <tbody class="table-body">
    <?php foreach ($modifications as $modification) {
        $url = "/{$hrefPrefix}{$modification->type}/{$modification->mark}/{$modification->country_short_name}/{$modification->directory}/{$modification->modification}";
    ?>
        <tr class="table-row bottom-line">
            <td class="table-cell"><a href="<?php echo $url ?>"><?php echo $modification->engine?></a></td>
            <td class="table-cell">
                <?php if ($modification->from_date) {
                    echo substr($modification->from_date, 8, 2).'.'.substr($modification->from_date, 5, 2).'.'.substr($modification->from_date, 0, 4);
                    if (property_exists($modification,'to_date')) echo ' - ';
                    if (property_exists($modification,'to_date')) echo (!$modification->to_date ? 'по н.в.' : substr($modification->to_date, 8, 2).'.'.substr($modification->to_date, 5, 2).'.'.substr($modification->to_date, 0, 4));
                }?>
            </td>
            <td class="table-cell"><?php echo property_exists($modification,'body') ? (!$modification->body ? ' - ' : $modification->body) : ' - ' ?></td>
            <td class="table-cell"><?php echo property_exists($modification,'drive') ? (!$modification->drive ? ' - ' : $modification->drive)  : ' - '?></td>
            <td class="table-cell"><?php echo property_exists($modification,'transmission') ? (!$modification->transmission ? ' - ': $modification->transmission) : ' - '?></td>
            <td class="table-cell">
                <?php if ($modification->other) { ?>
                <?php foreach ($modification->other as $item) {?>
                    <span><?php echo $item->name.':'.$item->value ?></span>
                    <br/>
                <?php } ?>
                <?php } ?>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<?php if ($abbreviations) { ?>
    <table class="table table-search active">
        <thead class="table-head">
        <tr class="table-row bottom-line">
            <td class="table-cell">Сокращение</td>
            <td class="table-cell">Расшифровка</td>
        </tr>
        </thead>
        <tbody class="table-body">
        <?php foreach ($abbreviations as $abbreviation) {?>
            <tr class="table-row bottom-line">
                <td class="table-cell"><?php echo $abbreviation->abbreviation?></td>
                <td class="table-cell"><?php echo $abbreviation->description?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php } ?>

</body>
</html>
