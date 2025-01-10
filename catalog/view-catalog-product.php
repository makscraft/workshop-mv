<?php
$record = $mv -> products -> findProductRecord($mv -> router);
$mv -> display404($record);
$mv -> seo -> mergeParams($record, 'name');

$images = $record -> extractImages('images');
array_shift($images);

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
        <?php
            echo $mv -> products -> resizeImage($record -> getFirstImage('images'), 640, 480);

            if(count($images)):
        ?>
            <div class="extra-images">
                <?php
                    foreach($images as $image)
                        echo "<div>".$mv -> products -> cropImage($image['image'], 210, 160)."</div>\n";
                ?>
            </div>
        <?php endif; ?>

        <div class="price">$<?php echo $record -> price; ?></div>
		<section class="content editable">
			<?php echo $record -> content; ?>
		</section>        
    </section>
</main>
<?php
include $mv -> views_path.'main-footer.php';
?>