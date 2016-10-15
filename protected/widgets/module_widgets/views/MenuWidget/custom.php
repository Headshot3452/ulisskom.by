<?php
$count = count($this->_items);
for ($i = 0; $i < $count; $i++)
{
    if (isset($this->_items[$i]))
    {
        echo '<li ' . (($this->_items[$i]['active']) ? 'class="current active"' : '') . '><a href="' . $this->_items[$i]['url'] . '">' . $this->_items[$i]['label'] . '</a></li>';
    }
}