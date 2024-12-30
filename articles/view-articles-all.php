<?php
$mv -> seo -> mergeParams('Articles');

$total = $mv -> articles -> countRecords(['active' => 1]);
$mv -> articles -> runPaginator($total, 1);

include $mv -> views_path.'main-header.php';
?>
<main class="workshop">
	<section>
		<h1>Articles</h1>
		<section class="items-list">
			<?php echo $mv -> articles -> display(); ?>
		</section>
        <?php if($mv -> articles -> paginator -> hasPages()): ?>
            <div class="paginator">
                <span>Page:</span>
                <?php echo $mv -> articles -> paginator -> display($mv -> root_path.'articles'); ?>
            </div>
        <?php endif; ?>
    </section>
</main>
<?php
include $mv -> views_path.'main-footer.php';
?>