<?php
$mv -> seo -> mergeParams('SimpleList');

include $mv -> views_path.'main-header.php';
?>
<main class="workshop">
	<section>
		<h1>SimpleList</h1>
            <section class="item-details">
            <ul>
                <?php echo $mv -> SimpleList -> display(); ?>
            </ul>
        </section>        
    </section>
</main>
<?php
include $mv -> views_path.'main-footer.php';
?>