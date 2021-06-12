<?php 
    require_once 'logs.php';

    /**
     * Class for working with the MySQL database (PDO)
     *
     * @author Maksim Mikhalkov
     * @version 2.0
     */
	class DataBase {
        /**
         * @var object connection link
         */
		private $link;

        /**
         * @var object errors
         */
        private $logs;

        /**
         * @var array parameters for connecting to the database
         */
        private $infoArray = array(
            'ip' => '127.0.0.1',
            'login' => 'root',
            'password' => '12345678',
            'db' => 'pt'
        );

        /**
         * Creating a database connection
         */
		public function __construct() {
            $this->logs = new Errors();
            
            // Database connection
            try {
                $this->link = new PDO(
                    "mysql:host={$this->infoArray['ip']};dbname={$this->infoArray['db']}", 
                    $this->infoArray['login'],
                    $this->infoArray['password']);
            }
            // Error processing
            catch (PDOException $e) {
                $this->logs->dbError($e->getMessage());
            }
		}

        /**
         * Close a database connection
         */
		public function __destruct() {
            $this->link = null;
		}

        /**
         * Executing insert query (posts_list)
         *
         * @param array $infoArray - array with information about the post
         * @return bool query result
         */
        public function insert(&$infoArray) {
            try {
                // Injection protection
                $infoArray['title'] = htmlspecialchars($this->link->quote(trim($infoArray['title'])));
                $infoArray['description'] = htmlspecialchars($this->link->quote(trim($infoArray['description'])));
                $infoArray['author'] = htmlspecialchars($this->link->quote(trim($infoArray['author'])));

                return $this->link->query("INSERT INTO `posts_list` SET `title` = {$infoArray['title']}, `description` = {$infoArray['description']},
                `author` = {$infoArray['author']}, `category` = '{$infoArray['category']}'");
            }
            // Error processing
            catch (PDOException $e) {
                $this->logs->requestError($e->getMessage());
            }
        }

        /**
         * Executing update query (posts_list)
         *
         * @param array $infoArray - array with information about the post
         * @return bool query result
         */
        public function update(&$infoArray) {
            try {
                // Injection protection
                $infoArray['title'] = htmlspecialchars($this->link->quote(trim($infoArray['title'])));
                $infoArray['description'] = htmlspecialchars($this->link->quote(trim($infoArray['description'])));
                $infoArray['author'] = htmlspecialchars($this->link->quote(trim($infoArray['author'])));

                return $this->link->query("UPDATE `posts_list` SET `title` = {$infoArray['title']}, `description` = {$infoArray['description']},
                                        `updated_at` = '{$infoArray['time']}', `author` = {$infoArray['author']}, `category` = '{$infoArray['category']}' 
                                        WHERE `id` = '{$infoArray['id']}'");
            }
            // Error processing
            catch (PDOException $e) {
                $this->logs->requestError($e->getMessage());
            }
        }

        /**
         * Executing select query (posts_list)
         * 
         * @return array query result
         */
        public function selectPosts() {
            try {
                $result = $this->link->query("SELECT `posts_list`.*, `categories_list`.`category_name`
                                            FROM `categories_list`
                                            INNER JOIN `posts_list` ON `posts_list`.`category` = `categories_list`.`category_id`");
                $result = $result->fetchAll();

                foreach ($result as &$element) {
                    // Error processing (decode)
                    $element[1] = htmlspecialchars_decode($element[1]);
                    $element[2] = htmlspecialchars_decode($element[2]);
                    $element[5] = htmlspecialchars_decode($element[5]);
                }

                return $result;
            }
            catch (PDOException $e) {
                $this->logs->requestError($e->getMessage());
            }
        }

        /**
         * Executing select query (categories_list)
         * 
         * @return array query result
         */
        public function selectCategories() {
            try {
                $result = $this->link->query("SELECT * FROM `categories_list`");
                return $result = $result->fetchAll();;
            }
            // Error processing
            catch (PDOException $e) {
                $this->logs->requestError($e->getMessage());
            }
        }

        /**
         * Executing delete query (posts_list)
         * 
         * @param int $id - specifical post id
         * @return bool query result
         */
        public function selectPost($id) {
            try {
                $result = $this->link->query("SELECT * FROM `posts_list` WHERE `id` = {$id}");
                return $result = $result->fetch();
            }
            // Error processing
            catch (PDOException $e) {
                $this->logs->requestError($e->getMessage());
            }
        }

        /**
         * Executing delete query (posts_list)
         * 
         * @param int $id - specifical post id
         * @return bool query result
         */
        public function delete($id) {
            try {
                return $this->link->query("DELETE FROM `posts_list` WHERE `id` = {$id}");
            }
            // Error processing
            catch (PDOException $e) {
                $this->logs->requestError($e->getMessage());
            }
        }
	}
