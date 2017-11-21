<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
</head>
<body>
<table class="table active">
    <thead class="table-head">
        <tr class="table-row bottom-line">
            <td class="table-cell">Группа</td>
            <td class="table-cell">
                <span style="width: 50%; display: block; float: left;">Подгруппа</span>
                <span style="width: 50%; display: block; float: left;">Примечание</span>
            </td>
        </tr>
    </thead>
    <tbody class="table-body">
    <?php foreach ($groups as $group) {?>
        <tr class="table-row bottom-line">
            <td class="table-cell"><?php echo $group->full_name?></td>
            <td class="table-cell" style="vertical-align: top; padding: 0;">
                <table class="table table-child">
                    <tbody class="table-body">
                    <?php foreach ($group->subgroups as $part) {
                        $url = "/{$hrefPrefix}{$breadcrumbs[1]->url}/{$breadcrumbs[2]->url}/{$breadcrumbs[3]->url}/{$breadcrumbs[4]->url}/{$breadcrumbs[5]->url}/{$part->id}/{$part->variant}"; ?>
                    <tr class="table-row bottom-line">
                        <td class="table-cell" style="width: 50%;">
                            <a href="<?php echo $url ?>"><?php echo $part->description ?></a>
                        </td>
                        <td class="table-cell" style="width: 50%;"><?php echo $part->applicability ?></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<?php if ($abbreviations && is_array($abbreviations) && count($abbreviations) > 0) { ?>
    <table class="table active">
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
