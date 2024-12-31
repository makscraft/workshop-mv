<?php
class Articles extends Model
{
	protected $name = 'Articles';
	
	protected $model_elements = [
		['Active', 'bool', 'active', ['on_create' => true]],
		['Date', 'date_time', 'date'],
		['Name', 'char', 'name', ['required' => true]],
		['URL', 'url', 'url', ['unique' => true, 'translit_from' => 'name']],
		['Image', 'image', 'image'],
		['Position', 'order', 'position'],
		['Content', 'text', 'content', ['rich_text' => true]]
	];

	/**
	 * Installation Process
	 * 
	 * 1. Place your model files into the /models/ folder and view files into the /views/ folder.
	 * 2. Add the model class name to the config/models.php file, e.g., 'Articles'.
	 * 3. Define the routes in the config/routes.php file (feel free to customize them):
	 * 
	 *    '/articles' => 'view-articles-all.php',
	 *    '/articles/*' => 'view-articles-details.php'
	 * 
	 * 4. Run migrations using the Composer CLI or through the Admin Panel (migrations are in 'My Settings' section).
	 * 5. Access your new module in the Admin Panel and add some content to it.
	 * 6. Verify the route URLs on the application front.
	 * 7. Customize the model class and view files to suit your needs.
	 * 
	 * P.S. You can use the initial MV build and media/css/intro.css file to check the result.
 	*/

	public function findArticleRecord(Router $router): ?Record
	{
		$url = $router -> getUrlPart(1);		
		$conditions = ['active' => 1];
		$conditions = is_numeric($url) ? ['id' => $url] : ['url' => $url];
		
		return $this -> find($conditions);
	}

	public function display(): string
	{
		$conditions = ['active' => 1, 'order->asc' => 'position'];
		
		if(isset($this -> paginator))
			$conditions['limit->'] = $this -> paginator -> getParamsForSelect();
					
		$rows = $this -> select($conditions);
		$html = '';
		
		foreach($rows as $row)
		{
			$url = $this -> root_path.'articles/'.($row['url'] ? $row['url'] : $row['id']);
			
			$html .= "<div>\n";
			$html .= "<h2><a href=\"".$url."\">".$row['name']."</a></h2>\n";
			
			if($row['date'])
				$html .= "<div class=\"date\">".I18n::formatDate($row['date'])."</div>\n";

			if($row['image'])
				$html .= "<a href=\"".$url."\">\n".$this -> cropImage($row['image'], 300, 225)."</a>\n";
						
			$html .= "</div>\n";
		}
				
		return $html;
	}
	
	public function displayPreviousAndNext(Record $current): string
	{
		$html = '';

		$conditions = [
			'active' => 1, 
			'id!=' => $current -> id, 
			'position<=' => $current -> position,
			'order->desc' => 'position'
		];
		
		if($record = $this -> find($conditions))
		{
			$url = $this -> root_path.'articles/'.($record -> url ? $record -> url : $record -> id);
			$html .= "<a class=\"previous\" href=\"".$url."\">Previous</a>\n";
		}
		
		$conditions = [
			'active' => 1, 
			'id!=' => $current -> id, 
			'position>=' => $current -> position,
			'order->asc' => 'position'
		];

		if($record = $this -> find($conditions))
		{
			$url = $this -> root_path.'articles/'.($record -> url ? $record -> url : $record -> id);
			$html .= "<a class=\"next\" href=\"".$url."\">Next</a>\n";
		}
		
		return $html;
	}
}