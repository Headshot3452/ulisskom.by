<div class='ask'>
    <div class='title'>
      <?php  echo Chtml::link("<h4>".$data->title."</h4>",$this->createUrl('askanswer/index').$data->name);?>
    </div>
    <div class='answer'>
        <?php echo $data->preview;?>
    </div>
    <div class="answer"><?php echo $data->text; ?></div>
</div>