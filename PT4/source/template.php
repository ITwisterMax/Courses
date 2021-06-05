<?php
    require_once 'list.php';

    /**
     * Class for working with the templates
     *
     * @author Maksim Mikhalkov
     * @version 1.0
     */
    class Template
    {
        /**
         * @var string initial template
         */
        private $template;

        public function __construct()
        {
            // Nothing here
        }

        /**
         * Set main template
         *
         * @param string $mainTemplateFilename - path to file
         */
        public function setTemplate($mainTemplateFilename) {
            if (!is_file($mainTemplateFilename)) {
                file_put_contents(
                    'logs/errors.txt', 
                    date('Y-m-d H:i:s') . " | Template error (File not found)\n",
                    FILE_APPEND
                );
                die('Template error (File not found)');
            }

            $this->template = file_get_contents($mainTemplateFilename);
        }

        /**
         * Set main template
         *
         * @param string $id - post id
         * 
         * @return string final page
         */
        public function getPage($id = 0) {
            $sql = new PostsList();
            $postsList = $sql->getPostsList('posts_list');
            $elements = '';

            // Get final posts list
            foreach($postsList as $element) {
                $index = $element[0] - 1;
                $elements .= "<li>Category: {$element[7]} | Title: {$element[1]} | Created at: {$element[3]} | Updated at: {$element[4]} | " . 
                        "<a href=\"view.php?id={$index}\">More...</a></li>";
            }
            $result = preg_replace("/{ELEMENTS}/", $elements, $this->template);

            $categoriesList = $sql->getCategoriesList('posts_list');
            $elements = '';

            // Get final categories list
            foreach($categoriesList as $element) {
                if ($element[0] === $postsList[$id][6]) {
                    $elements .= "<option selected>{$element[0]}. {$element[1]}</option>";
                }
                else {
                    $elements .= "<option>{$element[0]}. {$element[1]}</option>";
                }
                
            }

            // Get final information about specifical post
            $result = preg_replace("/{TITLE}/", $postsList[$id][1], $result);
            $result = preg_replace("/{DESCRIPTION}/", $postsList[$id][2], $result);
            $result = preg_replace("/{AUTHOR}/", $postsList[$id][5], $result);
            $result = preg_replace("/{OPTIONS}/", $elements, $result);

            return $result;
        }
    }
