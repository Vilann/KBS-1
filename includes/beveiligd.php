<?php
session_start();
if (isset($_SESSION['lid'])) {
    header('Location: index');
}
