<?php
Yii::import('zii.widgets.CListView');
class BalanceHistoryListView extends CListView
{
    public function renderItems()
	{
		echo CHtml::openTag($this->itemsTagName,array('class'=>$this->itemsCssClass))."\n";
		$data=$this->dataProvider->getData();
		if(($n=count($data))>0)
		{
			$owner=$this->getOwner();
			$viewFile=$owner->getViewFile($this->itemView);
			$j=0;
            $old_item=null; //предидущее значение data
            $temp_date=null; //
			foreach($data as $i=>$item)
			{
				$data=$this->viewData;
				$data['index']=$i;
				$data['data']=$item;
				$data['widget']=$this;
                
                if ($item->create_time)
                {
                    $temp_date=date('d.m.Y',$item->create_time); //день для сравнения
                    if ($i==0 || (!empty($old_item) && isset($old_item->create_time) && $old_item->create_time!=$temp_date))
                    {
                        echo CHtml::tag('div',array('class'=>'title-date text-center'),Yii::app()->dateFormatter->format('eeee d MMMM yyyy',$item->create_time)); // заголовок для вывода с днем
                    }
                }
                
				$owner->renderFile($viewFile,$data);
                
                $old_item=$item;
				$old_item->create_time=$temp_date;
                
                if($j++ < $n-1)
					echo $this->separator;
			}
		}
		else
			$this->renderEmptyText();
		echo CHtml::closeTag($this->itemsTagName);
	}
}
?>
