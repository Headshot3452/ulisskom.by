<?php
class NewsController extends FrontendController
{
    public $root_id;

    public function init()
    {
        parent::init();

        $this->getPageModule();
        $struct = Structure::model()->findByPk($this->page_id);
        $this->root_id = $struct->module->tree_id;
    }

    public function actionList()
    {
        $news_tree = NewsTree::model()->active()->roots()->find('root = :root', array('root' => $this->root_id));
        $news = News::model()->getProviderNews($this->getCurrentLanguage()->id, $news_tree->id);
        $this->render('list', array('dataProvider'=>$news));
    }

    public function actionItem($name)
    {
       $news=News::getNewsByName($name, $this->getCurrentLanguage()->id);
       if (!$news)
       {
           throw new CHttpException(404);
       }
       $this->getPageModule('item');

       $this->setPageTitle($news->title);
       $this->breadcrumbs[]=strip_tags($news->title);
       $this->setSeoTags($news);
       $this->setText($news);
       $this->render('news',array('news'=>$news));
    }
}