<?php 

require_once "Arquivos.php";
require_once "AnalistaCSV.php";
require_once "Email.php";


$dadosProcessados = (new AnalistaCSV)->processarDados("products.csv", "orders.csv");

$csv = (new Arquivos)->criarArquivo("dadosProcessados.csv", $dadosProcessados);

$email = Email::enviaEmail("dadosProcessados.csv");

