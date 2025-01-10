<?php
$mv -> seo -> mergeParams('Gallery');

$total = $mv -> Gallery -> countRecords(['active' => 1]);
$mv -> Gallery -> runPaginator($total, 9);

include $mv -> views_path.'main-header.php';
?>
<main class="workshop">
    <section>
        <h1>Gallery</h1>
        <section class="items-list gallery">
            <?php echo $mv -> Gallery -> display(); ?>
        </section>
        
        <?php if($mv -> Gallery -> paginator -> hasPages()): ?>
            <div class="paginator">
                <span>Page:</span>
                <?php echo $mv -> Gallery -> paginator -> display($mv -> root_path.'gallery'); ?>
            </div>
        <?php endif; ?>
    </section>
</main>
<?php
include $mv -> views_path.'main-footer.php';
?>