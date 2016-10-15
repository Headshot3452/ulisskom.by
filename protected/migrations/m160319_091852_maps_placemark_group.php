<?php
    class m160319_091852_maps_placemark_group extends CDbMigration
    {
        public function up()
        {
            $this->createTable('maps_placemark_group',
                array(
                    'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY',
                    'language_id' => 'int(11) unsigned DEFAULT NULL',
                    'maps_id' => 'int(11) unsigned NOT NULL',
                    'title' => 'varchar(255) NOT NULL',
                    'center' => 'varchar(40) NOT NULL',
                    'zoom' => 'tinyint(2) NOT NULL',
                    'status' => 'tinyint(4) NOT NULL',
                    'sort' => 'int(11) NOT NULL',
                ),
                'ENGINE = InnoDB'
            );

            $this->addColumn('maps_placemark', 'group_id', 'int(11) unsigned NOT NULL');

            $this->createIndex('maps_id_idx', 'maps_placemark_group', 'maps_id');
            $this->createIndex('group_id_idx', 'maps_placemark', 'group_id' );

            $this->addForeignKey("fk_maps_id_maps_placemark_group", "maps_placemark_group", "maps_id", "maps", "id", "CASCADE", "CASCADE");
        }

        public function down()
        {
            $this->dropTable('maps_placemark_group');

            $this->dropColumn('maps_placemark', 'group_id');

            $this->dropForeignKey('fk_maps_id_maps_placemark_group', 'maps_placemark_group');
        }
    }