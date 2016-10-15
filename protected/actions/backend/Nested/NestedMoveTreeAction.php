<?php
    class NestedMoveTreeAction extends BackendAction
    {
        public function run()
        {
            $model = $this->getModel('insert');

            if (!empty($_POST) && isset($model))
            {
                $post = $_POST;

                if (isset($post['id']) && (isset($post['prev']) || isset($post['next']) || isset($post['parent'])))
                {
                    $tree=$model::model()->findByPk($post['id']);

                    if (!$tree)
                    {
                        throw new CHttpException("404");
                    }

                    if ($tree->isRoot() || ($tree->hasAttribute('system') && $tree->system==$model::SYSTEM_PRIVATE))
                    {
                        throw new CHttpException('404');
                    }

                    if (isset($post['prev']))
                    {
                        $el=$post['prev'];
                        $method='moveAfter';
                    }
                    elseif(isset($post['next']))
                    {
                        $el=$post['next'];
                        $method='moveBefore';
                    }
                    elseif(isset($post['parent']))
                    {
                        $el=$post['parent'];
                        $method='moveAsFirst';
                    }

                    $category=$model::model()->findByPk($el);//

                    if (!$category)
                    {
                        throw new CHttpException('404');
                    }

                    $tree->$method($category);
                }
            }
        }
    }