<?php

include 'session.php';


if(isset($_SESSION['nome_usuario'])) {
    session_destroy();
    header('Location: '. $link . '/');
    exit;
} else {
    header('Location: '. $link . '/');
    exit;
}