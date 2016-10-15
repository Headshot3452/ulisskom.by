<?php


class MySqlSchema extends CMysqlSchema{

    /**
     * Collects the foreign key column details for the given table.
     * @param CMysqlTableSchema $table the table metadata
     */
    protected function findConstraints($table)
    {
        $row=$this->getDbConnection()->createCommand('SHOW CREATE TABLE '.$table->rawName)->queryRow();
        $matches=array();
        $regexp='/FOREIGN KEY\s+\(([^\)]+)\)\s+REFERENCES\s+([^\(^\s]+)\s*\(([^\)]+)\)((\s*ON DELETE\s+(.+)\s+ON UPDATE\s+([\w\s]+))|())/mi';
        foreach($row as $sql)
        {
            if(preg_match_all($regexp,$sql,$matches,PREG_SET_ORDER))
                break;
        }
        foreach($matches as $match)
        {
            $keys=array_map('trim',explode(',',str_replace(array('`','"'),'',$match[1])));
            $fks=array_map('trim',explode(',',str_replace(array('`','"'),'',$match[3])));
            foreach($keys as $k=>$name)
            {
                $table->foreignKeys[$name]=array(str_replace(array('`','"'),'',$match[2]),
                                                    $fks[$k],
                                                    ($match[6]?$match[6]:'RESTRICT'),
                                                    str_replace("\n","",($match[7]?$match[7]:'RESTRICT'))
                                                );
                if(isset($table->columns[$name]))
                    $table->columns[$name]->isForeignKey=true;
            }
        }
    }

    public function findIndexes($table)
    {
        $row=$this->getDbConnection()->createCommand('SHOW INDEX FROM '.$table->rawName)->queryAll();

        return $row;
    }

} 