<?php
class Gallery extends Model
{
	protected $name = 'Gallery';
	
	protected $model_elements = [
		['Active', 'bool', 'active', ['on_create' => true]],
		['Name', 'char', 'name', ['required' => true]],
		['URL', 'url', 'url', ['unique' => true, 'translit_from' => 'name']],
		['Position', 'order', 'position'],
		['Content', 'text', 'content'],
		['Images', 'multi_images', 'images']
	];

	/**
	 * Installation Process
	 * 
	 * 1. Place your model files into the /models/ folder and view files into the /views/ folder.
	 * 2. Add the model class name to the config/models.php file, e.g., 'Gallery'.
	 * 3. Define the routes in the config/routes.php file (feel free to customize them):
	 * 
	 *    '/gallery' => 'view-gallery-all.php',
	 *    '/gallery/*' => 'view-gallery-details.php'
	 * 
	 * 4. Run migrations using the Composer CLI or through the Admin Panel (migrations are in 'My Settings' section).
	 * 5. Access your new module in the Admin Panel and add some content to it.
	 * 6. Verify the route URLs on the application front.
	 * 7. Customize the model class and view files to suit your needs.
	 * 
	 * P.S. You can use the initial MV build and media/css/intro.css file to check the result.
 	*/

	 public function findGalleryRecord(Router $router): ?Record
	 {
		 $url = $router -> getUrlPart(1);		
		 $conditions = ['active' => 1];
		 $conditions = is_numeric($url) ? ['id' => $url] : ['url' => $url];
		 
		 return $this -> find($conditions);
	 }

	public function display(): string
	{
		$params = ['active' => 1, 'order->asc' => 'position'];
		
		if(isset($this -> paginator))
			$params['limit->'] = $this -> pager -> getParamsForSelect();
					
		$rows = $this -> select($params);
		$html = '';
		
		foreach($rows as $row)
		{
			$url = $this -> root_path.'gallery/'.($row['url'] ? $row['url'] : $row['id']);
			$cover = $this -> getFirstImage($row['images']);
			
			$html .= "<div>\n";
			$html .= "<a href=\"".$url."\">\n".$this -> cropImage($cover, 300, 225)."</a>\n";
			$html .= "<a href=\"".$url."\">".$row['name']."</a>\n";
			$html .= "</div>\n";
		}
				
		return $html;
	}

	public function displayGallery(Record $record): string
	{
		$html = '';
	
		foreach($record -> extractImages('images') as $one)
		{
			$html .= "<a class=\"lightbox\" href=\"".$this -> root_path.$one['image']."\">\n";
			
			$params = [
				'alt-text' => $one['comment'] ? $one['comment'] : 'Image',
				'title' => $one['comment'] ? $one['comment'] : ''
			];
			
			$html .= $this -> cropImage($one['image'], 300, 225, $params);
			$html .= "</a>\n";
		}
		
		return $html;
	}
}