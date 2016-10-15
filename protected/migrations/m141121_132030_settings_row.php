<?php
    class m141121_132030_settings_row extends CDbMigration
    {
        public function up()
        {
            $this->insert('settings',
                array(
                    'id' => 1,
                    'email' => 'admin@admin.admin',
                )
            );
        }


        public function down()
        {
            $this->delete('settings', 'id = 1');
            return true;
        }
    }