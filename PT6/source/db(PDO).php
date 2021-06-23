<?php
    require_once 'source/logs.php';

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
        private $dbArray = array(
            'ip' => '127.0.0.1',
            'login' => 'root',
            'password' => '12345678',
            'db' => 'courses'
        );

        /**
         * Creating a database connection
         */
		public function __construct() {
            $this->logs = new Errors();
            
            // Database connection
            try {
                $this->link = new PDO(
                    "mysql:host={$this->dbArray['ip']};dbname={$this->dbArray['db']}", 
                    $this->dbArray['login'],
                    $this->dbArray['password']);
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
         * Executing select query
         * 
         * @param int $offset - offset in database
         * @param int $limit - posts limit
         * 
         * @return array posts list
         */
        public function selectPosts($offset, $limit) {
            try {
                $result = $this->link->query("SELECT `posts_list`.*, `categories_list`.`category_name`
                                            FROM `categories_list`
                                            INNER JOIN `posts_list` ON `posts_list`.`category` = `categories_list`.`category_id`
                                            LIMIT $limit OFFSET $offset");
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
         * Executing select query
         * 
         * @return int posts count
         */
        public function getPostsCount() {
            try {
                $result = $this->link->query("SELECT COUNT(`id`) FROM `posts_list`");
                return $result->fetchColumn(); 
            }
            catch (PDOException $e) {
                $this->logs->requestError($e->getMessage());
            }
        }

        /**
         * Executing select query
         * 
         * @param string $auth - specifical token
         * 
         * @return array query result
         */
        public function getUserInfoByCookie($auth) {
            try {
                $auth = $this->link->quote(trim($auth));

                $result = $this->link->query("SELECT `id`, `name`, `avatar` FROM `users` WHERE `remember` = $auth");
                return $result->fetch();
            }
            // Error processing
            catch (PDOException $e) {
                $this->logs->requestError($e->getMessage());
            }
        }

        /**
         * Executing select query
         * 
         * @param string $login - user login
         * @param string $password - user password
         * 
         * @return array query result
         */
        public function getUserInfoByLogin($login, $password) {
            try {
                $login = $this->link->quote(trim($login));
                $password = $this->link->quote(sha1(trim($password)));

                $result = $this->link->query("SELECT `id`, `name`, `avatar` FROM `users` WHERE `login`= $login AND `password`= $password");
                return $result->fetch();
            }
            // Error processing
            catch (PDOException $e) {
                $this->logs->requestError($e->getMessage());
            }
        }
        
        /**
         * Executing update query
         * 
         * @param string $auth - specifical token
         * @param string $login - user login
         * @param string $password - user password
         * 
         * @return bool query result
         */
        public function updateAuth($auth, $login, $password) {
            try {
                $auth = $this->link->quote(trim($auth));
                $login = $this->link->quote(trim($login));
                $password = $this->link->quote(sha1(trim($password)));

                return $this->link->query("UPDATE `users` SET `remember`= $auth WHERE `login`= $login AND `password`= $password");
            }
            // Error processing
            catch (PDOException $e) {
                $this->logs->requestError($e->getMessage());
            }
        }

        /**
         * Executing insert query
         * 
         * @param string $name - specifical token
         * @param string $email - user e-mail
         * @param string $login - user login
         * @param string $password - user password
         * 
         * @return bool query result
         */
        public function regNewUser($name, $email, $login, $password) {
            try {
                $name = $this->link->quote(trim($name));
                $email = $this->link->quote(trim($email));
                $login = $this->link->quote(trim($login));
                $password = $this->link->quote(sha1(trim($password)));

                $query = $this->link->query("SELECT * FROM `users` WHERE `login` = $login");
                $res = $query->fetchAll();

                if (!$res)
                {
                    $result = $this->link->prepare("INSERT INTO `users` SET `name` = $name, `email` = $email,
                                                `login` = $login, `password` = $password");
                    return $result->execute();
                }

                return false;
            }
            // Error processing
            catch (PDOException $e) {
                $this->logs->requestError($e->getMessage());
            }
        }

        /**
         * Executing update query
         * 
         * @param string $login - user login
         * @param string $email - user e-mail
         * 
         * @return bool query result
         */
        public function updatePassword($login, $email) {
            try {
                $login = $this->link->quote(trim($login));
                $email = $this->link->quote(trim($email));

                $query = $this->link->query("SELECT * FROM `users` WHERE `login` = $login AND `email` = $email");
                $res = $query->fetchAll();

                if ($res)
                {
                    $password = mt_rand(1, 2000000000) . mt_rand(1000000, 9999999) . mt_rand(1, 2000000000);
                    $_SESSION['newPassword'] = $password;
                    $password = $this->link->quote(sha1($password));

                    $result = $this->link->prepare("UPDATE `users` SET `password` = $password WHERE `login`= $login AND `email`= $email");
                    return $result->execute();
                }

                return false;
            }
            // Error processing
            catch (PDOException $e) {
                $this->logs->requestError($e->getMessage());
            }
        }

        /**
         * Executing update query
         * 
         * @param int $id - specifical user id
         * 
         * @return bool query result
         */
        public function removeRemember($id) {
            try {
                return $this->link->query("UPDATE `users` SET `remember`='' WHERE `id`= '$id'");
            }
            // Error processing
            catch (PDOException $e) {
                $this->logs->requestError($e->getMessage());
            }
        }
        
        /**
         * Executing update query
         * 
         * @param int $id - specifical user id
         * @param string $avatar - specifical user avatar
         * 
         * @return bool query result
         */
        public function updateAvatar($id, $avatar) {
            try {
                $avatar = $this->link->quote(trim($avatar));
                return $this->link->query("UPDATE `users` SET `avatar`=$avatar WHERE `id`= '$id'");
            }
            // Error processing
            catch (PDOException $e) {
                $this->logs->requestError($e->getMessage());
            }
        }
	}
