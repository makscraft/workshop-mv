<?php
$mv -> seo -> mergeParams('Banners');
$rows = $mv -> banners -> select(['active' => 1, 'order->asc' => 'position']);

include $mv -> views_path.'main-header.php';
?>
<main class="workshop">
	<section>
		<h1>Banners</h1>
		<section class="items-list">
			<?php foreach($rows as $row): ?>
                <div>
                    <?php
                        if($row['url'])
                            echo '<a href="'.$row['url'].'">';

                        echo $mv -> banners -> cropImage($row['image'], 800, 400);
                        
                        if($row['content'])
                            echo '<div>'.$row['content'].'</div>';

                        if($row['url'])
                            echo '</a>';
                    ?>
                </div>
            <?php endforeach; ?>
    </section>
</main>
<?php
include $mv -> views_path.'main-footer.php';
?>        