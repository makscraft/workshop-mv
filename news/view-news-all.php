<?php
$mv -> seo -> mergeParams('News');

$total = $mv -> news -> countRecords(['active' => 1]);
$mv -> news -> runPaginator($total, 1);

$rows = $mv -> news -> select([
    'active' => 1, 
    'order->desc' => 'date',
    'limit->' => $mv -> news -> paginator -> getParamsForSelect()
]);

include $mv -> views_path.'main-header.php';
?>
<main class="workshop">
	<section>
		<h1>News</h1>
		<section class="items-list">
			<?php foreach($rows as $row): ?>
                <div>
                    <?php $url = $mv -> root_path.'news/'.($row['url'] ? $row['url'] : $row['id']); ?>
                    <?php if($row['image']): ?>
                        <a href="<?php echo $url; ?>">
                            <?php echo $mv -> news -> cropImage($row['image'], 300, 225); ?>
                        </a>
                    <?php endif; ?>
                    <h3><a href="<?php echo $url; ?>"><?php echo $row['name']; ?></a></h3>
                    <div class="date"><?php echo I18n::formatDate($row['date']); ?></div>
                    <div class="brief"><?php echo Service::cutText($row['content'], 300, '...'); ?></div>
                    <a href="<?php echo $url; ?>">Read more</a>
                </div>
            <?php endforeach; ?>
		</section>
        <?php if($mv -> news -> paginator -> hasPages()): ?>
            <div class="paginator">
                <span>Page:</span>
                <?php echo $mv -> news -> paginator -> display($mv -> root_path.'news'); ?>
            </div>
        <?php endif; ?>
    </section>
</main>
<?php
include $mv -> views_path.'main-footer.php';
?>