<?php
    class m141007_153417_ok_add_city_address extends CDbMigration
    {
        public function up()
        {
            $this->createTable('address', array(
                'id'=>'int(10) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
                'user_id'=>'int(10) unsigned NOT NULL',
                'city'=>'varchar(127) NOT NULL',
                'street'=>'varchar(127) NOT NULL',
                'house'=>'varchar(15) NOT NULL',
                'apartment'=>'varchar(7) NOT NULL',
            ), 'ENGINE=InnoDB');

            $this->createIndex('user_id_idx', 'address', 'user_id' );

            $this->addForeignKey("fk_address_users_user_id", "address", "user_id", "users", "id", "CASCADE", "CASCADE");
        }

        public function down()
        {
            $this->dropForeignKey('fk_address_users_user_id', 'address');

            $this->dropTable('address');

            return true;
        }
    }