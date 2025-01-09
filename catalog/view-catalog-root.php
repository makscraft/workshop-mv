<?php
$mv -> seo -> mergeParams('Catalog');

include $mv -> views_path.'main-header.php';
?>
<main class="workshop">
	<div class="breadcrumbs">
        <a href="<?php echo $mv -> root_path; ?>">Home</a>
        <span>Catalog Root</span>
    </div>	
	<section>
		<h1>Catalog Root</h1>
		<section class="items-list">
            <ul>
			    <?php echo $mv -> catalogs -> displayRootCatalogMenu(); ?>
            </ul>
		</section>
    </section>
</main>
<?php
include $mv -> views_path.'main-footer.php';
?>