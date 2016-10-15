<?php

class m150317_223339_init_data extends CDbMigration
{
	public function up()
	{
		//Users
		$this->insert('users',array(
			'email'=>'admin@admin.admin',
			'login' =>'admin',
			'password' => '$2a$13$nHfWSj63Oe9Xkea/tqRyvOGC93Hdae619Vq.0x1SHdpzmCw0TRlz6',
			'role' => '2',
			'avatar' => 'a:0:{}',
			'status' => '1',
		));

//		//Settings
//		$this->insert('settings',array(
//			'email'=>'admin@admin.admin',
//		));

		//Language
		$this->insert('language',array(
			'title'=>'Русский',
			'code' =>'ru',
			'status' => '1',
		));

		$this->insert('language',array(
			'title'=>'English',
			'code' =>'en',
			'status' => '2',
		));

		//Modules
		$this->insert("modules",array(
			"id"=>"1",
			"model"=>"NewsTree",
			"title"=>"Новости, акции, полезные статьи",
			"name"=>"news",
			"private"=>"0",
			"status"=>"1",
		));

		$this->insert("modules",array(
			"id"=>"2",
			"model"=>"Articles",
			"title"=>"Статьи",
			"name"=>"articles",
			"private"=>"0",
			"status"=>"1",
		));

		$this->insert("modules",array(
			"id"=>"3",
			"model"=>"Banners",
			"title"=>"Баннеры",
			"name"=>"promotions",
			"private"=>"1",
			"status"=>"1",
		));

		$this->insert("modules",array(
			"id"=>"4",
			"model"=>"Blocks",
			"title"=>"Блоки",
			"name"=>"blocks",
			"private"=>"1",
			"status"=>"1",
		));

		$this->insert("modules",array(
			"id"=>"5",
			"model"=>"CatalogTree",
			"title"=>"Каталог",
			"name"=>"catalog",
			"private"=>"0",
			"status"=>"1",
		));

		$this->insert("modules",array(
			"id"=>"6",
			"model"=>"Gallery",
			"title"=>"Галерея",
			"name"=>"gallery",
			"private"=>"1",
			"status"=>"1",
		));

		$this->insert("modules",array(
			"id"=>"7",
			"model"=>"Maps",
			"title"=>"Карты",
			"name"=>"maps",
			"private"=>"1",
			"status"=>"1",
		));

		$this->insert("modules",array(
			"id"=>"8",
			"model"=>"Menu",
			"title"=>"Меню",
			"name"=>"menu",
			"private"=>"1",
			"status"=>"1",
		));

		$this->insert("modules",array(
			"id"=>"9",
			"model"=>"Orders",
			"title"=>"Заказы",
			"name"=>"orders",
			"private"=>"1",
			"status"=>"1",
		));

		$this->insert("modules",array(
			"id"=>"10",
			"model"=>"Slider",
			"title"=>"Слайдер",
			"name"=>"slider",
			"private"=>"1",
			"status"=>"1",
		));

		$this->insert("modules",array(
			"id"=>"11",
			"model"=>"Structure",
			"title"=>"Структура",
			"name"=>"structure",
			"private"=>"1",
			"status"=>"1",
		));

		$this->insert("modules",array(
			"id"=>"12",
			"model"=>"AskAnswer",
			"title"=>"Вопрос ответ",
			"name"=>"askanswer",
			"private"=>"0",
			"status"=>"1",
		));

		//Widgets
		$this->insert("widgets",array(
			"module_id"=>"3",
			"title"=>"Баннер",
			"name"=>"BannerDescriptionWidget",
			"private"=>"0",
			"status"=>"1",
		));

		$this->insert("widgets",array(
			"module_id"=>"4",
			"title"=>"Текстовый блок",
			"name"=>"BlockWidget",
			"private"=>"0",
			"status"=>"1",
		));

		$this->insert("widgets",array(
			"module_id"=>"6",
			"title"=>"Карусель изображений галереи",
			"name"=>"CarouselGalleryWidget",
			"private"=>"0",
			"status"=>"1",
		));

		$this->insert("widgets",array(
			"module_id"=>"5",
			"title"=>"Карусель акционных товаров каталога",
			"name"=>"CarouselProductsWidget",
			"private"=>"0",
			"status"=>"1",
		));

		$this->insert("widgets",array(
			"module_id"=>"5",
			"title"=>"Уровень каталога с разделами и товарами",
			"name"=>"CatalogTreeViewWidget",
			"private"=>"0",
			"status"=>"1",
		));

		$this->insert("widgets",array(
			"module_id"=>"5",
			"title"=>"Дерево разделов",
			"name"=>"CatalogTreeWidget",
			"private"=>"0",
			"status"=>"1",
		));

		$this->insert("widgets",array(
			"module_id"=>"2",
			"title"=>"Последние статьи",
			"name"=>"LastArticlesWidget",
			"private"=>"0",
			"status"=>"1",
		));

		$this->insert("widgets",array(
			"module_id"=>"7",
			"title"=>"Карта",
			"name"=>"MapWidget",
			"private"=>"0",
			"status"=>"1",
		));

		$this->insert("widgets",array(
			"module_id"=>"8",
			"title"=>"Меню",
			"name"=>"MenuWidget",
			"private"=>"0",
			"status"=>"1",
		));

		$this->insert("widgets",array(
			"module_id"=>"1",
			"title"=>"Последние новости",
			"name"=>"NewsLastWidget",
			"private"=>"0",
			"status"=>"1",
		));

		$this->insert("widgets",array(
			"module_id"=>"10",
			"title"=>"Слайдер",
			"name"=>"SliderWidget",
			"private"=>"0",
			"status"=>"1",
		));

		//Каталог

		$this->insert("catalog_tree",array(
			"id"=>"1",
			"lft"=>"1",
			"rgt"=>"2",
			"level"=>"1",
			"language_id"=>"1",
			"title"=>"Каталог",
			"name"=>"catalog",
			"status"=>"1",
			"root"=>"1",
		));

		$this->insert("catalog_tree",array(
			"id"=>"2",
			"lft"=>"1",
			"rgt"=>"2",
			"level"=>"1",
			"language_id"=>"2",
			"title"=>"Catalog",
			"name"=>"catalog",
			"status"=>"1",
			"root"=>"1",
		));

	}

	public function down()
	{
		echo "m150317_223339_init_data does not support migration down.\n";
		return true;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}