<?php
$link = new mysqli('localhost', 'root', 'root', 'curricular_db');
if ($link->connect_errno) {
    die('fail');
}