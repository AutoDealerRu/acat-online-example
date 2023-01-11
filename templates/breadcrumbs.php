<?php if (isset($type) || isset($mark) || isset($model) || isset($modification) || isset($group)) { ?>
    <div class="breadcrumbs">
        <a href="<?php echo $hrefPrefix ? $hrefPrefix : '/' ?>">Каталог</a>
    <?php if (isset($type)) { ?>
        <a href="<?php echo $hrefPrefix.'/'.$type->id ?>"><?php echo $type->name ?></a>
    <?php } ?>
    <?php if (isset($mark)) { ?>
        <a href="<?php echo $hrefPrefix.'/'.$type->id.'/'.$mark->id ?>"><?php echo $mark->name ?></a>
    <?php } ?>
    <?php if (isset($model)) { ?>
        <a href="<?php echo $hrefPrefix.'/'.$type->id.'/'.$mark->id.'/'.$model->id.(!$model->hasModifications ? '/null' : '') ?>"><?php echo $model->name ?></a>
    <?php } ?>
    <?php if (isset($modification)) { ?>
        <a href="<?php echo $hrefPrefix.'/'.$type->id.'/'.$mark->id.'/'.$model->id.'/'.$modification->id ?>"><?php echo $modification->name ?></a>
    <?php } ?>
    <?php if (isset($group)) { ?>
        <a href="<?php echo $hrefPrefix.'/'.$type->id.'/'.$mark->id.'/'.$model->id.'/'.(!$model->hasModifications ? 'null' : $modification->id).'/'.$group->parentId.'/'.$group->id ?>"><?php echo $group->name ?></a>
    <?php } ?>
    </div>
<?php } ?>