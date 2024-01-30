<?php 

require_once "Arquivos.php";

class AnalistaCSV {

    protected array $arquivoProduto = [];

    public function processarDados($produtos, $pedidos){

        $produtosDados = (new Arquivos)->lerArquivos($produtos);
        $pedidosDados = (new Arquivos)->lerArquivos($pedidos);

        foreach($produtosDados as $produto){
            $idProduto1 = $produto["product_id"];
            $precoUnitario = $produto["price"];
            $pedidoData = "----/--/-- --:--";
            $quantidade = 0;

            $arquivoProduto[$idProduto1] = array (
                "ID_produto" => $idProduto1,
                "preço_unitário" => $precoUnitario, 
                "data_última_venda" => $pedidoData,
                "qtd_total_vendida" => $quantidade,
                "valor_total_vendido" => $precoUnitario * $quantidade
            );

            foreach($pedidosDados as $pedidos){        
                if($idProduto1 == $pedidos["product_id"]){
                    
                    $pedidoData = $pedidos["date"];
                    $quantidade += $pedidos["quantity"];

                    
                    if ($pedidoData > $arquivoProduto[$idProduto1]["data_última_venda"]) {
                        $arquivoProduto[$idProduto1]["data_última_venda"] = $pedidoData;
                    }

                    $arquivoProduto[$idProduto1] = array (
                        "ID_produto" => $idProduto1,
                        "preço_unitário" => $precoUnitario, 
                        "data_última_venda" => $arquivoProduto[$idProduto1]["data_última_venda"],
                        "qtd_total_vendida" => $quantidade,
                        "valor_total_vendido" => $precoUnitario * $quantidade
                    );
                }
            }
        }

        return $arquivoProduto;
    }
}