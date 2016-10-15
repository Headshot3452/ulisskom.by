<?php
    class m141217_131841_alter_orders_add_comment extends CDbMigration
    {
        public function up()
        {
            $this->addColumn('orders', 'comment', 'text NOT NULL AFTER sum');
        }

        public function down()
        {
            $this->dropColumn('orders', 'comment');
            return true;
        }
    }