<?php 
class Faq extends Model
{
	protected $name = 'FAQ';

	protected $model_elements = [
		['Active', 'bool', 'active', ['on_create' => true]],
		['Author', 'char', 'name', ['required' => true]],
		['Date', 'date', 'date'],
		['Question', 'text', 'question', ['required' => true]],
		['Answer', 'text', 'answer']
	];

	/*
	 * Installation Process
	 * 
	 * 1. Place your model files into the /models/ folder and view files into the /views/ folder.
	 * 2. Add the model class name to the config/models.php file, e.g., 'Faq'.
	 * 3. Define the routes in the config/routes.php file (feel free to customize them):
	 * 
	 *    '/faq' => 'view-faq.php'
	 * 
	 * 4. Run migrations using the Composer CLI or through the Admin Panel (migrations are in 'My Settings' section).
	 * 5. Access your new module in the Admin Panel and add some content to it.
	 * 6. Verify the route URLs on the application front.
	 * 7. Customize the model class and view files to suit your needs.
	 * 
	 * P.S. You can use the initial MV build and media/css/intro.css file to check the result.
 	*/

	public function display()
	{
		$conditions = [
			'active' => 1, 
			'question!=' => '',
			'answer!=' => '',
			'order->desc' => 'date'
		];

		if(isset($this -> paginator))
			$conditions['limit->'] = $this -> pager -> getParamsForSelect();
					
		$rows = $this -> select($conditions);
		$html = '';
		      
		foreach($rows as $row)
		{
			$html .= "<div id=\"question-".$row['id']."\">\n";
			$html .= "<div class=\"question\">".nl2br($row['question'])."</div>\n";
			$html .= "<div class=\"date\">".I18n :: formatDate($row['date'])."</div>\n";
			$html .= "<div class=\"answer\">".nl2br($row['answer'])."</div>\n";
			$html .= "</div>\n";
		}

		return $html;
	}
}