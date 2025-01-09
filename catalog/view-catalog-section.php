<?php
$record = $mv -> catalogs -> defineCatalogPage($mv -> router);
$mv -> display404($record);
$mv -> seo -> mergeParams($record, 'name');

$has_products = $mv -> products -> countRecords(['catalog' => $record -> id]);

include $mv -> views_path.'main-header.php';
?>
<main class="workshop">
    <div class="breadcrumbs">
        <a href="<?php echo $mv -> root_path; ?>">Home</a>
        <a href="<?php echo $mv -> root_path; ?>catalog">Catalog Root</a>
        <?php echo $mv -> catalogs -> displayBreadcrumbs($record -> id, 'catalog', 'url'); ?>
    </div>
    <section class="columns">
        <section class="left">
            <ul class="catalog-tree">
                <?php echo $mv -> catalogs -> displayCatalogTreeMenu(-1, $record); ?>
            </ul>
        </section>
        <section class="right">
            <h1><?php echo $record -> name; ?></h1>
            <section class="items-list gallery">
                <?php
                    if($has_products)
                        echo $mv -> products -> display(['catalog' => $record -> id]);
                    else
                        echo $mv -> catalogs -> displayCatalogSection($record);
                ?>
		    </section>
        </section>
    </section>
</main>
<?php
include $mv -> views_path.'main-footer.php';
?>