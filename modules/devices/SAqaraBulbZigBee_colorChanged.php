<?php

if ($params['NEW_VALUE'] == $params['OLD_VALUE']) return;

if ($params['NEW_VALUE'] >= $this->getProperty('colorMin') && $params['NEW_VALUE'] <= $this->getProperty('colorMax') && $this->getProperty('flag')) {
    $this->setProperty('colorSeved', $params['NEW_VALUE']);
}
