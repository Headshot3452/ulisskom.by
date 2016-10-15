<?php
    class m150717_081325_catalog_products extends CDbMigration
    {
        public function up()
        {
            $this->addColumn('catalog_products', 'count', 'int(11)  NOT NULL AFTER hit');
            $this->addColumn('catalog_products', 'unit_id', 'int(11)  NOT NULL AFTER count');
            $this->addColumn('catalog_products', 'stock', 'text  NOT NULL AFTER unit_id');
            $this->addColumn('catalog_products', 'sale_info', 'text  NOT NULL AFTER stock');
            $this->addColumn('catalog_products', 'preview', 'text  NOT NULL AFTER sale_info');
            $this->addColumn('catalog_products', 'type', 'tinyint(4) NOT NULL AFTER preview');
        }

        public function down()
        {
            $this->dropColumn('catalog_products', 'count');
            $this->dropColumn('catalog_products', 'unit_id');
            $this->dropColumn('catalog_products', 'stock');
            $this->dropColumn('catalog_products', 'sale_info');
            $this->dropColumn('catalog_products', 'preview');
            $this->dropColumn('catalog_products', 'type');
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