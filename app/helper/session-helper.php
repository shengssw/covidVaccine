<?php
    session_start();

    function isLoggedIn() {
        if (isset($_SESSION['userid'])) {
            return true;
        } else {
            return false;
        }
    }