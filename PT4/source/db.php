<?php 
    /**
     * Class for working with the MySQL database (MySQLi)
     *
     * @author Maksim Mikhalkov
     * @version 1.0
     */
	class DataBase {
        /**
         * @var object connection link
         */
		private $link;

        /**
         * @var array parameters for connecting to the database
         */
        private $infoArray = array(
            'ip' => '127.0.0.1',
            'login' => 'root',
            'password' => '12345678',
            'db' => 'pt4'
        );

        /**
         * Creating a database connection
         */
		public function __construct() {
            // Database connection
            @$this->link = new mysqli(
                $this->infoArray['ip'],
                $this->infoArray['login'],
                $this->infoArray['password'],
                $this->infoArray['db']
            );

            // Error processing
            if ($this->link->connect_error) {
                file_put_contents(
                    'logs/errors.txt', 
                    date('Y-m-d H:i:s') . ' | Connection error (' . $this->link->connect_errno . ")\n",
                    FILE_APPEND
                );
                die('Connection error (' . $this->link->connect_errno . ')');
            }
		}

        /**
         * Close a database connection
         */
		public function __destruct() {
            $this->link->close();
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
                $infoArray['title'] = htmlspecialchars($this->link->real_escape_string(trim($infoArray['title'])));
                $infoArray['description'] = htmlspecialchars($this->link->real_escape_string(trim($infoArray['description'])));
                $infoArray['author'] = htmlspecialchars($this->link->real_escape_string(trim($infoArray['author'])));

                return $this->link->query("INSERT INTO `posts_list` SET `title` = '{$infoArray['title']}', `description` = '{$infoArray['description']}',
                                        `author` = '{$infoArray['author']}', `category` = '{$infoArray['category']}'");
            }
            // Error processing
            catch (Exception $e) {
                file_put_contents(
                    'logs/errors.txt', 
                    date('Y-m-d H:i:s') . ' | Error while executing request: (', $e->getMessage() . ")\n",
                    FILE_APPEND
                );
                die('Error while executing request: (' . $e->getMessage() . ')');
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
                $infoArray['title'] = htmlspecialchars($this->link->real_escape_string(trim($infoArray['title'])));
                $infoArray['description'] = htmlspecialchars($this->link->real_escape_string(trim($infoArray['description'])));
                $infoArray['author'] = htmlspecialchars($this->link->real_escape_string(trim($infoArray['author'])));

                return $this->link->query("UPDATE `posts_list` SET `title` = '{$infoArray['title']}', `description` = '{$infoArray['description']}',
                                        `updated_at` = '{$infoArray['time']}', `author` = '{$infoArray['author']}', `category` = '{$infoArray['category']}' 
                                        WHERE `id` = '{$infoArray['id']}'");
            }
            // Error processing
            catch (Exception $e) {
                file_put_contents(
                    'logs/errors.txt', 
                    date('Y-m-d H:i:s') . ' | Error while executing request: (', $e->getMessage() . ")\n",
                    FILE_APPEND
                );
                die('Error while executing request: (' . $e->getMessage() . ')');
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
                $result = $result->fetch_all();

                foreach ($result as &$element) {
                    // Error processing (decode)
                    $element[1] = htmlspecialchars_decode($element[1]);
                    $element[2] = htmlspecialchars_decode($element[2]);
                    $element[5] = htmlspecialchars_decode($element[5]);
                }

                return $result;
            }
            catch (Exception $e) {
                file_put_contents(
                    'logs/errors.txt', 
                    date('Y-m-d H:i:s') . ' | Error while executing request: (', $e->getMessage() . ")\n",
                    FILE_APPEND
                );
                die('Error while executing request: (' . $e->getMessage() . ')');
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
                return $result->fetch_all();
            }
            // Error processing
            catch (Exception $e) {
                file_put_contents(
                    'logs/errors.txt', 
                    date('Y-m-d H:i:s') . ' | Error while executing request: (', $e->getMessage() . ")\n",
                    FILE_APPEND
                );
                die('Error while executing request: (' . $e->getMessage() . ')');
            }
        }
	}
