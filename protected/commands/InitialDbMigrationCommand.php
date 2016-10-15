<?php
class InitialDbMigrationCommand extends CConsoleCommand
{

    public function run($args) {
        $schema = $args[0];
        $tables = Yii::app()->db->schema->getTables($schema);

        $addForeignKeys = '';
        $dropForeignKeys = '';
        $addindexes = '';

        $result = "public function up()\n{\n";
        foreach ($tables as $table) {

            $indexes = Yii::app()->db->schema->findIndexes($table);

            $i=0;
            while(isset($indexes[$i]))
            {
                $index = $indexes[$i];

                if($index['Key_name']== 'PRIMARY' )
                {
                    $i++;
                    continue;
                }
                $idxType = $index['Non_unique'] ? '_idx' : '_UNIQUE';
                $flag = $index['Non_unique'] ? ' ' : ',true';

                $column = array($index['Column_name']);

                while(isset($indexes[$i+1]) && $indexes[$i+1]['Key_name'] == $index['Key_name'])
                {
                    $i++;
                    $column[] = $indexes[$i]['Column_name'];
                }
                $addindexes .= ' $this->createIndex(\'' . $index['Column_name'] .$idxType. "', '$table->name', '".implode(',',$column)."'$flag);\n";

                 $i++ ;
            }

            $compositePrimaryKeyCols = array();

// Create table
            $result .= ' $this->createTable(\'' . $table->name . '\', array(' . "\n";
            foreach ($table->columns as $col) {
                $result .= ' \'' . $col->name . '\'=>\'' . $this->getColType($col) . '\',' . "\n";

                if ($col->isPrimaryKey && !$col->autoIncrement) {
// Add column to composite primary key array
                    $compositePrimaryKeyCols[] = $col->name;
                }
            }
            $result .= ' ), \'ENGINE=InnoDB\');' . "\n\n";

// Add foreign key(s) and create indexes
            foreach ($table->foreignKeys as $col => $fk) {
// Foreign key naming convention: fk_table_foreignTable_col (max 64 characters)
                $fkName = substr('fk_' . $table->name . '_' . $fk[0] . '_' . $col, 0 , 64);
                $addForeignKeys .= ' $this->addForeignKey(' . '"'.$fkName.'", "'.$table->name.'", "'.$col.'", "'.$fk[0].'", "'.$fk[1].'", "'.$fk[2].'", "'.$fk[3].'");'."\n";
                $dropForeignKeys .= ' $this->dropForeignKey(' . "'$fkName', '$table->name');\n";

            }

// Add composite primary key for join tables
            if ($compositePrimaryKeyCols) {
                $result .= ' $this->addPrimaryKey(\'pk_' . $table->name . "', '$table->name', '" . implode(',', $compositePrimaryKeyCols) . "');\n\n";

            }

        }
        $result .= $addindexes."\n"; // This needs to come after all of the tables have been created.
        $result .= $addForeignKeys; // This needs to come after all of the tables have been created.
        $result .= "}\n\n\n";

        $result .= "public function down()\n{\n";
        $result .= $dropForeignKeys."\n"; // This needs to come before the tables are dropped.
        foreach ($tables as $table) {
            $result .= ' $this->dropTable(\'' . $table->name . '\');' . "\n";
        }
        $result .= "}\n";


        echo $result;
    }

    public function getColType($col) {
        $result = $col->dbType;
        if (!$col->allowNull) {
            $result .= ' NOT NULL';
        }
        if ($col->isPrimaryKey && $col->autoIncrement) {
            $result .= "  AUTO_INCREMENT PRIMARY KEY";
        }


        if ($col->defaultValue != null) {
            $result .= " DEFAULT '{$col->defaultValue}'";
        } elseif ($col->allowNull) {
            $result .= ' DEFAULT NULL';
        }
        return addslashes($result);
    }
}