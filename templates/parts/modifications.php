<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
</head>
<body>

<?php require __DIR__ . '/../breadcrumbs.php'; ?>

<!-- Фильтры -->
<form method="get" id="acMitFiltersForm" style="margin: 8px 0 16px">
    <?php foreach ($filters as $f) {?>
        <select name="<?php echo $f->name->key ?>" onchange="document.getElementById('acMitFiltersForm').submit()">
            <option value="" <?php echo property_exists($f, 'currentValue') && !$f->currentValue ? 'selected' : '' ?>><?php echo $f->name->text ?></option>
            <?php foreach ($f->values as $v) {?>
                <option <?php echo property_exists($f, 'currentValue') && $f->currentValue === $v->id ? 'selected' : '' ?> value="<?php echo $v->id ?>">
                    <?php echo $v->text ?>
                </option>
            <?php } ?>
        </select>
    <?php } ?>
    <span style="float: right">Всего результатов: <?php echo $itemsCount ?>, показано: <?php echo count($modifications) ?></span>
</form>
<!-- Фильтры (Конец) -->

<table class="table active">
    <thead class="table-head">
        <tr class="table-row bottom-line">
            <td class="table-cell">Название</td>
            <td class="table-cell">Год</td>
            <td class="table-cell">Регион</td>
            <td class="table-cell">Описание</td>
        </tr>
    </thead>
    <tbody class="table-body">
    <?php foreach ($modifications as $modification) {
        $url = "./{$breadcrumbs[3]->url}/{$modification->id}";
    ?>
        <tr class="table-row bottom-line">
            <td class="table-cell">
                <a href="<?php echo $url ?>"><?php echo $modification->name?></a>
            </td>
            <td class="table-cell"><?php echo $modification->year?></td>
            <td class="table-cell"><?php echo $modification->region?></td>
            <td class="table-cell"><?php echo $modification->description?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<!-- Постраничная навигация-->
<script type="text/javascript">
    function go2page() {
        var ps = document.getElementById('acMitPage');
        var page = ps.options[ps.selectedIndex].value;
        if (window.location.href.indexOf('page=') !== -1) {
            console.log(1);
            window.location.href = window.location.href.replace(/page\=[\d]{1,}/, 'page='+page);
        } else {
            if (window.location.href.indexOf('?') !== -1) {
                console.log(2);
                window.location.href = window.location.href + '&page=' + page;
            } else {
                console.log(3);
                window.location.href = window.location.href + '?page=' + page;
            }
        }
    }
</script>
<form method="get">
    <select name="page" id="acMitPage" onchange="go2page()">
        <?php foreach ($pages as $p) {?>
            <option
                <?php echo $p === (int) $page ? 'selected' : '' ?>
                value="<?php echo $p ?>"

            ><!--onclick="go2page(<?php echo $p ?>); return false;"-->
                <?php echo $p ?>
            </option>
        <?php } ?>
    </select>
</form>
<!-- Постраничная навигация (конец)-->

</body>
</html>
