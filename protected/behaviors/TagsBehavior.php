<?php
class TagsBehavior extends ActiveRecordBehavior
{
    public $model_tag_items='TagItems';
    public $type=1;

    public function beforeSave($event)
    {
        $owner=$this->getOwner();

        $old_tags=$this->getMainTags();


        $main_tags=array();
        $insert_tags=array();
        $result=array();

        foreach($old_tags as $key=>$tag)
        {
            $main_tags[$tag]=$key;
        }

        $items=$_POST['tags'];

        if (!empty($main_tags))
        {
            $count=count($items);

            for($i=0;$i<$count;$i++)
            {
                if (isset($main_tags[$items[$i]]))
                {
                    unset($main_tags[$items[$i]]);
                }
                else
                {
                    $insert_tags[]=$items[$i];
                }
            }

            if (!empty($main_tags))
            {
                TagItems::removeTags($main_tags);
            }
        }
        else
        {
            $insert_tags=$items;
        }

        if (!empty($insert_tags))
        {
            $count=count($insert_tags);

            for($i=0;$i<$count;$i++)
            {
                TagItems::insertTagItem($insert_tags[$i],$owner->id,$this->type);
            }
        }
    }

    /**
     * Получить список тегов
     * @return array
     */
    public function getMainTags()
    {
        $owner=$this->getOwner();

        $result=array();

        if (!$owner->isNewRecord)
        {
            $result=TagItems::getTagsByType($this->type,$owner->getPrimaryKey());
        }

        return $result;
    }
}