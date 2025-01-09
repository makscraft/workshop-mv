<?php
class Products extends Model
{
	protected $name = 'Products';

	protected $model_elements = [
		['Active', 'bool', 'active', ['on_create' => true]],
		['Name', 'char', 'name', ['required' => true]],
		['URL', 'url', 'url', ['unique' => true, 'translit_from' => 'name']],         
		['Catalog section', 'enum', 'catalog', [
				'foreign_key' => 'Catalogs',
				'required' => true,
				'is_parent' => true,
				'show_parent' => true
			]
		],
		['Price', 'int', 'price'],
		['Position', 'order', 'position'],
		['Images', 'multi_images', 'images'],
		['Description', 'text', 'content', ['rich_text' => true]]
	];

	protected $migrations = [
		'add_index' => ['url']
	];

	/*
	 * Installation Process for 'Catalogs' + 'Products'
	 * 
	 * 1. Place your model files into the /models/ folder and view files into the /views/ folder.
	 * 2. Add the model class name to the config/models.php file, e.g., 'Catalogs', 'Products'.
	 * 3. Define the routes in the config/routes.php file (feel free to customize them):
	 * 
	 *    '/catalog' => 'view-catalog-root.php',
	 *    '/catalog/*' => 'view-catalog-section.php',
	 * 	  '/product/*' => 'view-catalog-product.php'
	 * 
	 * 4. Run migrations using the Composer CLI or through the Admin Panel (migrations are in 'My Settings' section).
	 * 5. Access your new module in the Admin Panel and add some content to it.
	 * 6. Verify the route URLs on the application front.
	 * 7. Customize the model class and view files to suit your needs.
	 * 
	 * P.S. You can use the initial MV build and media/css/intro.css file to check the result.
	*/

	public function findProductRecord(Router $router): ?Record
	{
		$url = $router -> getUrlPart(1);
		$conditions = ['active' => 1];
		$conditions = is_numeric($url) ? ['id' => $url] : ['url' => $url];
		
		return $this -> find($conditions);
	}

	public function display(array $conditions): string
	{
		$conditions['active'] = 1;

		if(isset($this -> paginator))
			$conditions['limit->'] = $this -> paginator -> getParamsForSelect();

		if(isset($this -> sorter))
			$conditions['order->'.$this -> sorter -> getOrder()] = $this -> sorter -> getField();
		else
			$conditions['order->asc'] = 'position';

		if(isset($this -> filter))
			$conditions = array_merge($conditions, $this -> filter -> getConditions());

		$rows = $this -> select($conditions);
		$html = '';
			
		foreach($rows as $row)
		{
			$url = $this -> root_path.'product/'.($row['url'] ? $row['url'] : $row['id']);
			$image = $this -> getFirstImage($row['images']);

			$html .= "<div>\n";
			$html .= "<a href=\"".$url."\">\n".$this -> cropImage($image, 300, 225)."</a>\n";
			$html .= "<a class=\"name\" href=\"".$url."\">".$row['name']."</a>\n";
			$html .= "<div class=\"price\">$".$row['price']."</div>\n";
			$html .= "</div>\n";
		}

		return $html;
	}
}