<?php
    require_once 'source/template.php';

    // Create a page
    $page = new Template();
    $page->setTemplate('templates/index.tpl');
    echo $page->getPage();
