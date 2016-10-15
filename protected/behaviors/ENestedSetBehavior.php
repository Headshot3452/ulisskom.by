<?php
Yii::import('application.behaviors.NestedSetBehavior');

class ENestedSetBehavior extends NestedSetBehavior
{
    public $event = array(
        'onBeforeMove'=>'',
        'onAfterMove'=>'',
    );

    /**
     * Attaches the behavior object to the model.
     * @param CActiveRecord $owner the model that this behavior is to be attached to.
     */
    public function attach($owner)
    {
        parent::attach($owner);

        foreach ($this->event as $name=>$handler) {
            if($handler)
                $this->attachEventHandler ($name, $handler);
        }
    }

    /**
     * This event is raised before the record is moved.
     */
    public function onBeforeMove()
    {
        $this->raiseEvent('onBeforeMove', new CEvent($this->getOwner()));
    }

    /**
     * This event is raised after the record is moved.
     */
    public function onAfterMove()
    {
        $this->raiseEvent('onAfterMove', new CEvent($this->getOwner()));
    }

    public function moveBefore($target)
    {
        $this->onBeforeMove();
        parent::moveBefore($target);
        $this->onAfterMove();
        return true;
    }

    /**
     * Move node as next sibling of target.
     * @param CActiveRecord $target the target.
     * @return boolean whether the moving succeeds.
     */
    public function moveAfter($target)
    {
        $this->onBeforeMove();
        parent::moveAfter($target);
        $this->onAfterMove();
        return true;
    }

    /**
     * Move node as first child of target.
     * @param CActiveRecord $target the target.
     * @return boolean whether the moving succeeds.
     */
    public function moveAsFirst($target)
    {
        $this->onBeforeMove();
        parent::moveAsFirst($target);
        $this->onAfterMove();
        return true;
    }

    /**
     * Move node as last child of target.
     * @param CActiveRecord $target the target.
     * @return boolean whether the moving succeeds.
     */
    public function moveAsLast($target)
    {
        $this->onBeforeMove();
        parent::moveAsLast($target);
        $this->onAfterMove();
        return true;
    }


}
?>