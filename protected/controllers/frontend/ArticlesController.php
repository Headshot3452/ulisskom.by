<?php

class ArticlesController  extends FrontendController
{
    public function actionList()
    {
        $this->getPageModule();
        $articles=Articles::model()->getProviderArticles($this->getCurrentLanguage()->id);
        $this->render('list',array('dataProvider'=>$articles));
    }

    public function actionItem($name)
    {
        $article=Articles::getArticleByName($name,$this->getCurrentLanguage()->id);
        if (!$article)
        {
            throw new CHttpException(404);
        }
        $this->getPageModule('item','articles');

        $this->setPageTitle($article->title);
        $this->breadcrumbs[]=$article->title;
        $this->setSeoTags($article);
        $this->setText($article);
        $this->render('article',array('article'=>$article));
    }
}