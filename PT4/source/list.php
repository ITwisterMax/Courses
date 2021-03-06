<?php 
    require_once 'db.php';

    /**
     * Class for working with the posts and categories lists
     *
     * @author Maksim Mikhalkov
     * @version 1.0
     */
	class PostsList {
        /**
         * @var array posts list
         */
		private $list;

        /**
         * @var object an instance of an object to work with db
         */
        private $sql;

        /**
         * Creating a posts list
         */
		public function __construct() {
            $this->sql = new DataBase();
            $this->list = array();
		}

        /**
         * Delete a posts list
         */
		public function __destruct() {
            unset($this->list);
		}

        /**
         * Get sorted in descending order posts list
         *
         * @return array posts list
         */
        public function getPostsList() {
            $list = $this->sql->selectPosts();
            
            // Sorting result array in alphabet order
            uasort($list, function($a, $b) { return ($a[4] <= $b[4]) ? 1 : -1; });
            
            return $list;
        }

        /**
         * Get categories list
         *
         * @return array categories list
         */
        public function getCategoriesList() {
            $list = $this->sql->selectCategories();
            
            return $list;
        }

        /**
         * Add a new post in posts list
         */
        public function addNewPost(&$infoArray) {
            $infoArray['category'] = $infoArray['category'][0];
            $this->sql->insert($infoArray);
        } 

        /**
         * Add a specifical post in posts list
         */
        public function updatePost(&$infoArray) {
            // Adding necessary information
            $infoArray['category'] = $infoArray['category'][0];
            $infoArray['time'] = date("Y-m-d H:i:s");
            $infoArray['id'] += 1;

            $this->sql->update($infoArray);
        }
	}
