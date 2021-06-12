<?php
    require_once 'list.php';
    require_once 'logs.php';

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
         * Get main page
         *
         * @return string final page
         */
        public function getMainPage() {
            $sql = new PostsList();
            $postsList = $sql->getPostsList('posts_list');
            $elements = '';

            // Get final posts list
            foreach($postsList as $element) {
                $elements .= "<li>Category: {$element[7]} | Title: {$element[1]} | Created at: {$element[3]} | Updated at: {$element[4]} | " . 
                        "<a href=\"view_edit.php?id={$element[0]}&num=1\">View...</a>
                        <a href=\"view_edit.php?id={$element[0]}&num=2\">Edit...</a></li>";
            }
            $result = preg_replace("/{ELEMENTS}/", $elements, $this->template);

            return $result;
        }

        /**
         * Get create or view page
         *
         * @param string $id - post id
         * @param bool $flag - create(0) or view(1) page
         * 
         * @return string final page
         */
        public function getSomePage($id = 0, $flag = false) {
            $sql = new PostsList();
            $categoriesList = $sql->getCategoriesList('posts_list');
            $elements = '';

            // If we want to load and selected category
            if ($flag) {
                $post = $sql->getPost($id);
                // Get final categories list
                foreach($categoriesList as $element) {
                    if ($element[0] === $post[6]) {
                        $elements .= "<option selected>{$element[0]}. {$element[1]}</option>";
                    }
                    else {
                        $elements .= "<option>{$element[0]}. {$element[1]}</option>";
                    }
                }
                
                // Get final information about specifical post
                $categoty = $categoriesList[$post[6] - 1][1];
                $result = preg_replace("/{TITLE}/", $post[1], $this->template);
                $result = preg_replace("/{DESCRIPTION}/", $post[2], $result);
                $result = preg_replace("/{AUTHOR}/", $post[5], $result);
                $result = preg_replace("/{OPTIONS}/", $elements, $result);
                $result = preg_replace("/{CREATED_AT}/", $post[3], $result);
                $result = preg_replace("/{UPDATED_AT}/", $post[4], $result);
                $result = preg_replace("/{CATEGORY}/", $categoty, $result);
            }
            // Another situation
            else {
                // Get final categories list
                foreach($categoriesList as $element)  {
                    $elements .= "<option>{$element[0]}. {$element[1]}</option>";
                }

                $result = preg_replace("/{OPTIONS}/", $elements, $this->template);
            }

            return $result;
        }
    }
