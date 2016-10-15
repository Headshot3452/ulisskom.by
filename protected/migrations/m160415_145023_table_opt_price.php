<?php
    class m160415_145023_table_opt_price extends CDbMigration
    {
        public function up()
        {
            $this->createTable('opt_price',
                array(
                    'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY',
                    'product_id' => 'int(10) unsigned NOT NULL',
                    'opt_price' => 'varchar(20) NOT NULL',
                    'opt_count' => 'varchar(20) NOT NULL',
                    'opt_count_from' => 'int(10) NOT NULL',
                    'opt_text' => 'varchar(60) NOT NULL',
                ),
            'ENGINE = InnoDB');

            $this->createIndex('product_id_idx', 'opt_price', 'product_id');
            $this->addForeignKey("fk_opt_price_catalog_products_product_id", "opt_price", "product_id", "catalog_products", "id", "CASCADE", "CASCADE");
        }

        public function down()
        {
            $this->dropTable('opt_price');
            $this->dropForeignKey('fk_opt_price_catalog_products_product_id', 'opt_price');
        }
    }