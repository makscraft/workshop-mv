<?php
$record = $mv -> products -> findProductRecord($mv -> router);
$mv -> display404($record);
$mv -> seo -> mergeParams($record, 'name');

include $mv -> views_path.'main-header.php';
?>
<main class="workshop">
    <div class="breadcrumbs">
        <a href="<?php echo $mv -> root_path; ?>">Home</a>
        <a href="<?php echo $mv -> root_path; ?>catalog">Catalog Root</a>
        <?php echo $mv -> products -> displayBreadcrumbs($record -> id, 'catalog', 'url'); ?>
    </div>
	<section class="item-details">
		<h1><?php echo $record -> name; ?></h1>
    </section>
</main>
<?php
include $mv -> views_path.'main-footer.php';
?>