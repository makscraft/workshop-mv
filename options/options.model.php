<?php
class Options extends Model_Simple
{
    protected $name = "Настройки";
   
    protected $model_elements = array(
		array("Заочная консультация", "bool", "button_consult"),
		array("Вызвать врача на дом", "bool", "button_call_home"),
		array("Email администратора", "email", "admin_email", 
					array("required" => true, "help_text" => "На данный адрес будут приходить сообщения с сайта")),
		array("Email администратора (дополнительный)", "email", "admin_email_2"),
		array("Email администратора (дополнительный)", "email", "admin_email_3"),
		array("Email генерального директора", "email", "boss_email"),
		array("Email для заочной консультации", "email", "consultation_email"),
		array("Телефон", "phone", "phone"),
		array("Телефон 8-800", "phone", "phone_global"),
		array("Телефон выездной службы", "phone", "phone_out_service"),    		
		array("Телефон в мобильной версии", "phone", "phone_mobile"),
		array("Ссылка VK", "char", "social_vk"),
		array("Ссылка YouTube", "char", "social_youtube"),
		array("Ссылка Telegram", "char", "social_telegram"),
		array("Ссылка Одноклассники", "char", "social_ok"),
		array("Количество лет опыта", "int", "summary_years"),
		array("Количество специалистов", "int", "summary_people"),
		array("Количество клиник", "int", "summary_hospitals"),
		array("Изображение на странице о клинике", "image", "about_hospital_image"),
		//array("Баннеры на главной", "multi_images", "banners"),
		array("Лицензии", "multi_images", "licences"),
		array("Баннеры на странице стационаров", "multi_images", "small_banners"),
		array("Баннеры внизу", "multi_images", "footer_banners"),
		array("Баннеры внизу на мобильной версии", "multi_images", "footer_banners_mobile"),
		array("Телефон для юридических лиц", "phone", "landing_phone_corporate"),
		array("Телефон для физических лиц", "phone", "landing_phone_private"),
		array("Текст вверху", "text", "landing_top", array("rich_text" => true)),
		array("Цены", "text", "landing_prices", array("rich_text" => true)),
		array("Детские медосмотры", "text", "landing_kids", array("rich_text" => true)),
		array("Штрафы", "text", "landing_fines", array("rich_text" => true)),
		array("Обновление Медиалог", "char", "medialog_update"),
		array("Обновление времени врачей для записи", "char", "request_cache_update")
    );
    
    protected $model_display_params = array(
	    "fields_groups" => array("Основные параметры" => array("button_consult", "button_call_home", "admin_email", 
															   "admin_email_2", "admin_email_3",
	    													   "boss_email", "consultation_email", "phone", "phone_global",
	    													   "phone_out_service", 
	    													   "phone_mobile", "social_vk",
	    													   "social_youtube", "social_telegram", "social_ok", "summary_years", "summary_people",
	    													   "summary_hospitals", "medialog_update", "request_cache_update"),
	
								 "Баннеры внизу" => array("footer_banners", "footer_banners_mobile"),
	    		
	    						 "Изображения" => array("about_hospital_image", "banners", "small_banners", "licences"),
	    		
	    						 "Медосмотры лэндинг" => array("landing_phone_corporate", "landing_phone_private",
	    						 							   "landing_top", "landing_prices", "landing_kids",
	    						 							   "landing_fines")),
	    "not_editable_fields" => ["medialog_update", "request_cache_update"]
	);
	
	public function displayInsideSlider()
	{
		$images = $this -> extractImages($this -> getValue("small_banners"));

		$html = "<div id=\"index-banner-slider\" class=\"swiper inside\">\n";
		$html .= "<div class=\"swiper-wrapper\">\n";
		
		foreach($images as $image)
		{
			$html .= "<div class=\"swiper-slide\">\n";	
   			$html .= $this -> cropImage($image['image'], 1200, 1000);
			$html .= "</div>\n";
		}

		$html .= "</div>\n";

		$html .= "<div class=\"index-banner-controls\">\n";
		$html .= "<div class=\"arrows\">\n";
		$html .= "<div class=\"index-banner-prev\"></div><div class=\"index-banner-next\"></div>\n";
		$html .= "</div>\n";
		$html .= "<div class=\"index-banner-pagination\"></div>\n";
		$html .= "</div>\n";
		$html .= "</div>\n";
		
		return $html;
	}

	public function displaySmallBanners()
	{
		if(!$this -> getValue("small_banners"))
			return;

		$html = "";

		foreach($this -> extractImages($this -> getValue("small_banners")) as $image => $comment)
		{
			$html .= "<div>\n";
			$html .= $comment ? "<a href=\"".$comment."\">\n" : "";
			$html .= "<img src=\"".$this -> root_path.$image."\" alt=\"\">\n";
			$html .= $comment ? "</a>\n" : "";
			$html .= "</div>\n";
		}

		return $html;
	}
	
	public function displayLicences()
	{
		if(!$this -> getValue("licences"))
			return;
	
		$html = "";
	
		foreach($this -> extractImages($this -> getValue("licences")) as $image)
		{
			$html .= "<a class=\"lightbox\" href=\"".$this -> root_path.$image['image']."\">\n";
			$html .= $this -> cropImage($image['image'], 250, 300);
			$html .= "</a>\n";
		}
	
		return $html;
	}
	
	static public function isDayTimeRequest()
	{
		//return 1;

		$hour = date('G');
		return intval($hour >= 7 && $hour < 20);
	}

	static public function isDayTimeRequestPlus30()
	{
		//return 1;

		$hour = date("G");
		$minute = date("i");

		if(intval($hour >= 8 && $hour < 20))
			return 1;
		else if($hour == 7 && $minute >= 30)
			return 1;
		else
			return 0;
	}
}
?>