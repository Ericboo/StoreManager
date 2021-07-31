<?php

require 'connection.php';

use ConexaoPHPPostgres\Connection as Connection;

$conn = Connection::get()->connect();