<?php

class m160506_132517_widgets_change extends CDbMigration
{
	public function up()
	{
        $this->addColumn('structure_widgets','view','VARCHAR(255) NOT NULL');
        $this->addColumn('structure_widgets','tree_id','int(11) unsigned NULL');
	}

	public function down()
	{
        $this->dropColumn('structure_widgets','view');
        $this->dropColumn('structure_widgets','tree_id');
	}
}