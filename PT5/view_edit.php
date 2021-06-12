<?php
    require_once 'source/template.php';

    if ($_GET['num'] == 1) {
        // Create a page
        $page = new Template();
        $page->setTemplate('templates/view.tpl');
        echo $page->getSomePage($_GET['id'], true);
    }
    else {
        // Update a specifical post and return to the homepage
        if (isset($_POST['updatePost'])) {
            $list = new PostsList();
            $_POST['id'] = $_GET['id'];
            $list->updatePost($_POST);

            unset($_POST);
            echo '<script>location.replace("index.php");</script>';
        }
        // Delete a specifical post and return to the homepage
        elseif (isset($_POST['deletePost'])) {
            $list = new PostsList();
            $list->deletePost($_GET['id']);

            unset($_POST);
            echo '<script>location.replace("index.php");</script>';
        }

        // Create a page
        $page = new Template();
        $page->setTemplate('templates/edit.tpl');
        echo $page->getSomePage($_GET['id'], true);
    }
