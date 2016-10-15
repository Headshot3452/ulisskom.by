<?php

class m141007_183530_menu extends CDbMigration
{
    public function up()
    {
        $this->addColumn('menu_item','parent_id','int(10) unsigned DEFAULT NULL AFTER menu_id');
        $this->addColumn('menu_item','url','varchar(255) DEFAULT NULL AFTER title');
        $this->alterColumn('menu_item','structure_id','int(11) unsigned DEFAULT NULL');
        $this->addColumn('menu_item','sort','int(10) NOT NULL AFTER url');
    }


    public function down()
    {
        $this->dropColumn('menu_item','parent_id');
        $this->dropColumn('menu_item','url');
//        $this->alterColumn('menu_item','structure_id','int(11) unsigned NOT NULL');
        $this->dropColumn('menu_item','sort');
        return true;
    }

}