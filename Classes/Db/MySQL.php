<?php

    namespace DB;

use PDO;
use PDOException;

class MySQL {

        private object $db;

        public function __construct()
        {
            $this->db = $this->setDb();
        }

        private function setDb() {
            
            try {
                return new PDO(
                    'mysql:host='. HOST .';dbname='. BANCO .';', USER , PASSWORD
                );
            } catch (PDOException $exception) {
                throw new PDOException($exception->getMessage());
            }

        }

        public function getDb() {
            return $this->db;
        }

    }