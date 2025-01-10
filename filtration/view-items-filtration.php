<?php
$mv -> seo -> mergeParams('Items Filtration');

$mv -> items -> runFilter(['active' , 'name', 'color', 'price']);
$mv -> items -> filter -> setDisplayCheckbox('active');
$conditions = $mv -> items -> filter -> getConditions();

$rows = $mv -> items -> select($conditions);

include $mv -> views_path.'main-header.php';
?>
<main class="workshop">
	<section class="filtration">
		<h1>Items Filtration</h1>
        <form method="get" class="filters">
            <?php echo $mv -> items -> filter -> display(); ?>
            <button>Search</button>
        </form>
        <table>
            <tr>
                <th>Active</th>
                <th>Name</th>
                <th>Color</th>
                <th>Price</th>
            </tr>
            <?php foreach($rows as $row): ?>
                <tr>
                    <td><?php echo $row['active'] ? 'yes' : 'no'; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $mv -> items -> getEnumTitle('color', $row['color']); ?></td>
                    <td><?php echo $row['price']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </section>
</main>
<?php
include $mv -> views_path.'main-footer.php';
?>