<?php
    require_once 'source/db(PDO).php';
    require_once 'source/logs.php';

    /**
     * Class for working with the templates
     *
     * @author Maksim Mikhalkov
     * @version 1.0
     */
    class Template{
        /**
         * @var string initial template
         */
        private $template;

        /**
         * @var object errors
         */
        private $logs;

        /**
         * Creating a errors copy
         */
        public function __construct() {
            $this->logs = new Errors();
		}

        /**
         * Delete a logs copy
         */
		public function __destruct() {
            unset($this->logs);
		}

        /**
         * Set main template
         *
         * @param string $mainTemplateFilename - path to file
         */
        public function setTemplate($mainTemplateFilename) {
            if (!is_file($mainTemplateFilename)) {
                $this->logs->templateError($mainTemplateFilename);
            }

            $this->template = file_get_contents($mainTemplateFilename);
        }

        /**
         * Get view posts page
         * 
         * @param int $offset - offset in database
         * @param int $limit - posts limit
         * 
         * @return string final page
         */
        public function getViewPage($offset = 0, $limit = 5) {
            // Create a batabase connection
            $sql = new DataBase();
            $postsList = $sql->selectPosts($offset, $limit);
            $elements = '';

            // Get final posts list
            foreach($postsList as $element) {
                $elements .= "<li><div class=\"left\"><img src=\"images/news.png\"></div>
                            <div class=\"right\">Title: {$element[1]}<br>Description: {$element[2]}<br>Created at: {$element[3]}
                            <br>Updated at: {$element[4]}<br>Author: {$element[5]}<br>Category: {$element[7]}</div></li>";
            }
            $result = preg_replace("/{ELEMENTS}/", $elements, $this->template);
            
            // Get info about user
            $result = preg_replace("/{IMAGE}/", $_SESSION['avatar'], $result);
            $result = preg_replace("/{NAME}/", $_SESSION['name'], $result);

            // Get navigation
            $total = ceil($sql->getPostsCount() / LIMIT);
            $last = ($total - 1) * LIMIT;
            $prevOffset = ($offset - LIMIT >= 0) ? $offset - LIMIT : $offset;
            $nextOffset = ($offset + LIMIT <= $last) ? $offset + LIMIT : $offset;

            $navigation = "<a href=\"view.php?offset=0\">First</a> <a href=\"view.php?offset=$prevOffset\">Prev</a> {OTHER}
                            <a href=\"view.php?offset=$nextOffset\">Next</a> <a href=\"view.php?offset=$last\">Last</a>";
            
            // Calculation a page numbers
            $pages = '';
            // Last pages
            if ($offset / LIMIT + LIMIT <= $total) {
                for ($i = 1; $i <= LIMIT; $i++) {
                    $number = $offset / LIMIT + $i;
                    $position = ($number - 1) * LIMIT;
    
                    if ($position == $offset) {
                        $pages .= "<a href=\"view.php?offset=$position\" style=\"color: red\">$number</a> ";
                    }
                    else {
                        $pages .= "<a href=\"view.php?offset=$position\">$number</a> ";
                    }
                    
                }
            }
            // Other pages
            else {
                $current = $total - LIMIT;
                for ($i = 1; $i <= LIMIT; $i++) {
                    $number = $current + $i;
                    $position = ($number - 1) * LIMIT;

                    if ($position == $offset) {
                        $pages .= "<a href=\"view.php?offset=$position\" style=\"color: red\">$number</a> ";
                    }
                    else {
                        $pages .= "<a href=\"view.php?offset=$position\">$number</a> ";
                    }
                }
            }
            
            // Get final navigation string
            $navigation = preg_replace("/{OTHER}/", $pages, $navigation);
            $result = preg_replace("/{NAVIGATION}/", $navigation, $result);

            return $result;
        }

        /**
         * Get login / register page
         * 
         * @param string $action - log or reg form
         * @param string $message - error message
         * 
         * @return string final page
         */
        public function getLogOrRegPage($action, $message = '') {
            // Login page
            if ($action === 'log') {
                $form = file_get_contents('templates/log.tpl');
            }
            // Register page
            elseif ($action === 'reg') {
                $form = file_get_contents('templates/reg.tpl');
            }
            
            $result = preg_replace("/{FORM}/", $form, $this->template);
            if (!empty($message)) {
                $result = preg_replace("/{MESSAGE}/", $message . '<br>', $result);
            }
            else {
                $result = preg_replace("/{MESSAGE}/", $message, $result);
            }

            return $result;
        }

        /**
         * Get reset page
         *
         * @param string $message - error message
         * 
         * @return string final page
         */
        public function getResetPage($message = '') {            
            if (empty($message)) {
                $result = preg_replace("/{MESSAGE}/", $message, $this->template);
            }
            else {
                $result = preg_replace("/{MESSAGE}/", '<br>' . $message . '<br>', $this->template);
            }

            return $result;
        }
    }
