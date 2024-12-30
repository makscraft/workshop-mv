<?php
$mv -> seo -> mergeParams('Options');

include $mv -> views_path.'main-header.php';
?>
<main class="workshop">
	<section>
		<h1>Options</h1>
        
        <section class="item-details">
            <h3>Single fields</h3>
            <ul>
                <li><?php echo $mv -> options -> allow_something; ?></li>
                <li><?php echo $mv -> options -> admin_email; ?></li>
                <li><?php echo $mv -> options -> getSelectedEnumTitle('choice'); ?></li>
            </ul>
            <h3>All fields</h3>
            <?php Debug::pre($mv -> options -> all()); ?>
        </section>
        
        <h3>Simple gallery</h3>
		<section class="items-gallery">
			<?php echo $mv -> options -> displaySimpleGallery(); ?>
		</section>
        <?php if(0): ?>

        <?php endif; ?>
    </section>
</main>
<?php
include $mv -> views_path.'main-footer.php';
?>