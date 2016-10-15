<?php
    class m150213_122301_alter_orders_delivery_price extends CDbMigration
    {
        public function up()
        {
            $this->addColumn('orders', 'sum_delivery','double NOT NULL AFTER sum');
            $this->addColumn('orders', 'note1', 'text');
            $this->addColumn('orders', 'note2', 'text');
            $this->addColumn('orders', 'note3', 'text');
            $this->addColumn('orders', 'note4', 'text');
        }

        public function down()
        {
            $this->dropColumn('orders', 'sum_delivery');
            $this->dropColumn('orders', 'note1');
            $this->dropColumn('orders', 'note2');
            $this->dropColumn('orders', 'note3');
            $this->dropColumn('orders', 'note4');
            return true;
        }
    }