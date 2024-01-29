<?php 
require_once "GenerateCsv.php";
require_once "orders.csv";
require_once "products.csv";



use League\Csv\Reader;
use League\Csv\Statement;

$csv = Reader::createFromPath('/path/to/your/csv/file.csv', 'r');
$csv->setHeaderOffset(0);

use DateTime;

$orders = "orders.csv";
$products = "products.csv";


class Product extends GenerateFiles {
    protected string $dt_ultima_venda;
    protected int $qtd_total_vendida;
    protected int $valor_total_vendido;

    public function ultimaVenda($orders["id"], $orders) {

    }
    
}

