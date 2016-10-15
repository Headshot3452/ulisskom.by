<div class="contacts">
    <div class="container">
        <div class="row">

            <div class="col-md-<?php echo $settings->contact_show_feedback == 1 ? 6 : 12; ?>">
                <div class="col-md-12 widget">
                    <div class="title row">
                        <span class="caption">
                            <p>Контакты</p>
                        </span>
                    </div>
                    <?php

                    if (!empty($phones)) {
                        echo '<div class="contacts-block"><label>Телефоны</label><br>';
                        foreach ($phones as $phone) {
                            echo "
                            <span class='phone'>$phone->number<span><br>
                        ";
                        }
                        echo '</div>';
                    }

                    if (!empty($adresses)) {
                        echo '<div class="contacts-block"><label>Адрес</label><br>';
                        echo "
                            <span class='phone'>{$adresses[0]->text}<span><br>
                        </div>";
                    }

                    ?>
                </div>
            </div>

            <?php
            if ($settings->contact_show_feedback == 1) {
                ?>
                <div class="col-md-6">
                <div class="col-md-12 widget">
                        [[w:FeedbackWidget|view=view_page]]
                </div></div><?php
            }

            foreach ($adresses as $adr) {
                ?>
                <div class="col-md-12">
                    <div class="col-md-12 widget">
                        <div class="title row">
                        <span class="caption">
                            <?php
                            echo $adr->text;
                            ?>
                        </span>
                        </div>
                        <div class="">
                            [[w:MapWidget|map_id=<?php echo $adr->map_id; ?>;width=100%;height=250px;]]
                        </div>
                    </div>
                </div>
            <?php
            }

            ?>
        </div>
    </div>
</div>