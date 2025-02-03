# Workshop MV

Ready-to-use components to build MV applications.

Typical Installation Process
---

1. Place your model files into the **/models/** folder and view files into the **/views/** folder.
2. Add the model class name to the **config/models.php** file, e.g., 'News'.
3. Define the routes in the **config/routes.php** file (feel free to customize them):

```
'/news' => 'view-news-all.php',
'/news/*' => 'view-news-details.php'
```

4. Run **migrations** using the Composer CLI or through the Admin Panel (migrations are in 'My Settings' section).
5. Access your new module in the **Admin Panel** and add some content to it.
6. Verify the route URLs on the application front.
7. Customize the model class and view files to suit your needs.
 
**P.S. You can use the initial MV build and media/css/intro.css file to check the result.**
