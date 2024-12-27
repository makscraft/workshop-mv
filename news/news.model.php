<?php
class News extends Model
{
	protected $name = "Новости";
	
	protected $model_elements = array(
		array("Активация", "bool", "active", array("on_create" => true)),
		array("Дата", "date", "date", array("required" => true)),			
		array("Название", "char", "name", array("required" => true)),
		array("Ссылка", "url", "url", array("unique" => true, "translit_from" => "name")),
		array("Изображение", "image", "image"),
		array("Текст новости", "text", "content", array("rich_text" => true)),
		array("Заголовок title", "char", "title"),
		array("Ключевые слова keywords", "text", "keywords"),
		array("Описание description", "text", "description")
	);
	
	protected $model_display_params = array(
		"fields_groups" => array("Основные параметры" => array("active", "date", "name", "url", "image", "content"),
								 "SEO параметры" => array("title", "keywords", "description"))
	);
	
	public function defineNewsPage(Router $router)
	{
		$url_parts = $router -> getUrlParts();
		$record = false;
		
		if(isset($url_parts[0]) && $url_parts[0] == "mobile")
			array_shift($url_parts);
		
		if(count($url_parts) == 2)
			if(is_numeric($url_parts[1]))
				$record = $this -> findRecord(array("id" => $url_parts[1], "active" => 1));
			else
				$record = $this -> findRecord(array("url" => $url_parts[1], "active" => 1));

		return $record;
	}
	
	public function displayOnMain()
	{
		$rows = $this -> select(array("active" => 1, "order->desc" => "date", "limit->" => 4));
		$html = "";
	
		foreach($rows as $row)
		{
			$url = $this -> root_path."news/".($row['url'] ? $row['url'] : $row['id']);
				
			$html .= "<div>\n";
			$html .= "<a class=\"name\" href=\"".$url."\">".$row['name']."</a>\n";
			$html .= "<div class=\"date\">".I18n :: formatDate($row['date'])."</div>\n";
			$html .= "<p>".Service :: cutText($row['content'], 110, " ...")."</p>\n";
			$html .= "<a class=\"details\" href=\"".$url."\">Подробности</a>\n";
			$html .= "</div>\n";
		}
	
		return $html;
	}
	
	public function display()
	{
		$params = array("active" => 1, "order->desc" => "date", "limit->" => $this -> pager -> getParamsForSelect());
			
		$rows = $this -> select($params);
		$html = "";
		
		foreach($rows as $row)
		{
			$url = $this -> root_path."news/".($row['url'] ? $row['url'] : $row['id']);
			
			$html .= "<div>\n";

			if($row["image"])
			{
				$html .= "<div class=\"image\"><a href=\"".$url."\">";	
				$html .= $this -> cropImage($row["image"], 240, 140);
				$html .= "</a></div>\n";
			}
			
			$html .= "<div class=\"content\">\n";
			$html .= "<a class=\"name\" href=\"".$url."\">".$row['name']."</a>\n";
			$html .= "<div class=\"date\">".I18n :: formatDate($row['date'])."</div>\n";
						
			$html .= "<p>".Service :: cutText($row['content'], 130, " ...")."</p>\n";
			$html .= "<a href=\"".$url."\" class=\"details\">Подробности</a>\n";
			$html .= "</div>\n</div>\n";
		}
				
		return $html;
	}
	
	public function displayPreviousAndNext($current_id, $current_date)
	{
		$html = "";
		$params = array("active" => 1, "id!=" => $current_id, "date>=" => $current_date, "order->asc" => "date");
		
		if($record = $this -> findRecord($params))
		{
			$url = $this -> root_path."news/".($record -> url ? $record -> url : $record -> id);					
			$html .= "<a class=\"previous\" href=\"".$url."\">".$record -> name."</a>\n";
		}
		
		$params = array("active" => 1, "id!=" => $current_id, "date<=" => $current_date, "order->desc" => "date");
		
		if($record = $this -> findRecord($params))
		{
			$url = $this -> root_path."news/".($record -> url ? $record -> url : $record -> id);
			$html .= "<a class=\"next\" href=\"".$url."\">".$record -> name."</a>\n";
		}
		
		return $html;
	}
}
?>