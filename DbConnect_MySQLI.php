<?php
	/**
	* Database Connection
	*/
    class DbConnect_MYSQLI {

	private $server = 'localhost';
	private $dbname = 'database';
	private $user = 'user';
	private $pass = 'password';

        private $mysqli;
        private $sql;
        private $result;
        private $fetchMode = MYSQLI_ASSOC;

        function __construct() {

            $this->mysqli = mysqli_connect($this->server, $this->user, $this->pass, $this->dbname);

            if (mysqli_connect_errno()) {
                echo "Error: Unable to connect to MySQL." . PHP_EOL;
                echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                exit;
            }

            $this->mysqli->query("SET NAMES 'utf8'");
            $this->mysqli->query("SET CHARACTER SET utf8");
        }


        function query($sql) {

            $this->sql = $this->mysqli->real_escape_string($sql);
            $this->result = $this->mysqli->query($sql);
    
            if ($this->result == true) {

            	$data = [];

                while ($row = $this->result->fetch_array($this->fetchMode)) {
                    $data[] = $row;
                }

                $this->result->close();

                return $data;
            }
            else {

                printf("<b>Problem with SQL:</b> %s\n", $this->sql);
                exit;
            }
        }

        public function id() {

            return $this->mysqli->insert_id;
        }

        public function __destruct() {

            $this->mysqli->close();
        }
    }
