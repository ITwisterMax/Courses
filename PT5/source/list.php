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
         * Delete a posts list and a sql copy
         */
		public function __destruct() {
            unset($this->sql);
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
            uasort($list, function($a, $b) { return ($a[3] <= $b[3]) ? 1 : -1; });
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
         * 
         * @param array $infoArray - array with information about specifical post
         */
        public function addNewPost(&$infoArray) {
            $infoArray['category'] = $infoArray['category'][0];
            return $this->sql->insert($infoArray);
        } 

        /**
         * Add a specifical post in posts list
         * 
         * @param array $infoArray - array with information about specifical post
         */
        public function updatePost(&$infoArray) {
            // Adding necessary information
            $infoArray['category'] = $infoArray['category'][0];
            $infoArray['time'] = date("Y-m-d H:i:s");

            return $this->sql->update($infoArray);
        }

        /**
         * Get a specifical post
         *
         * @return array specifical post
         */
        public function getPost($id) {
            return $this->sql->selectPost($id);
        }

        /**
         * Delete a specifical post in posts list
         * 
         * @param int $id - specifical post id
         */
        public function deletePost($id) {
            return $this->sql->delete($id);
        }
	}
