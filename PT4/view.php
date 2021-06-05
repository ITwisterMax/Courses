<?php
    require_once 'source/template.php';

    // Update a specifical post and return to the homepage
    if (isset($_POST['title'])) {
        $list = new PostsList();
        $_POST['id'] = $_GET['id'];
        $list->updatePost($_POST);

        unset($_POST);
        echo '<script>location.replace("index.php");</script>';
    }

    // Create a page
    $page = new Template();
    $page->setTemplate('templates/view.tmp');
    echo $page->getPage($_GET['id']);
