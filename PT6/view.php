<?php
    require_once 'source/template.php';
    require_once 'source/db(PDO).php';
    session_start();
    const LIMIT = 7;

    // Check Login status
    if (isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn'] === true)) {
        // Logout click
        if (isset($_POST['logout'])) {
            setcookie('remember', '', time() - 1209600);

            // Remove remember value
            $sql = new DataBase();
            $sql->removeRemember($_SESSION['id']);

            $_SESSION['loggedIn'] = false;
            session_destroy();
            unset($_SESSION);

            header('Location: index.php');
        }
        else {
            // Create a main page
            $page = new Template();
            $offset = $_GET['offset'] ?? 0;

            $page->setTemplate('templates/view.tpl');
            echo $page->getViewPage($offset, LIMIT);
        }
    }
    else {
        echo 'Error! You need to login...';
    }
    
