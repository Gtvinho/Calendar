<?php
        $host = 'localhost';
        $usuario = 'root';
        $senha = 'root';
        $bancoDeDados = 'calendario';

        $conexao = new mysqli($host, $usuario, $senha, $bancoDeDados);

        // Verifica se houve algum erro na conexão
        if ($conexao->connect_error) {
            die('Erro na conexão com o banco de dados: ' . $conexao->connect_error);
        }
        else{ 
            die('Foi porraaaaaaaaaaaa');
        }
/////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
        $query = "SELECT data, cor FROM datascores";
        $result = $conexao->query($query);

        // Criar um array para armazenar as cores
        $colors = array();


        // Verificar se a consulta retornou resultados
        if ($result->num_rows > 0) {
            // Percorrer os resultados e armazenar as datas e cores nas listas correspondentes
            while ($row = $result->fetch_assoc()) {
                $data = $row["data"];
                $cor = $row["cor"];
                $Array_Date[] = $data;
                $Array_Colors[] = $cor;
            }
        }
/////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
        $query = "SELECT id, texto FROM textocalendario";
        $result = $conexao->query($query);

        $id_do_textoBD = array(); 
        $texto_BD = array();
        if ($result->num_rows > 0) {
            // Percorrer os resultados e armazenar as datas e cores nas listas correspondentes
            while ($row = $result->fetch_assoc()) {
                $id_do_textoBD[] = $row['id'];
                $texto_BD[] = $row['texto'];
            }
        }
    ?>