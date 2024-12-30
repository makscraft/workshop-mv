<?php
$record = $mv -> articles -> findArticleRecord($mv -> router);
$mv -> display404($record);
$mv -> seo -> mergeParams($record, 'name');

include $mv -> views_path.'main-header.php';
?>
<main class="workshop">
	<section class="item-details">
		<h1><?php echo $record -> name; ?></h1>
        <div class="date"><?php echo I18n::formatDate($record -> date); ?></div>
        <?php echo $record -> resizeImage('image', 640, 480); ?>
		<section class="content editable">
			<?php echo $record -> content; ?>
		</section>
        <div class="previous-next">
            <?php echo $mv -> articles -> displayPreviousAndNext($record); ?>
        </div>
    </section>
</main>
<?php
include $mv -> views_path.'main-footer.php';
?>