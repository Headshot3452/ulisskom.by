<?php
	class CustomPagination extends CPagination
	{
		public function createPageUrl($controller, $page)
		{	
			$params = $this->params === null ? $_GET : $this->params;

			if($page > 0)
            {
                $params[$this->pageVar] = $page+1;
            }
			else
            {
                unset($params[$this->pageVar]);
            }

			unset($params['url']);
			$get = http_build_query($params);
			
			if(count($params) > 0)
            {
                return '/'.Yii::app()->request->pathinfo.'/?'.$get;
            }
			else
            {
                return '/'.Yii::app()->request->pathinfo;
            }
		}
	}