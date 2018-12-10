<?php if ($breadcrumbs) { ?>
    <div class="breadcrumbs">
    <?php foreach ($breadcrumbs as $index => $breadcrumb) {
        if ($index != (count($breadcrumbs)-1)) {
            if ($index > 0) {
                $breadcrumbUrl = "{$hrefPrefix}/";
                $i = 1;
                while ($i < ($index+1)) {
                    $breadcrumbUrl .= $breadcrumbs[$i]->url."/";
                    $i++;
                }
                $breadcrumbUrl = preg_replace("/\/$/", "", $breadcrumbUrl);
                $breadcrumbUrl = preg_replace("/^\/\//", "/", $breadcrumbUrl); ?>
                <a href="<?php echo $breadcrumbUrl ?>"><?php echo $breadcrumb->name ?></a>
            <?php } else {
                $breadcrumbUrl = "{$hrefPrefix}/" . preg_replace("/^\//", "", $breadcrumb->url); ?>
                <a href="<?php echo $breadcrumbUrl ?>"><?php echo $breadcrumb->name ?></a>
            <?php }
        } else { ?>
            <span class="breadcrumbs_current"><?php echo $breadcrumb->name ?></span>
        <?php }
    } ?>
    </div>
<?php } ?>