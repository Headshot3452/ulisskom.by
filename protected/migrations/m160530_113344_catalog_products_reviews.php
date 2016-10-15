<?php
    class m160530_113344_catalog_products_reviews extends CDbMigration
    {
        public function up()
        {
            $this->createTable('catalog_products_reviews',
                array(
                    'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY',
                    'product_id' => 'int(11) unsigned NOT NULL',
                    'user_id' => 'int(11) unsigned NULL',
                    'create_time' => 'int(11) unsigned DEFAULT NULL',
                    'update_time' => 'int(11) unsigned DEFAULT NULL',
                    'status' => 'tinyint(4) NOT NULL',
                    'rating' => 'tinyint(4) NOT NULL DEFAULT 0',
                    'header' => 'varchar(255) NOT NULL',
                    'text' => 'text NOT NULL',
                    'note' => 'text NOT NULL',
                    'fullname' => 'varchar(255) NOT NULL',
                    'email' => 'varchar(60) NOT NULL',
                    'phone' => 'varchar(30) NOT NULL',
                    'sort' => 'int(11) NOT NULL'
                ),
                'ENGINE=InnoDB'
            );

            $this->createIndex('product_id_idx', 'catalog_products_reviews', 'product_id');
            $this->createIndex('user_id_idx', 'catalog_products_reviews', 'user_id');

            $this->addForeignKey("fk_catalog_products_reviews_catalog_products_product_id", "catalog_products_reviews", "product_id", "catalog_products_reviews", "id", "CASCADE", "CASCADE");
            $this->addForeignKey("fk_catalog_products_reviews_users_user_id", "catalog_products_reviews", "user_id", "users", "id", "CASCADE", "CASCADE");
        }

        public function down()
        {
            $this->dropForeignKey('fk_catalog_products_reviews_catalog_products_product_id', 'catalog_products_reviews');
            $this->dropForeignKey('fk_catalog_products_reviews_users_user_id', 'catalog_products_reviews');
            $this->dropTable('catalog_products_reviews');
        }
    }