<div class="main-content row">
    <div class="left-content col-xs-4">
        <div class="buttons">
<?php
            if(!empty($this->buttons_left_menu))
            {
                echo
                    '<span class="dropdown">
                        <a href="javascript:void(0)" data-toggle="dropdown" data-target="#" role="button" class="btn btn-small">
                            <span class="icon-admin-catalog-menu"></span>
                        </a>
                        <ul class="dropdown-menu nav" role="menu" id="yw1">';

                            if (($check = $this->hasButtonsLeftMenu('create')) != null)
                            {
                                if(!isset($check['toggle']))
                                {
                                    $check['toggle'] = '';
                                }

                                echo '<li><a tabindex="-1" href="'.$check['url'].'" data-toggle="'. $check['toggle'] .'">Добавить категорию</a></li>';
                            }
                            if (($check = $this->hasButtonsLeftMenu('update'))!=null)
                            {
                                if(!isset($check['toggle']))
                                {
                                    $check['toggle'] = '';
                                }

                                echo '<li><a tabindex="-1" href="'.$check['url'].'" data-toggle="'. $check['toggle'] .'">Редактировать категорию</a></li>';
                            }
                            if (($check = $this->hasButtonsLeftMenu('parameters'))!=null)
                            {
                                echo '<li><a tabindex="-1" href="'.$check['url'].'">Параметры категории</a></li>';
                            }
                echo
                        '</ul>
                    </span>';
                echo CHtml::link(Yii::t('app', 'All products'), array('index'), array('id' => 'all_products'));
            }
            if (($button = $this->hasButtonsLeftMenu('active')) != null)
            {
                echo '<a href="'.$button['url'].'" data-hint="Сменить статус" class="btn btn-small btn-active hint--bottom hint--rounded"><span class="icon-admin-power-switch-'.($button['active']==true ? 'green' : 'red').'"></span></a>';
            }
            if (($check = $this->hasButtonsLeftMenu('delete')) != null)
            {
                echo '<a data-placement="bottom" data-hint="Удалить категорию" href="'.$check['url'].'" class="btn btn-small btn-trash hint--bottom hint--rounded"><span class="fa fa-trash-o"></span></a>';
            }

        echo '</div>';

        Yii::app()->getClientScript()->registerScript('leftmenudelete',
                '$(".left-content a[href*=delete]").click(function()
                {
                    return confirm("'.Yii::t('app', 'Are you sure you want to delete category?').'");
                });

                $(".left-content [rel=tooltip]").tooltip();
            ');

        switch ($this->layout_in)
        {
            case 'backend_left_menu':
                $this->widget('zii.widgets.CMenu', array(
                    'encodeLabel' => false,
                    'items' => $this->getLeftMenu(),
                    'id' => 'main-left-menu',
                ));
                break;

            case 'backend_left_tree_with_buttons':

                $cs = Yii::app()->getClientScript();
                $cs->registerPackage('jquery.ui');
                $cs->registerScriptFile("/js/jquery.mjs.nestedSortable.js");

                $tree_sortable = '
                    $("#main-left-tree-menu ul").nestedSortable(
                    {
                        items: "li",
                        listType: "ul",
                        update:function( event, ui )
                        {
                            $.ajax(
                            {
                                type: "POST",
                                url: "'.$this->createUrl("tree_update").'",
                                data: {
                                    id: $(ui.item).attr("id"),
                                    prev: $(ui.item).prev().attr("id"),
                                    next: $(ui.item).next().attr("id"),
                                    parent: $(ui.item).parent().closest("li").attr("id"),
                                },
                                success:function(e)
                                {
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

                    var class_hitarea=last_class+"-hitarea"

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
                }';

                $cs->registerScript("tree_sortable", $tree_sortable);

                $this->widget('system.web.widgets.CTreeView',
                    array(
                        'cssFile' => Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot.css.treeview')).'/jquery.treeview.css',
                        'data' => $this->getLeftMenu(),
                        'htmlOptions' => array('class' => ''),
                        'id' => 'main-left-tree-menu',
                        'persist' => 'cookie'
                    )
                );
                break;
        }
?>
    </div>

    <div class="right-content col-xs-8">
        <?php
            if(Yii::app()->controller->action->id == 'create_category' || Yii::app()->controller->action->id == 'update_category')
            {
                echo
                    '<div class="title title-page">
                        '.$this->getPageTitle().'
                    </div>';
            }

        echo $content;
        echo '<div class="clearfix"></div>';
?>
    </div>
</div>

<?php
    if(isset($this->root) && !$this->root)
    {
        $cs = Yii::app()->getClientScript();

        $treeview = "
            $('#modal_tree').find('ul:first').show();
            $('#main-left-tree-menu').find('ul.ui-sortable:first').show();
            $('#main-left-tree-menu, #modal_tree').find('li:first').css({'position':'relative', 'top':'2px', 'margin-left':'34px'});
            $('#modal_tree').css({'margin-left':'-34px', 'margin-top':'-2px'});
            $('#main-left-tree-menu').css({'margin-top':'28px','margin-left':'-40px'});
            $('#main-left-tree-menu, #modal_tree > li').children('.lastExpandable-hitarea:first').remove();
            $('#main-left-tree-menu, #modal_tree > li').children('.lastCollapsable-hitarea:first').remove();
            $('#main-left-tree-menu, #modal_tree').children('.lastCollapsable:first').css({'background-image':'none', 'background-position':'0'});
            $('#main-left-tree-menu, #modal_tree').children('.lastExpandable:first').css({'background-image':'none', 'background-position':'0'});
        ";

        $cs->registerPackage('jquery')->registerScript('treeview', $treeview);
    }