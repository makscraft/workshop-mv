<?php
class Options extends ModelSimple
{
    protected $name = 'Options';
   
	protected $model_elements = [
		['Allow / deny option', 'bool', 'allow_something'],
		['Contact phone', 'phone', 'phone'],
		['Email of administrator', 'email', 'admin_email', ['required' => true]],
		['Email of administrator, additional', 'email', 'admin_email_additional'],
		['Enum option', 'enum', 'choice', [
			'empty_value' => 'Not selected',
			'required' => false,
			'values_list' => [
					'first' => 'First option',
					'second' => 'Second option',
					'third' => 'Third option',
				]
			]
		],
		['YouTube', 'redirect', 'youtube_link'],
		['Simple gallery', 'multi_images', 'simple_gallery']
	];

	/*
	 * Installation Process
	 * 
	 * 0. It's a simple model, storing key/value pairs in database table.
	 * 1. Place your model files into the /models/ folder and view files into the /views/ folder.
	 * 2. Add the model class name to the config/models.php file, e.g., 'Options'.
	 * 3. Define the routes in the config/routes.php file (if you need it for this simple model):
	 * 
	 *    //Test page to show data access
	 *    '/options' => 'view-options.php',
	 * 
	 * 4. Run migrations using the Composer CLI or through the Admin Panel (migrations are in 'My Settings' section).
	 * 5. Access your new module in the Admin Panel and add some content to it.
	 * 6. Verify the route URLs on the application front.
	 * 7. Customize the model class and view files to suit your needs.
	 * 
	 * P.S. You can use the initial MV build and media/css/intro.css file to check the result.
 	*/

	public function displaySimpleGallery(): string
	{
		$html = '';
	
		foreach($this -> extractImages($this -> getValue('simple_gallery')) as $one)
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