<?php
    require_once 'source/template.php';
    
    // Add a new post and return to the homepage
    if (isset($_POST['title'])) {
        $list = new PostsList();
        $list->addNewPost($_POST);

        unset($_POST);
        echo '<script>location.replace("index.php");</script>';
    }

    // Create a page
    $page = new Template();
    $page->setTemplate('templates/create.tmp');
    echo $page->getPage();
