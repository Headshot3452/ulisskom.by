<?php
    class m141114_100950_alter_orders extends CDbMigration
    {
        public function up()
        {
            $this->addColumn('orders', 'paid', 'tinyint(4) unsigned DEFAULT 0 AFTER delivery_hours');
        }

        public function down()
        {

            $this->dropColumn('orders', 'paid');
            return true;
        }
    }