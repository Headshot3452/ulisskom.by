<?php
    class m141013_154035_ok_add_order_and_items extends CDbMigration
    {
        public function up()
        {
            $this->createTable('order_items',
                array(
                    'id'=>'int(10) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
                    'product_id'=>'int(10) unsigned DEFAULT NULL',
                    'order_id'=>'int(10) unsigned NOT NULL',
                    'title'=>'varchar(255) NOT NULL',
                    'price'=>'int(11) NOT NULL',
                    'count'=>'smallint(6) NOT NULL',
                    'discount'=>'double NOT NULL',
                ),
                'ENGINE=InnoDB'
            );

            $this->createTable('orders', array(
                'id'=>'int(10) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
                'user_id'=>'int(10) unsigned',
                'count'=>'int(10) unsigned NOT NULL',
                'sum'=>'double NOT NULL',
                'create_time'=>'int(10) unsigned NOT NULL',
                'update_time'=>'int(10) unsigned NOT NULL',
                'status'=>'tinyint(4) NOT NULL',
            ), 'ENGINE=InnoDB');

            $this->createIndex('product_id_idx', 'order_items', 'product_id' );
            $this->createIndex('order_id_idx', 'order_items', 'order_id' );
            $this->createIndex('user_id_idx', 'orders', 'user_id' );

            $this->addForeignKey("fk_order_items_orders_order_id", "order_items", "order_id", "orders", "id", "CASCADE", "CASCADE");
            $this->addForeignKey("fk_order_items_catalog_products_product_id", "order_items", "product_id", "catalog_products", "id", "SET NULL", "CASCADE");
            $this->addForeignKey("fk_orders_users_user_id", "orders", "user_id", "users", "id", "RESTRICT", "RESTRICT");
        }

        public function down()
        {
            $this->dropForeignKey('fk_order_items_orders_order_id', 'order_items');
            $this->dropForeignKey('fk_order_items_catalog_products_product_id', 'order_items');
            $this->dropForeignKey('fk_orders_users_user_id', 'orders');

            $this->dropTable('order_items');
            $this->dropTable('orders');

            return true;
        }
    }