<?
class Articles extends Model
{
	protected $name = "Статьи";
	
	protected $model_elements = array(
		array("Активация", "bool", "active", array("on_create" => true)),			
		array("Название", "char", "name", array("required" => true)),
		array("Ссылка", "url", "url", array("unique" => true, "translit_from" => "name")),
		array("Порядковый номер", "order", "order"),
		array("Изображение", "image", "image"),
		array("Текст статьи", "text", "content", array("rich_text" => true))			
	);
	
	public function defineArticlesPage(Router $router)
	{
		$url_parts = $router -> getUrlParts();
		$record = false;
		
		if(count($url_parts) == 2)
			if(is_numeric($url_parts[1]))
				$record = $this -> findRecord(array("id" => $url_parts[1], "active" => 1));
			else
				$record = $this -> findRecord(array("url" => $url_parts[1], "active" => 1));

		return $record;
	}
	
	public function display()
	{
		$params = array("active" => 1, "order->asc" => "order");
		
		if(isset($this -> pager))
			$params["limit->"] = $this -> pager -> getParamsForSelect();
			
		$rows = $this -> select($params);
		$html = "";
		
		foreach($rows as $row)
		{
			$url = $this -> root_path."articles/".($row['url'] ? $row['url'] : $row['id'])."/";
			
			$html .= "<div class=\"article\">\n";
			$html .= "<h2><a href=\"".$url."\">".$row['name']."</a></h2>\n";
			
			if($row['image'])
			{
				$html .= "<a href=\"".$url."\" class=\"article-image\">\n";
				$html .= $this -> cropImage($row['image'], 187, 127)."</a>\n";
			}			
			
			$html .= "<p>".Service :: cutText($row['content'], 600, "...")."</p>\n";
			$html .= "</div>\n";
		}
				
		return $html;
	}
	
	public function displayPreviousAndNext($current_id, $current_order)
	{
		$html = "";
		$params = array("active" => 1, "id!=" => $current_id, "order<=" => $current_order, "order->desc" => "order");
		
		if($record = $this -> findRecord($params))
		{
			$url = $this -> root_path."articles/".($record -> url ? $record -> url : $record -> id)."/";
			$html .= "<a class=\"previous\" href=\"".$url."\">Предыдущая статья</a>\n";
		}
		
		$params = array("active" => 1, "id!=" => $current_id, "order>=" => $current_order, "order->asc" => "order");
		
		if($record = $this -> findRecord($params))
		{
			$url = $this -> root_path."articles/".($record -> url ? $record -> url : $record -> id)."/";
			$html .= "<a class=\"next\" href=\"".$url."\">Следующая статья</a>\n";
		}
		
		return $html;
	}
}
?>