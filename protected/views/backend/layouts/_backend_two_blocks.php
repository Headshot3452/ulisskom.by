<div class="main-content row">
    <div class="left-content col-xs-4">
        <div class="buttons">
<?php
            if (($button = $this->hasButtonsLeftMenu('create')) != null)
            {
                echo '<a href="'.$button['url'].'" class="btn btn-small btn-add"><span class="icon-admin-add-document"></span></a>';
            }
            if (($button = $this->hasButtonsLeftMenu('create_menu')) != null)
            {
                echo '<a href="'.$button['url'].'" class="add-children btn btn-action btn-add-menu"><span class="icon-admin-add-menu-item"></span></a>';
            }
            if (($button = $this->hasButtonsLeftMenu('active')) != null)
            {
                echo '<a href="'.$button['url'].'" class="btn btn-small btn-active"><span class="icon-admin-power-switch-'.($button['active']==true ? 'green' : 'red').'"></span></a>';
            }
            if (($button = $this->hasButtonsLeftMenu('delete')) != null)
            {
                echo '<a href="'.$button['url'].'" class="btn btn-small btn-trash"><span class="fa fa-trash-o"></span></a>';
            }
?>
        </div>
<?php
        Yii::app()->getClientScript()->registerScript('leftmenudelete','
            $(".left-content a[href*=delete]").click(function()
            {
                return confirm("'.Yii::t('app', 'Are you sure you want to delete?').'");
            });

            $(".left-content [rel=tooltip]").tooltip();
        ');

        switch ($this->layout_in)
        {
            case 'backend_left_menu':
                $this->widget('zii.widgets.CMenu',
                    array(
                        'encodeLabel' => false,
                        'items' => $this->getLeftMenu(),
                        'id' => 'main-left-menu',
                    )
                );
                break;

            case 'backend_left_tree':
                $cs=Yii::app()->getClientScript();
                $cs->registerPackage('jquery.ui');
                $cs->registerScriptFile("/js/jquery.mjs.nestedSortable.js");

                $tree_sortable = '
                    $("#main-left-tree-menu ul").nestedSortable({
                        items: "li",
                        listType: "ul",
                        update:function( event, ui )
                        {
                             $.ajax(
                             {
                                type:"POST",
                                url:"'.$this->createUrl("tree_update").'",
                                data:{
                                    id:$(ui.item).attr("id"),
                                    prev:$(ui.item).prev().attr("id"),
                                    next:$(ui.item).next().attr("id"),
                                    parent:$(ui.item).parent().closest("li").attr("id"),
                                 }
                             });

                             if ($(ui.item).hasClass("last") || $(ui.item).hasClass("lastExpandable") || $(ui.item).hasClass("lastCollapsable"))
                             {
                                lastClass($(ui.item),"remove");
                                lastClass($(event.target.lastElementChild),"add");
                             }

                             if ($(ui.item).is(":last-child"))
                             {
                                lastClass($(ui.item).prev(),"remove");
                                lastClass($(ui.item),"add");
                             }
                        }
                    });

                    function lastClass(object, type)
                    {
                        var child = false;
                        var last_class = "lastCollapsable";

                        if (object.hasClass("collapsable") || object.hasClass("expandable"))
                        {
                            child = true;

                            if (object.hasClass("expandable"))
                            {
                                last_class = "lastExpandable";
                            }
                        }

                        var class_hitarea = last_class+"-hitarea"

                        switch(type)
                        {
                            case "add":
                                if (child)
                                {
                                    object.addClass(last_class);
                                    object.find(".hitarea").addClass(class_hitarea);
                                }
                                else
                                {
                                    object.addClass("last");
                                }
                                break;

                            case "remove":
                                if (child)
                                {
                                    object.removeClass(last_class);
                                    object.find(".hitarea").removeClass(class_hitarea);
                                }
                                else
                                {
                                    object.removeClass("last");
                                }
                                break;
                            }
                      }
                ';

                $cs->registerScript("tree_sortable", $tree_sortable);
                $this->widget('system.web.widgets.CTreeView',
                    array(
                        'cssFile' => Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot.css.treeview')).'/jquery.treeview.css',
                        'data' => $this->getLeftMenu(),
                        'id' => 'main-left-tree-menu',
                        'persist' => 'cookie'
                    )
                );
                break;
        }
?>
    </div>
    <div class="right-content col-xs-8">
        <div class="title title-page">
            <?php echo $this->getPageTitle() ;?>
        </div>
<?php
        echo $content;
?>
    </div>
</div>

<?php
    if(Yii::app()->controller->id == 'structure')
    {
        $cs = Yii::app()->getClientScript();

        $treeview = "
            $('#main-left-tree-menu > .collapsable:first').css({'background': 'none', 'padding-left': '10px'}).children('.hitarea').hide().siblings('ul').show();
            $('#main-left-tree-menu > .expandable:first').css({'background': 'none', 'padding-left': '10px'}).children('.hitarea').hide().siblings('ul').show();
        ";

        $cs->registerPackage('jquery')->registerScript('treeview', $treeview);
    }
?>