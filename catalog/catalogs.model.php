<?php
class Catalogs extends Model
{
	protected $name = 'Catalogs';

	public $parents_list = [];

	protected $model_elements = [
		['Active', 'bool', 'active', ['on_create' => true]],
		['Name', 'char', 'name', ['required' => true]],
		['URL', 'url', 'url', ['unique' => true, 'translit_from' => 'name']],         
		['Parent section', 'parent', 'parent', ['parent_for' => 'Products']],
		['Image', 'image', 'image'],
		['Position', 'order', 'position'], 
		['Description', 'text', 'content', ['rich_text' => true]]
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

	public function defineCatalogPage(Router $router): ?Record
	{
		$url = $router -> getUrlPart(1);
		$conditions = ['active' => 1];
		$conditions = is_numeric($url) ? ['id' => $url] : ['url' => $url];
		$record = $this -> find($conditions);

		if(is_object($record))
			$this -> parents_list = array_keys($this -> getParents($record -> id));

		return $record;
	}

	public function displayRootCatalogMenu(?Record $active = null): string
	{
		$conditions = [
			'active' => 1,
			'parent' => -1,
			'order->asc' => 'position'
		];

		$rows = $this -> select($conditions);
		$html = '';

		foreach($rows as $row)
		{			
			$css_active = (is_object($active) && $row['id'] == $active -> id) ? ' class="active"' : '';
			$url = $this -> root_path.'catalog/'.($row['url'] ? $row['url'] : $row['id']);
			
			$html .= "<li".$css_active."><a href=\"".$url."\">".$row['name']."</a></li>\n";
		}
		
		return $html;
	}
	
	public function displayCatalogTreeMenu(int $parent, ?Record $active = null): string
	{
		$conditions = [
			'active' => 1,
			'parent' => $parent,
			'order->asc' => 'position'
		];

		$rows = $this -> select($conditions);
		$html = '';

		foreach($rows as $row)
		{
			$children = $this -> countRecords(['parent' => $row['id'], 'active' => 1]);
			$open = in_array($row['id'], $this -> parents_list);
			$url = $this -> root_path.'catalog/'.($row['url'] ? $row['url'] : $row['id']);
			$css_classes = [];
			
			if($children)
				$css_classes[] = 'has-children';

			if($open)
				$css_classes[] = 'open';

			if($row['id'] == $this -> id)
				$css_classes[] = 'active';

			$css_classes = count($css_classes) ? ' class="'.implode(' ', $css_classes).'"' : '';
			$html .= "<li".$css_classes."><a href=\"".$url."\">".$row['name']."</a>\n";
			
			if($children && $open)
				$html .= "<ul>\n".$this -> displayCatalogTreeMenu($row['id'])."</ul>\n";
				
			$html .= "</li>\n";		
		}
			
		return $html;	
	}
	
	public function displayCatalogSection(?Record $parent = null): string
	{
		$conditions = [
			'active' => 1,
			'parent' => is_object($parent) ? $parent -> id : -1,
			'order->asc' => 'position'
		];
		
		$rows = $this -> select($conditions);
		$html = '';

		foreach($rows as $row)
		{
			$url = $this -> root_path.'catalog/'.($row['url'] ? $row['url'] : $row['id']);
			
			$html .= "<div>\n<a href=\"".$url."\">\n";
            $html .= $this -> cropImage($row['image'], 300, 225, ['alt-text' => $row['name']]);
			$html .= "<div class=\"name\">".$row['name']."</div>";
			$html .= "</a>\n</div>\n";
        }
        
        return $html;
	}
}