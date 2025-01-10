<?php
$url = $mv -> router -> getUrlPart(1);
$conditions = is_numeric($url) ? ['id' => $url] : ['url' => $url];
$conditions['active'] = 1;

$record = $mv -> news -> find($conditions);
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
	</section>
</main>
<?php
include $mv -> views_path.'main-footer.php';
?>