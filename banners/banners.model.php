<?php
class Banners extends Model
{
   protected $name = 'Banners';
   
   protected $model_elements = [
		['Active', 'bool', 'active', ['on_create' => true]],
		['Name', 'char', 'name', ['required' => true]],
		['URL', 'url', 'url'],
		['Image', 'image', 'image', ['required' => true]],
		['Position', 'order', 'position'],
		['Content', 'text', 'content', ['rich_text' => true]]
	];

	/*
	 * Installation Process
	 * 
	 * 1. Place your model files into the /models/ folder and view files into the /views/ folder.
	 * 2. Add the model class name to the config/models.php file, e.g., 'Banners'.
	 * 3. Define the routes in the config/routes.php file (feel free to customize them):
	 * 
	 *    '/banners' => 'view-banners.php',
	 * 
	 * 4. Run migrations using the Composer CLI or through the Admin Panel (migrations are in 'My Settings' section).
	 * 5. Access your new module in the Admin Panel and add some content to it.
	 * 6. Verify the route URLs on the application front.
	 * 7. Customize the model class and view files to suit your needs.
	 * 
	 * P.S. You can use the initial MV build and media/css/intro.css file to check the result.
 	*/
}