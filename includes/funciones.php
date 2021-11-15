<?php
require 'app.php';

function incluirTemplate ( $nombre ) {
    include TEMPLATES_URL . "/${nombre}.php";
}