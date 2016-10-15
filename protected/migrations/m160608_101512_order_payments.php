<?php
    class m160608_101512_order_payments extends CDbMigration
    {
        public function up()
        {
            $this->createTable('order_payments',
                array(
                    'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY',
                    'order_id' => 'int(11) unsigned NOT NULL',
                    'user_id' => 'int(11) unsigned NULL',
                    'currency_id' => 'varchar(50) NULL',
                    'create_time' => 'int(11) unsigned DEFAULT NULL',
                    'update_time' => 'int(11) unsigned DEFAULT NULL',
                    'status' => 'tinyint(4) NOT NULL',
                    'pay_system' => 'varchar(60) NOT NULL',
                    'pay_num' => 'varchar(20) NOT NULL',
                    'account' => 'varchar(20) NOT NULL',
                    'recipient' => 'varchar(60) NOT NULL',
                    'summa' => 'double NOT NULL',
                    'text' => 'text NOT NULL',
                ),
                'ENGINE=InnoDB'
            );

            $this->createIndex('order_id_idx', 'order_payments', 'order_id');
            $this->createIndex('user_id_idx', 'order_payments', 'user_id');
            $this->createIndex('currency_id_idx', 'order_payments', 'currency_id');

            $this->addForeignKey("fk_order_payments_orders_order_id", "order_payments", "order_id", "orders", "id", "CASCADE", "CASCADE");
            $this->addForeignKey("fk_order_payments_users_user_id", "order_payments", "user_id", "users", "id", "SET NULL", "CASCADE");
            $this->addForeignKey("fk_order_payments_settings_currency_list_currency_id", "order_payments", "currency_id", "settings_currency_list", "name", "SET NULL", "CASCADE");
        }

        public function down()
        {
            $this->dropTable('order_payments');
            $this->dropForeignKey('fk_order_payments_orders_order_id', 'order_payments');
            $this->dropForeignKey('fk_order_payments_users_user_id', 'order_payments');
            $this->dropForeignKey('fk_order_payments_settings_currency_list_currency_id', 'order_payments');
        }
    }