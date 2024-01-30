<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

class Dados{

    public static function lerArquivos($arquivo, $cabecalho = true, $delimitador = ",") {
        
        $dados = [];
        $csv = fopen($arquivo, "r");
       
        $cabecalhoDados = $cabecalho ? fgetcsv($csv, 0, $delimitador) : [];
        
        while($linha = fgetcsv($csv, 0, $delimitador)){
            $dados[] = $cabecalho ? 
                        array_combine($cabecalhoDados, $linha) : 
                        $linha;
        }
        
        fclose($csv);

        return $dados;
    }

    public static function criaArquivo($arquivo, $dados, $delimitador = ","){
        $csv = fopen($arquivo, "w");
        fputcsv($csv, ['ID_produto', "preço_unitário", "data_última_venda", "qtd_total_vendida", "valor_total_vendido"]);
        foreach($dados as $linha){
            fputcsv($csv, $linha, $delimitador);
        }

        fclose($csv);
    }

    
}


$arquivoProduto = array();

$produtosDados = Dados::lerArquivos("products.csv");
$ordensDados = Dados::lerArquivos("orders.csv");



foreach($ordensDados as $ordens) {
    $idProduto = $ordens["product_id"];
    $ordemData = $ordens["date"];
    $quantidade = $ordens["quantity"];

    foreach($produtosDados as $produto){
        if($produto["product_id"] == $idProduto){
            $precoUnitario = $produto["price"];
        

            if (isset($arquivoProduto[$idProduto])){
                if ($ordemData > $arquivoProduto[$idProduto]["data_última_venda"]) {
                    $arquivoProduto[$idProduto]["data_última_venda"] = $ordemData;
                }

                $arquivoProduto[$idProduto]["qtd_total_vendida"] += $quantidade;
            } else {
                $arquivoProduto[$idProduto] = array (
                    "ID_produto" => $idProduto,
                    "preço_unitário" => $precoUnitario, 
                    "data_última_venda" => $ordemData,
                    "qtd_total_vendida" => $quantidade,
                    "valor_total_vendido" => $precoUnitario * $quantidade
                );
            }
        }
        
    }
 
}

$success = Dados::criaArquivo("escrita.csv", $arquivoProduto);


try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
    $mail->isSMTP();                                          
    $mail->Host       = 'smtp.gmail.com';                     
    $mail->SMTPAuth   = true;                                  
    $mail->Username   = 'luan.ag2012gk@gmail.com';                    
    $mail->Password   = 'jgny mrcp citm gkkc';                               
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;           
    $mail->Port       = 465;
    $mail->SMTPAuth = true;

    $mail->setFrom('luan.ag2012gk@gmail.com', 'Teste');
    $mail->addAddress('luan.ag2012gk@gmail.com', 'Luan');

    $mail->addAttachment("escrita.csv"); //attachment para envio de arquivo

    $mail->isHTML(true);                                  
    $mail->Subject = 'Teste Desafio';
    $mail->Body    = '<h1>Arquivo</h1>';
    $mail->AltBody = 'Arquivo produtos';

    $mail->send();

    echo 'Email enviado com sucesso';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}



