<?php
$this->renderPartial('_list_clients', array('model'=>$model,
                                            'count'=>$count,
                                            'count_item'=>$count_item,
                                            'dataProducts'=>$dataProducts
                                        ));