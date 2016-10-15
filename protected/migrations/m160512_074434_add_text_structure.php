<?php
    class m160512_074434_add_text_structure extends CDbMigration
    {
        public function up()
        {
            $this->addColumn('structure','text_more','text NULL');
            $this->addColumn('news','time_end', 'int(11) UNSIGNED NULL');
        }

        public function down()
        {
            $this->dropColumn('structure', 'text_more');
            $this->dropColumn('news', 'time_end');
        }
    }