<?php

    class Provider {
        private $db;

        public function __construct() {
            $this->db = new Database;
        }

    }