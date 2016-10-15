<?php

class m141125_175230_maps extends CDbMigration
{
    public function up()
    {
        $this->createTable('maps', array(
            'id'=>'int(10) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
            'title'=>'varchar(255) NOT NULL',
            'description'=>'text NOT NULL',
            'center'=>'varchar(40) NOT NULL',
            'zoom'=>'tinyint(2) NOT NULL',
            'type'=>'varchar(50) NOT NULL',
            'status'=>'tinyint(1) NOT NULL',
        ), 'ENGINE=InnoDB');

        $this->createTable('maps_placemark', array(
            'id'=>'int(10) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
            'map_id'=>'int(10) unsigned NOT NULL',
            'position'=>'varchar(40) NOT NULL',
            'iconContent'=>'varchar(255) NOT NULL',
            'hintContent'=>'text NOT NULL',
            'balloonContent'=>'text NOT NULL',
            'preset'=>'varchar(50) NOT NULL',
        ), 'ENGINE=InnoDB');

        $this->createIndex('map_idx', 'maps_placemark', 'map_id' );
        $this->addForeignKey("fk_maps_placemark_map_map_id", "maps_placemark", "map_id", "maps", "id", "CASCADE", "CASCADE");
    }


    public function down()
    {
        $this->dropForeignKey('fk_maps_placemark_map_map_id','maps_placemark');

        $this->dropTable('maps_placemark');
        $this->dropTable('maps');
        return true;
    }

}