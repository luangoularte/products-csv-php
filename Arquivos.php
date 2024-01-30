<?php 

class Arquivos {

    public function lerArquivos($arquivo, $cabecalho = true, $delimitador = ",") {
        
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

    public function criarArquivo($arquivo, $dados, $delimitador = ","){
        $csv = fopen($arquivo, "w");
        fputcsv($csv, ['ID_produto', "preço_unitário", "data_última_venda", "qtd_total_vendida", "valor_total_vendido"]);
        fputcsv($csv, [""]);
        foreach($dados as $linha){
            fputcsv($csv, $linha, $delimitador);
        }

        fclose($csv);
    }

}