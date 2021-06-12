<?php
    require_once 'source/template.php';

    // Create a main page
    $page = new Template();
    $page->setTemplate('templates/index.tpl');
    echo $page->getMainPage();
