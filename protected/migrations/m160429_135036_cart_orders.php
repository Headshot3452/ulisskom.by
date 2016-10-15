<?php
    class m160429_135036_cart_orders extends CDbMigration
    {
        public function up()
        {
            $this->addColumn('orders', 'user_info', 'text');
            $this->addColumn('orders', 'delivery_comment', 'text');
            $this->addColumn('orders', 'sum_paid', 'double');

            $this->createTable('payment_info',
                array(
                    'id' => 'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
                    'order_id' => 'int(11) unsigned DEFAULT NULL',
                    'organization' => 'varchar(100) NOT NULL',
                    'director' => 'varchar(100) NOT NULL',
                    'organization_info' => 'varchar(255) NOT NULL',
                    'bank_info' => 'varchar(255) NOT NULL',
                    'type' => 'tinyint(4) NOT NULL',
                    'status' => 'tinyint(4) NOT NULL',
                ),
                'ENGINE = InnoDB'
            );

            $this->createIndex('order_id_idx', 'payment_info', 'order_id');
            $this->addForeignKey("fk_payment_info_orders_order_id", "payment_info", "order_id", "orders", "id", "CASCADE", "CASCADE");
        }

        public function down()
        {
            $this->dropColumn('orders','user_info');
            $this->dropColumn('orders','delivery_comment');
            $this->dropColumn('orders','sum_paid');
            $this->dropTable('payment_info');
            $this->dropForeignKey('fk_payment_orders_order_id', 'payment_info');
        }
    }