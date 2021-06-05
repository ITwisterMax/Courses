<?php
    require_once 'source/template.php';

    // Create a page
    $page = new Template();
    $page->setTemplate('templates/index.tmp');
    echo $page->getPage();
