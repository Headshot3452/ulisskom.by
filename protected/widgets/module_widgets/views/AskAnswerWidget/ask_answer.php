<?php
echo '<div class="ask-answer panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
foreach($this->_data as $key=>$group)
{
    echo ' <div class="ask-group">
                    <div class="" role="tab">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse-group-'.$key.'" aria-expanded="true" aria-controls="collapseOne">
                          <span class="glyphicon glyphicon-chevron-right"></span> '.$group['category']->title.'
                        </a>
                      </h4>
                    </div>
                    <div id="collapse-group-'.$key.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                      <div class="panel-body">
                       <div class="ask-items panel-group" role="tablist" aria-multiselectable="true">';
    foreach($group['ask'] as $ask)
    {
        echo '<div class="ask-item">
                                        <div class="" role="tab">
                                          <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#collapse-ask-'.$ask->id.'" aria-expanded="true" aria-controls="collapseOne">
                                              <span class="glyphicon glyphicon-chevron-right"></span> '.$ask->title.'
                                            </a>
                                          </h4>
                                        </div>
                                        <div id="collapse-ask-'.$ask->id.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="panel-body">
                                            '.$ask->text.'
                                        </div>
                                </div>
                              </div>';
    }
    echo '</div>
                      </div>
                    </div>
                  </div>';
}
echo '</div>';

$cs=Yii::app()->getClientScript();
$collapse='
            $(".ask-answer").on("shown.bs.collapse", function () {
                var element=$(this).find(".panel-collapse.in");
                element.parent().addClass("open");
                element.prev().find("span.glyphicon").removeClass("glyphicon-chevron-right").addClass("glyphicon-chevron-down");
            });
            $(".ask-answer").on("hidden.bs.collapse", function () {
                var element= $(this).find(".panel-collapse").not(".in");
                element.parent().removeClass("open");
                element.prev().find("span.glyphicon").removeClass("glyphicon-chevron-down").addClass("glyphicon-chevron-right");
            });
        ';
$cs->registerScript('collapse-'.$this->id,$collapse);