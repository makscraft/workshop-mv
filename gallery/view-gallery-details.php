<?php
$record = $mv -> Gallery -> findGalleryRecord($mv -> router);
$mv -> display404($record);
$mv -> seo -> mergeParams($record, 'name');

include $mv -> views_path.'main-header.php';
?>
<main class="workshop">
	<section class="item-details">
		<h1><?php echo $record -> name; ?></h1>
		<section class="content editable">
			<p><?php echo nl2br($record -> content); ?></p>
		</section>
		<section class="items-gallery">
			<?php echo $mv -> Gallery -> displayGallery($record); ?>
		</section>        
    </section>
</main>
<?php
include $mv -> views_path.'main-footer.php';
?>