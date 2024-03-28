
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="style.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario IGS</title>
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
                $datasArray[] = $data;
                $coresArray[] = $cor;
            }
        }
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



</head>
<body>
    <?php
        //variaveis necessarias
        $DataSemana=['D','S','T','Q','Q','S','S']; 
        $mes = ['1','2','3','4','5','6','7','8','9','10',
        '11','12','13','14','15','16','17','18','19','20','21',
        '22','23','24','25','26','27','28','29','30','31' ];
        $aux1 = 0 ; 
        $aux2 = 0;  
        $idTexo = 1;
    ?>
    <div class ='container'> 
    <aside>
        <h3>Legendas de Cores</h3>
        <div class="color-item">
        <div class="color-box" style="background-color: #3399ff;"></div>
        <span>Feriado Nacional</span>
        </div>
        <div class="color-item">
        <div class="color-box" style="background-color: #ffc000;"></div>
        <span>Feriado Local</span>
        </div>
        <div class="color-item">
        <div class="color-box" style="background-color: #ffff00;"></div>
        <span>Férias</span>
        </div>
        <div class="color-item">
        <div class="color-box" style="background-color: #999999;"></div>
        <span>Recesso</span>
        </div>
        <div class="color-item">
        <div class="color-box" style="background-color: #ffcc99;"></div>
        <span>Palestras</span>
        </div>
        <div class="color-item">
        <div class="color-box" style="background-color: #7030a0;"></div>
        <span>Eventos</span>
        </div>
        <div class="color-item">
        <div class="color-box" style="background-color: #4472c4;"></div>
        <span>Assembleia Treinamentos</span>
        </div>
        <div class="color-item">
        <div class="color-box" style="background-color: #66cc66;"></div>
        <span>Festivas</span>
        </div>
        <div class="color-item">
        <div class="color-box" style="background-color: #336600;"></div>
        <span>Visita Governador</span>
        </div>
        <div class="color-item">
        <div class="color-box" style="background-color: #ff00ff;"></div>
        <span>Conferencia</span>
        </div>
  </aside>
        <div id = 'calendario'>
    <table border="1" cellpadding="1" cellspacing="1" height="213" style="margin-left:auto;margin-right:auto;" width="1000">

        <tbody>
            <tr>
                <td colspan="7" rowspan="1" style="width: 140px; height: 25px; text-align: center; vertical-align: middle;"><strong>01 - JANEIRO 2023</strong></td>
                <td style="text-align: right; vertical-align: middle; width: 300px; height: 25px;"><strong>&nbsp; </strong></td>
                <td colspan="7" rowspan="1" style="width: 140px; height: 25px; text-align: center; vertical-align: middle;"><strong>02 - FEVEREIRO 2023</strong></td>
                <td style="text-align: right; vertical-align: middle; width: 300px; height: 25px;"><strong></strong></td>
            </tr>
            <!-- Dias da semana --> 
            <tr>
            <?php
                $x = 0;
                $idTexo = 1;
                while ($x < 2) {
                    $D = 0;

                    while ($D < 7) {
                        echo '<td style="text-align: center; vertical-align: middle; width: 20px; height: 20px;"><strong>'.$DataSemana[$D].'</strong></td>';
                        $D = $D + 1;
                    }

                    if (in_array($idTexo, $id_do_textoBD)) {
                        $key = array_search($idTexo, $id_do_textoBD);
                        $texto = $texto_BD[$key];
                        echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
                    } else {
                        echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
                    }

                    $idTexo = $idTexo + 1;
                    $x = $x + 1;
                }
?>

            </tr> 
            <!-- Linha 1 com datas --> 
            <tr> 
                <?php
                $x = 0;
                while ($x < 2) { 
                    $D = 0;
                    while ($D < 7) {
                        if($x == 1 and $D > 2){ 
                            $dataVar = strval($mes[$D-3].'-02'); 
                                if(in_array($dataVar , $datasArray)){
                                    $posicaoCor = array_search($dataVar, $datasArray); 
                                    echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D-3].'</td>';    
                                    $posicaoCor = $posicaoCor + 1; 
                                }else{ 
                                    echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D-3].'</td>';
                                }
                                                           
                        $aux2 = $mes[$D-3]; 
                        }else{ 
                            echo'<td style="text-align: center; vertical-align: middle; width: 20px; height: 20px;"><strong></strong></td>';
                        }

                        $D = $D + 1; 
                    }
                    if (in_array($idTexo, $id_do_textoBD)) {
                        $key = array_search($idTexo, $id_do_textoBD);
                        $texto = $texto_BD[$key];
                        echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
                    } else {
                        echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
                    }

                    $idTexo = $idTexo + 1;
                    $x = $x + 1;
                }
                
                ?>
            </tr> 
            <!-- Linha 2 com datas --> 
            <tr> 
                <?php
                $x = 0;
                while ($x < 2) { 
                    $D = 0;
                    while ($D < 7) {
                        if ($x == 0){ 
                            $dataVar = strval($mes[$D].'-01');
                            if(in_array($dataVar , $datasArray)){
                                $posicaoCor = array_search($dataVar, $datasArray); 
                                echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D].'</td>';    
                                
                            }
                            else{
                                echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D].'</td>';
                            }
                            
                        }else{ 
                            $dataVar = strval($mes[$aux2+$D].'-02');
                            if(in_array($dataVar , $datasArray)){
                                $posicaoCor = array_search($dataVar, $datasArray); 
                                echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D].'</td>';    
                                
                            }
                            else{
                                echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D].'</td>';
                            }}
                        if($x == 0 and $D == 6){ 
                            $aux1 = $mes[$D + $aux1]; 
                        }
                        elseif($x ==1 and $D == 6 ){ 
                            $aux2 = $mes[$D + $aux2];
                        }

                        $D = $D + 1; 
                    }
                    if (in_array($idTexo, $id_do_textoBD)) {
                        $key = array_search($idTexo, $id_do_textoBD);
                        $texto = $texto_BD[$key];
                        echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
                    } else {
                        echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
                    }

                    $idTexo = $idTexo + 1;
                    $x = $x + 1; 
                }
                
                ?>
            </tr>
            <!-- Linha 3 com datas --> 
            <tr> 
                <?php
                $x = 0;
                while ($x < 2) { 
                    $D = 0;
                    while ($D < 7) {
                        if ($x == 0){ 
                            $dataVar = strval($mes[$aux1+$D].'-01');
                            if(in_array($dataVar , $datasArray)){
                                $posicaoCor = array_search($dataVar, $datasArray); 
                                echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';    
                                
                            }
                            else{
                                echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';
                            }
                        }else{ 
                            $dataVar = strval($mes[$aux2+$D].'-02');
                            if(in_array($dataVar , $datasArray)){
                                $posicaoCor = array_search($dataVar, $datasArray); 
                                echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux2+$D].'</td>';    
                                
                            }
                            else{
                                echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux2+$D].'</td>';
                            }
                        }
                        if($x == 0 and $D == 6){ 
                            $aux1 = $mes[$D + $aux1]; 
                        }
                        elseif($x ==1 and $D == 6 ){ 
                            $aux2 = $mes[$D + $aux2];
                        }

                        $D = $D + 1; 
                    }
                    if (in_array($idTexo, $id_do_textoBD)) {
                        $key = array_search($idTexo, $id_do_textoBD);
                        $texto = $texto_BD[$key];
                        echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
                    } else {
                        echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
                    }

                    $idTexo = $idTexo + 1;
                    $x = $x + 1; 
                }
                
                ?>
            </tr>  
            <!-- Linha 4 com datas --> 
            <tr> 
                <?php
                $x = 0;
                while ($x < 2) { 
                    $D = 0;
                    while ($D < 7) {
                        if ($x == 0){ 
                            $dataVar = strval($mes[$aux1+$D].'-01');
                            if(in_array($dataVar , $datasArray)){
                                $posicaoCor = array_search($dataVar, $datasArray); 
                                echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';    
                                
                            }
                            else{
                                echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';
                            }
                        }else{ 
                            $dataVar = strval($mes[$aux2+$D].'-02');
                            if(in_array($dataVar , $datasArray)){
                                $posicaoCor = array_search($dataVar, $datasArray); 
                                echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux2+$D].'</td>';    
                                
                            }
                            else{
                                echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux2+$D].'</td>';
                            }
                        }
                        if($x == 0 and $D == 6){ 
                            $aux1 = $mes[$D + $aux1]; 
                        }
                        elseif($x ==1 and $D == 6 ){ 
                            $aux2 = $mes[$D + $aux2];
                        }

                        $D = $D + 1; 
                    }
                    if (in_array($idTexo, $id_do_textoBD)) {
                        $key = array_search($idTexo, $id_do_textoBD);
                        $texto = $texto_BD[$key];
                        echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
                    } else {
                        echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
                    }

                    $idTexo = $idTexo + 1;
                    $x = $x + 1;
                }
                
                ?>
            </tr>  
            <!-- Linha 5 com datas --> 
            <tr> 
                <?php
                $x = 0;
                while ($x < 2) { 
                    $D = 0;
                    while ($D < 7) {
                        
                        if ($x == 0){ 
                            $dataVar = strval($mes[$aux1+$D].'-01');
                            if(in_array($dataVar , $datasArray)){
                                $posicaoCor = array_search($dataVar, $datasArray); 
                                echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';    
                                
                            }
                            else{
                                echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';
                            }
                        }else{ 
                            $dataVar = strval($mes[$aux2+$D].'-02');
                            if($mes[$aux2+$D]<=28){
                            if(in_array($dataVar , $datasArray)){
                                $posicaoCor = array_search($dataVar, $datasArray); 
                                echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux2+$D].'</td>';    
                                
                            }
                            else{
                                
                                echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux2+$D].'</td>';
                                
                            }
                        }
                        else{
                            echo'<td style="text-align: center; vertical-align: middle; width: 20px; height: 20px;"><strong></strong></td>';
                        }
                    }
                        if($x == 0 and $D == 6){ 
                            $aux1 = $mes[$D + $aux1]; 
                        }
                        

                        $D = $D + 1; 
                    }
                    if (in_array($idTexo, $id_do_textoBD)) {
                        $key = array_search($idTexo, $id_do_textoBD);
                        $texto = $texto_BD[$key];
                        echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
                    } else {
                        echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
                    }

                    $idTexo = $idTexo + 1;
                    $x = $x + 1;
                }
                
                ?>
            </tr>
            <!-- Linha 6 com datas --> 
            <tr> 
                <?php
                $x = 0;
                while ($x < 2) { 
                    $D = 0;
                    while ($D < 7) {
                        if ($x == 0){ 
                            $dataVar = strval($mes[$aux1+$D].'-01');
                            if(in_array($dataVar , $datasArray)){
                                $posicaoCor = array_search($dataVar, $datasArray); 
                                echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';    
                                
                            }
                            else{
                                echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';
                            }
                        }else{ 
                            echo '<td style="text-align: center; vertical-align: middle; width: 20px; height: 20px; "></td>';
                        }
                        
                        if($x == 0 and $D == 6){ 
                            $aux1 = $mes[$D + $aux1]; 
                        }
                        elseif($x ==1 and $D == 6 ){ 
                            $aux2 = $mes[$D + $aux2];
                        }

                        $D = $D + 1; 
                }
                echo '<form id="formulario" method="POST" action="salvar">';
                if (in_array($idTexo, $id_do_textoBD)) {
                    $key = array_search($idTexo, $id_do_textoBD);
                    $texto = $texto_BD[$key];
                    echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
                } else {
                    echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
                }
                echo '</form>';
                $idTexo = $idTexo + 1;
                $x = $x + 1;
                }
                
                ?>
            </tr>

   
            </tbody>
        </table>
            <!-- Inicio meses Março e Abril -->
            <table border="1" cellpadding="1" cellspacing="1" height="213" style="margin-left:auto;margin-right:auto;" width="1000">

<tbody>
    <tr>
        <td colspan="7" rowspan="1" style="width: 140px; height: 25px; text-align: center; vertical-align: middle;"><strong>03 - MARÇO 2023</strong></td>
        <td style="text-align: right; vertical-align: middle; width: 300px; height: 25px;"><strong>&nbsp; </strong></td>
        <td colspan="7" rowspan="1" style="width: 140px; height: 25px; text-align: center; vertical-align: middle;"><strong>04 - ABRIL 2023</strong></td>
        <td style="text-align: right; vertical-align: middle; width: 300px; height: 25px;"><strong></strong></td>
    </tr>
    <!-- Dias da semana --> 
    <tr>
        <?php
                $x = 0;

                while ($x < 2) {
                    $D = 0;

                    while ($D < 7) {
                        echo '<td style="text-align: center; vertical-align: middle; width: 20px; height: 20px;"><strong>'.$DataSemana[$D].'</strong></td>';
                        $D = $D + 1;
                    }

                    if (in_array($idTexo, $id_do_textoBD)) {
                        $key = array_search($idTexo, $id_do_textoBD);
                        $texto = $texto_BD[$key];
                        echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
                    } else {
                        echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
                    }

                    $idTexo = $idTexo + 1;
                    $x = $x + 1;
                }
        ?>

    </tr> 
    <!-- Linha 1 com datas --> 
    <tr> 
        <?php
        $x = 0;
        while ($x < 2) { 
            $D = 0;
            while ($D < 7) {
                if($x == 1 and $D > 5){ 
                    $dataVar = strval($mes[$D].'-04'); 
                        if(in_array($dataVar , $datasArray)){
                            $posicaoCor = array_search($dataVar, $datasArray); 
                            echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D-6].'</td>';    
                            $posicaoCor = $posicaoCor + 1; 
                        }else{ 
                            echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D-6].'</td>';
                        }
                                                   
                $aux2 = $mes[$D-6]; 
                }else{ 
                    echo'<td style="text-align: center; vertical-align: middle; width: 20px; height: 20px;"><strong></strong></td>';
                }

                $D = $D + 1; 
            }
            if (in_array($idTexo, $id_do_textoBD)) {
                $key = array_search($idTexo, $id_do_textoBD);
                $texto = $texto_BD[$key];
                echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
            } else {
                echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
            }

            $idTexo = $idTexo + 1;
            $x = $x + 1;
        }
        
        ?>
    </tr> 
    <!-- Linha 2 com datas --> 
    <tr> 
        <?php
        $x = 0;
        while ($x < 2) { 
            $D = 0;
            while ($D < 7) {
                if ($x == 0){ 
                    $dataVar = strval($mes[$D-3].'-03');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D-3].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D-3].'</td>';
                    }
                    
                }else{ 
                    $dataVar = strval($mes[$aux2+$D].'-04');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D+1].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D+1].'</td>';
                    }}
                if($x == 0 and $D == 6){ 
                    $aux1 = $mes[($D-3) + $aux1]; 
                }
                elseif($x ==1 and $D == 6 ){ 
                    $aux2 = $mes[$D + $aux2];
                }

                $D = $D + 1; 
            }
            if (in_array($idTexo, $id_do_textoBD)) {
                $key = array_search($idTexo, $id_do_textoBD);
                $texto = $texto_BD[$key];
                echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
            } else {
                echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
            }

            $idTexo = $idTexo + 1;
            $x = $x + 1; 
        }
        
        ?>
    </tr>
    <!-- Linha 3 com datas --> 
    <tr> 
        <?php
        $x = 0;
        while ($x < 2) { 
            $D = 0;
            while ($D < 7) {
                if ($x == 0){ 
                    $dataVar = strval($mes[$aux1+$D].'-03');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';
                    }
                }else{ 
                    $dataVar = strval($mes[$aux2+$D].'-04');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux2+$D].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux2+$D].'</td>';
                    }
                }
                if($x == 0 and $D == 6){ 
                    $aux1 = $mes[$D + $aux1]; 
                }
                elseif($x ==1 and $D == 6 ){ 
                    $aux2 = $mes[$D + $aux2];
                }

                $D = $D + 1; 
            }
            if (in_array($idTexo, $id_do_textoBD)) {
                $key = array_search($idTexo, $id_do_textoBD);
                $texto = $texto_BD[$key];
                echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
            } else {
                echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
            }

            $idTexo = $idTexo + 1;
            $x = $x + 1; 
        }
        
        ?>
    </tr>  
    <!-- Linha 4 com datas --> 
    <tr> 
        <?php
        $x = 0;
        while ($x < 2) { 
            $D = 0;
            while ($D < 7) {
                if ($x == 0){ 
                    $dataVar = strval($mes[$aux1+$D].'-03');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';
                    }
                }else{ 
                    $dataVar = strval($mes[$aux2+$D].'-04');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux2+$D].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux2+$D].'</td>';
                    }
                }
                if($x == 0 and $D == 6){ 
                    $aux1 = $mes[$D + $aux1]; 
                }
                elseif($x ==1 and $D == 6 ){ 
                    $aux2 = $mes[$D + $aux2];
                }

                $D = $D + 1; 
            }
            if (in_array($idTexo, $id_do_textoBD)) {
                $key = array_search($idTexo, $id_do_textoBD);
                $texto = $texto_BD[$key];
                echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
            } else {
                echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
            }

            $idTexo = $idTexo + 1;
            $x = $x + 1;
        }
        
        ?>
    </tr>  
    <!-- Linha 5 com datas --> 
    <tr> 
        <?php
        $x = 0;
        while ($x < 2) { 
            $D = 0;
            while ($D < 7) {
                
                if ($x == 0){ 
                    $dataVar = strval($mes[$aux1+$D].'-03');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';
                    }
                }else{ 
                    $dataVar = strval($mes[$aux2+$D].'-04');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux2+$D].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux2+$D].'</td>';
                    }
                }
                if($x == 0 and $D == 6){ 
                    $aux1 = $mes[$D + $aux1]; 
                }
                

                $D = $D + 1; 
            }
            if (in_array($idTexo, $id_do_textoBD)) {
                $key = array_search($idTexo, $id_do_textoBD);
                $texto = $texto_BD[$key];
                echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
            } else {
                echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
            }

            $idTexo = $idTexo + 1;
            $x = $x + 1;
        }
        
        ?>
    </tr>
    <!-- Linha 6 com datas --> 
    <tr> 
        <?php
        $x = 0;
        while ($x < 2) { 
            $D = 0;
            while ($D < 7) {
                if ($x == 0){ 
                    $dataVar = strval($mes[$aux1+$D].'-03');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';
                    }
                }else{ 
                    echo '<td style="text-align: center; vertical-align: middle; width: 20px; height: 20px; "></td>';
                }
                
                if($x == 0 and $D == 6){ 
                    $aux1 = $mes[$D + $aux1]; 
                }
                elseif($x ==1 and $D == 6 ){ 
                    $aux2 = $mes[$D + $aux2];
                }

                $D = $D + 1; 
        }
        echo '<form id="formulario" method="POST" action="salvar">';
        if (in_array($idTexo, $id_do_textoBD)) {
            $key = array_search($idTexo, $id_do_textoBD);
            $texto = $texto_BD[$key];
            echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
        } else {
            echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
        }
        echo '</form>';
        $idTexo = $idTexo + 1;
        $x = $x + 1;
        }
        
        ?>
    </tr>


    </tbody>
</table>
            <!-- Inicio meses Maio e junho --> 
            <table border="1" cellpadding="1" cellspacing="1" height="213" style="margin-left:auto;margin-right:auto;" width="1000">

<tbody>
    <tr>
        <td colspan="7" rowspan="1" style="width: 140px; height: 25px; text-align: center; vertical-align: middle;"><strong>05 - MAIO 2023</strong></td>
        <td style="text-align: right; vertical-align: middle; width: 300px; height: 25px;"><strong>&nbsp; </strong></td>
        <td colspan="7" rowspan="1" style="width: 140px; height: 25px; text-align: center; vertical-align: middle;"><strong>06 - JUNHO 2023</strong></td>
        <td style="text-align: right; vertical-align: middle; width: 300px; height: 25px;"><strong></strong></td>
    </tr>
    <!-- Dias da semana --> 
    <tr>
        <?php
                $x = 0;

                while ($x < 2) {
                    $D = 0;

                    while ($D < 7) {
                        echo '<td style="text-align: center; vertical-align: middle; width: 20px; height: 20px;"><strong>'.$DataSemana[$D].'</strong></td>';
                        $D = $D + 1;
                    }

                    if (in_array($idTexo, $id_do_textoBD)) {
                        $key = array_search($idTexo, $id_do_textoBD);
                        $texto = $texto_BD[$key];
                        echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
                    } else {
                        echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
                    }

                    $idTexo = $idTexo + 1;
                    $x = $x + 1;
                }
        ?>

    </tr> 
    <!-- Linha 1 com datas --> 
    <tr> 
        <?php
        $x = 0;
        while ($x < 2) { 
            $D = 0;
            while ($D < 7) {
                if($x == 1 and $D > 3){ 
                    $dataVar = strval($mes[$D-4].'-06'); 
                        if(in_array($dataVar , $datasArray)){
                            $posicaoCor = array_search($dataVar, $datasArray); 
                            echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D-4].'</td>';    
                            $posicaoCor = $posicaoCor + 1; 
                        }else{ 
                            echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D-4].'</td>';
                        }
                                                   
                $aux2 = $mes[$D-4]; 
                }else{ 
                    echo'<td style="text-align: center; vertical-align: middle; width: 20px; height: 20px;"><strong></strong></td>';
                }

                $D = $D + 1; 
            }
            if (in_array($idTexo, $id_do_textoBD)) {
                $key = array_search($idTexo, $id_do_textoBD);
                $texto = $texto_BD[$key];
                echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
            } else {
                echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
            }

            $idTexo = $idTexo + 1;
            $x = $x + 1;
        }
        
        ?>
    </tr> 
    <!-- Linha 2 com datas --> 
    <tr> 
        <?php
        $x = 0;
        while ($x < 2) { 
            $D = 0;
            while ($D < 7) {
                if ($x == 0){ 
                    $dataVar = strval($mes[$D-3].'-05');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D-1].'</td>';
                    }
                    
                }else{ 
                    $dataVar = strval($mes[$aux2+$D].'-06');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D+3].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D+3].'</td>';
                    }}
                if($x == 0 and $D == 6){ 
                    $aux1 = $mes[($D-1) + $aux1]; 
                }
                elseif($x ==1 and $D == 6 ){ 
                    $aux2 = $mes[($D) + $aux2];
                }

                $D = $D + 1; 
            }
            if (in_array($idTexo, $id_do_textoBD)) {
                $key = array_search($idTexo, $id_do_textoBD);
                $texto = $texto_BD[$key];
                echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
            } else {
                echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
            }

            $idTexo = $idTexo + 1;
            $x = $x + 1; 
        }
        
        ?>
    </tr>
    <!-- Linha 3 com datas --> 
    <tr> 
        <?php
        $x = 0;
        while ($x < 2) { 
            $D = 0;
            while ($D < 7) {
                if ($x == 0){ 
                    $dataVar = strval($mes[$aux1+$D].'-05');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';
                    }
                }else{ 
                    $dataVar = strval($mes[$aux2+$D].'-06');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux2+$D].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux2+$D].'</td>';
                    }
                }
                if($x == 0 and $D == 6){ 
                    $aux1 = $mes[$D + $aux1]; 
                }
                elseif($x ==1 and $D == 6 ){ 
                    $aux2 = $mes[$D + $aux2];
                }

                $D = $D + 1; 
            }
            if (in_array($idTexo, $id_do_textoBD)) {
                $key = array_search($idTexo, $id_do_textoBD);
                $texto = $texto_BD[$key];
                echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
            } else {
                echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
            }

            $idTexo = $idTexo + 1;
            $x = $x + 1; 
        }
        
        ?>
    </tr>  
    <!-- Linha 4 com datas --> 
    <tr> 
        <?php
        $x = 0;
        while ($x < 2) { 
            $D = 0;
            while ($D < 7) {
                if ($x == 0){ 
                    $dataVar = strval($mes[$aux1+$D].'-05');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';
                    }
                }else{ 
                    $dataVar = strval($mes[$aux2+$D].'-06');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux2+$D].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux2+$D].'</td>';
                    }
                }
                if($x == 0 and $D == 6){ 
                    $aux1 = $mes[$D + $aux1]; 
                }
                elseif($x ==1 and $D == 6 ){ 
                    $aux2 = $mes[$D + $aux2];
                }

                $D = $D + 1; 
            }
            if (in_array($idTexo, $id_do_textoBD)) {
                $key = array_search($idTexo, $id_do_textoBD);
                $texto = $texto_BD[$key];
                echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
            } else {
                echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
            }

            $idTexo = $idTexo + 1;
            $x = $x + 1;
        }
        
        ?>
    </tr>  
    <!-- Linha 5 com datas --> 
    <tr> 
        <?php
        $x = 0;
        while ($x < 2) { 
            $D = 0;
            while ($D < 7) {
                
                if ($x == 0){ 
                    $dataVar = strval($mes[$aux1+$D].'-05');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';
                    }
                }else{ 
                    $dataVar = strval($mes[$aux2+$D].'-06');
                    if($mes[$aux2+$D] == 31){ 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;"></td>';
                    }
                    elseif(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux2+$D].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux2+$D].'</td>';
                    }
                }
                if($x == 0 and $D == 6){ 
                    $aux1 = $mes[$D + $aux1]; 
                }
                

                $D = $D + 1; 
            }
            if (in_array($idTexo, $id_do_textoBD)) {
                $key = array_search($idTexo, $id_do_textoBD);
                $texto = $texto_BD[$key];
                echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
            } else {
                echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
            }

            $idTexo = $idTexo + 1;
            $x = $x + 1;
        }
        
        ?>
    </tr>
    <!-- Linha 6 com datas --> 
    <tr> 
        <?php
        $x = 0;
        while ($x < 2) { 
            $D = 0;
            while ($D < 7) {
                if ($x == 0){ 
                    $dataVar = strval($mes[$aux1+$D].'-05');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';
                    }
                }else{ 
                    echo '<td style="text-align: center; vertical-align: middle; width: 20px; height: 20px; "></td>';
                }
                
                if($x == 0 and $D == 6){ 
                    $aux1 = $mes[$D + $aux1]; 
                }
                elseif($x ==1 and $D == 6 ){ 
                    $aux2 = $mes[$D + $aux2];
                }

                $D = $D + 1; 
        }
        echo '<form id="formulario" method="POST" action="salvar">';
        if (in_array($idTexo, $id_do_textoBD)) {
            $key = array_search($idTexo, $id_do_textoBD);
            $texto = $texto_BD[$key];
            echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
        } else {
            echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
        }
        echo '</form>';
        $idTexo = $idTexo + 1;
        $x = $x + 1;
        }
        
        ?>
    </tr>


    </tbody>
</table>
            <!--Inicio Julho e Agosto --> 
            <table border="1" cellpadding="1" cellspacing="1" height="213" style="margin-left:auto;margin-right:auto;" width="1000">

<tbody>
    <tr>
        <td colspan="7" rowspan="1" style="width: 140px; height: 25px; text-align: center; vertical-align: middle;"><strong>07 - JULHO 2023</strong></td>
        <td style="text-align: right; vertical-align: middle; width: 300px; height: 25px;"><strong>&nbsp; </strong></td>
        <td colspan="7" rowspan="1" style="width: 140px; height: 25px; text-align: center; vertical-align: middle;"><strong>08 - AGOSTO 2023</strong></td>
        <td style="text-align: right; vertical-align: middle; width: 300px; height: 25px;"><strong></strong></td>
    </tr>
    <!-- Dias da semana --> 
    <tr>
        <?php
                $x = 0;

                while ($x < 2) {
                    $D = 0;

                    while ($D < 7) {
                        echo '<td style="text-align: center; vertical-align: middle; width: 20px; height: 20px;"><strong>'.$DataSemana[$D].'</strong></td>';
                        $D = $D + 1;
                    }

                    if (in_array($idTexo, $id_do_textoBD)) {
                        $key = array_search($idTexo, $id_do_textoBD);
                        $texto = $texto_BD[$key];
                        echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
                    } else {
                        echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
                    }

                    $idTexo = $idTexo + 1;
                    $x = $x + 1;
                }
        ?>

    </tr> 
    <!-- Linha 1 com datas --> 
    <tr> 
        <?php
        $x = 0;
        while ($x < 2) { 
            $D = 0;
            while ($D < 7) {
                if($x == 1 and $D > 2){ 
                    $dataVar = strval($mes[$D-2].'-08'); 
                        if(in_array($dataVar , $datasArray)){
                            $posicaoCor = array_search($dataVar, $datasArray); 
                            echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D-2].'</td>';    
                            $posicaoCor = $posicaoCor + 1; 
                        }else{ 
                            echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D-2].'</td>';
                        }
                                                   
                $aux2 = $mes[$D-3]; 
                }else{ 
                    if($D == 7){
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D].'</td>';
                    }
                    else{
                        if($x == 0 and $D == 6 ){
                            echo'<td style="text-align: center; vertical-align: middle; width: 20px; height: 20px;">1<strong></strong></td>';

                        }else{
                        echo'<td style="text-align: center; vertical-align: middle; width: 20px; height: 20px;"><strong></strong></td>';
                        }
                    }    
                }

                $D = $D + 1; 
            }
            if (in_array($idTexo, $id_do_textoBD)) {
                $key = array_search($idTexo, $id_do_textoBD);
                $texto = $texto_BD[$key];
                echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
            } else {
                echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
            }

            $idTexo = $idTexo + 1;
            $x = $x + 1;
        }
        
        ?>
    </tr> 
    <!-- Linha 2 com datas --> 
    <tr> 
        <?php
        $x = 0;
        while ($x < 2) { 
            $D = 0;
            while ($D < 7) {
                if ($x == 0){ 
                    $dataVar = strval($mes[$D+1].'-07');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D+1].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D+1].'</td>';
                    }
                    
                }else{ 
                    $dataVar = strval($mes[$aux2+$D].'-08');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D+4].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D+4].'</td>';
                    }}
                if($x == 0 and $D == 6){ 
                    $aux1 = $mes[($D+1) + $aux1]; 
                }
                elseif($x ==1 and $D == 6 ){ 
                    $aux2 = $mes[($D+4) + $aux2];
                }

                $D = $D + 1; 
            }
            if (in_array($idTexo, $id_do_textoBD)) {
                $key = array_search($idTexo, $id_do_textoBD);
                $texto = $texto_BD[$key];
                echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
            } else {
                echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
            }

            $idTexo = $idTexo + 1;
            $x = $x + 1; 
        }
        
        ?>
    </tr>
    <!-- Linha 3 com datas --> 
    <tr> 
        <?php
        $x = 0;
        while ($x < 2) { 
            $D = 0;
            while ($D < 7) {
                if ($x == 0){ 
                    $dataVar = strval($mes[$aux1+$D].'-07');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';
                    }
                }else{ 
                    $dataVar = strval($mes[$aux2+$D].'-08');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux2+$D].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux2+$D].'</td>';
                    }
                }
                if($x == 0 and $D == 6){ 
                    $aux1 = $mes[$D + $aux1]; 
                }
                elseif($x ==1 and $D == 6 ){ 
                    $aux2 = $mes[$D + $aux2];
                }

                $D = $D + 1; 
            }
            if (in_array($idTexo, $id_do_textoBD)) {
                $key = array_search($idTexo, $id_do_textoBD);
                $texto = $texto_BD[$key];
                echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
            } else {
                echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
            }

            $idTexo = $idTexo + 1;
            $x = $x + 1; 
        }
        
        ?>
    </tr>  
    <!-- Linha 4 com datas --> 
    <tr> 
        <?php
        $x = 0;
        while ($x < 2) { 
            $D = 0;
            while ($D < 7) {
                if ($x == 0){ 
                    $dataVar = strval($mes[$aux1+$D].'-07');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';
                    }
                }else{ 
                    $dataVar = strval($mes[$aux2+$D].'-08');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux2+$D].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux2+$D].'</td>';
                    }
                }
                if($x == 0 and $D == 6){ 
                    $aux1 = $mes[$D + $aux1]; 
                }
                elseif($x ==1 and $D == 6 ){ 
                    $aux2 = $mes[$D + $aux2];
                }

                $D = $D + 1; 
            }
            if (in_array($idTexo, $id_do_textoBD)) {
                $key = array_search($idTexo, $id_do_textoBD);
                $texto = $texto_BD[$key];
                echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
            } else {
                echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
            }

            $idTexo = $idTexo + 1;
            $x = $x + 1;
        }
        
        ?>
    </tr>  
    <!-- Linha 5 com datas --> 
    <tr> 
        <?php
        $x = 0;
        while ($x < 2) { 
            $D = 0;
            while ($D < 7) {
                
                if ($x == 0){ 
                    $dataVar = strval($mes[$aux1+$D].'-07');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';
                    }
                }else{ 
                    $dataVar = strval($mes[$aux2+$D].'-08');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux2+$D].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux2+$D].'</td>';
                    }
                }
                if($x == 0 and $D == 6){ 
                    $aux1 = $mes[$D + $aux1]; 
                }
                

                $D = $D + 1; 
            }
            if (in_array($idTexo, $id_do_textoBD)) {
                $key = array_search($idTexo, $id_do_textoBD);
                $texto = $texto_BD[$key];
                echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
            } else {
                echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
            }

            $idTexo = $idTexo + 1;
            $x = $x + 1;
        }
        
        ?>
    </tr>
    <!-- Linha 6 com datas --> 
    <tr> 
        <?php
        $x = 0;
        while ($x < 2) { 
            $D = 0;
            while ($D < 7) {
                if ($x == 0){ 
                    $dataVar = strval($mes[$aux1+$D].'-07');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';
                    }
                }else{ 
                    echo '<td style="text-align: center; vertical-align: middle; width: 20px; height: 20px; "></td>';
                }
                
                if($x == 0 and $D == 6){ 
                    $aux1 = $mes[$D + $aux1]; 
                }
                elseif($x ==1 and $D == 6 ){ 
                    $aux2 = $mes[$D + $aux2];
                }

                $D = $D + 1; 
        }
        echo '<form id="formulario" method="POST" action="salvar">';
        if (in_array($idTexo, $id_do_textoBD)) {
            $key = array_search($idTexo, $id_do_textoBD);
            $texto = $texto_BD[$key];
            echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
        } else {
            echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
        }
        echo '</form>';
        $idTexo = $idTexo + 1;
        $x = $x + 1;
        }
        
        ?>
    </tr>
    </tbody>
</table>
            <!--Inicio Setembro e Outubro--> 
            <table border="1" cellpadding="1" cellspacing="1" height="213" style="margin-left:auto;margin-right:auto;" width="1000">

<tbody>
    <tr>
        <td colspan="7" rowspan="1" style="width: 140px; height: 25px; text-align: center; vertical-align: middle;"><strong>09 - SETEMBRO 2023</strong></td>
        <td style="text-align: right; vertical-align: middle; width: 300px; height: 25px;"><strong>&nbsp; </strong></td>
        <td colspan="7" rowspan="1" style="width: 140px; height: 25px; text-align: center; vertical-align: middle;"><strong>10 - OUTUBRO 2023</strong></td>
        <td style="text-align: right; vertical-align: middle; width: 300px; height: 25px;"><strong></strong></td>
    </tr>
    <!-- Dias da semana --> 
    <tr>
        <?php
                $x = 0;

                while ($x < 2) {
                    $D = 0;

                    while ($D < 7) {
                        echo '<td style="text-align: center; vertical-align: middle; width: 20px; height: 20px;"><strong>'.$DataSemana[$D].'</strong></td>';
                        $D = $D + 1;
                    }

                    if (in_array($idTexo, $id_do_textoBD)) {
                        $key = array_search($idTexo, $id_do_textoBD);
                        $texto = $texto_BD[$key];
                        echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
                    } else {
                        echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
                    }

                    $idTexo = $idTexo + 1;
                    $x = $x + 1;
                }
        ?>

    </tr> 
    <!-- Linha 1 com datas --> 
    <tr> 
        <?php
        $x = 0;
        while ($x < 2) { 
            $D = 0;
            while ($D < 7) {
                if($x == 1 and $D > 2){ 
                    $dataVar = strval($mes[$D-3].'-10'); 
                        if(in_array($dataVar , $datasArray)){
                            $posicaoCor = array_search($dataVar, $datasArray); 
                            echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D-3].'</td>';    
                            $posicaoCor = $posicaoCor + 1; 
                        }else{ 
                            echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D-3].'</td>';
                        }
                                                   
                $aux2 = $mes[$D-4]; 
                }else{ 
                    if($D == 7){
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D].'</td>';
                    }
                    else{
                        if($x == 0 and $D == 5 ){
                            $dataVar = ('1-09');
                            if(in_array($dataVar , $datasArray)){
                                $posicaoCor = array_search($dataVar, $datasArray); 
                                echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D-5].'</td>';    
                                $posicaoCor = $posicaoCor + 1; 
                            }else{ 
                                echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D-5].'</td>';
                            }
                        }
                        
                        elseif($x==0 and $D == 6 ){
                            $dataVar = ('2-09');
                            if(in_array($dataVar , $datasArray)){
                                $posicaoCor = array_search($dataVar, $datasArray); 
                                echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D-5].'</td>';    
                                $posicaoCor = $posicaoCor + 1; 
                            }else{ 
                                echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D-5].'</td>';
                            }
                        
                        }
                        else{
                        echo'<td style="text-align: center; vertical-align: middle; width: 20px; height: 20px;"><strong></strong></td>';
                        
                        }
                    }    
                }

                $D = $D + 1; 
            }
            if (in_array($idTexo, $id_do_textoBD)) {
                $key = array_search($idTexo, $id_do_textoBD);
                $texto = $texto_BD[$key];
                echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
            } else {
                echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
            }

            $idTexo = $idTexo + 1;
            $x = $x + 1;
        }
        
        ?>
    </tr> 
    <!-- Linha 2 com datas --> 
    <tr> 
        <?php
        $x = 0;
        while ($x < 2) { 
            $D = 0;
            while ($D < 7) {
                if ($x == 0){ 
                    $dataVar = strval($mes[$D+2].'-09');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D+2].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D+2].'</td>';
                    }
                    
                }else{ 
                    $dataVar = strval($mes[$aux2+$D].'-10');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D+4].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D+4].'</td>';
                    }}
                if($x == 0 and $D == 6){ 
                    $aux1 = $mes[($D+2) + $aux1]; 
                }
                elseif($x ==1 and $D == 6 ){ 
                    $aux2 = $mes[($D+4) + $aux2];
                }

                $D = $D + 1; 
            }
            if (in_array($idTexo, $id_do_textoBD)) {
                $key = array_search($idTexo, $id_do_textoBD);
                $texto = $texto_BD[$key];
                echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
            } else {
                echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
            }

            $idTexo = $idTexo + 1;
            $x = $x + 1; 
        }
        
        ?>
    </tr>
    <!-- Linha 3 com datas --> 
    <tr> 
        <?php
        $x = 0;
        while ($x < 2) { 
            $D = 0;
            while ($D < 7) {
                if ($x == 0){ 
                    $dataVar = strval($mes[$aux1+$D].'-09');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';
                    }
                }else{ 
                    $dataVar = strval($mes[$aux2+$D].'-10');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux2+$D].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux2+$D].'</td>';
                    }
                }
                if($x == 0 and $D == 6){ 
                    $aux1 = $mes[$D + $aux1]; 
                }
                elseif($x ==1 and $D == 6 ){ 
                    $aux2 = $mes[$D + $aux2];
                }

                $D = $D + 1; 
            }
            if (in_array($idTexo, $id_do_textoBD)) {
                $key = array_search($idTexo, $id_do_textoBD);
                $texto = $texto_BD[$key];
                echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
            } else {
                echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
            }

            $idTexo = $idTexo + 1;
            $x = $x + 1; 
        }
        
        ?>
    </tr>  
    <!-- Linha 4 com datas --> 
    <tr> 
        <?php
        $x = 0;
        while ($x < 2) { 
            $D = 0;
            while ($D < 7) {
                if ($x == 0){ 
                    $dataVar = strval($mes[$aux1+$D].'-09');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';
                    }
                }else{ 
                    $dataVar = strval($mes[$aux2+$D].'-10');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux2+$D].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux2+$D].'</td>';
                    }
                }
                if($x == 0 and $D == 6){ 
                    $aux1 = $mes[$D + $aux1]; 
                }
                elseif($x ==1 and $D == 6 ){ 
                    $aux2 = $mes[$D + $aux2];
                }

                $D = $D + 1; 
            }
            if (in_array($idTexo, $id_do_textoBD)) {
                $key = array_search($idTexo, $id_do_textoBD);
                $texto = $texto_BD[$key];
                echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
            } else {
                echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
            }

            $idTexo = $idTexo + 1;
            $x = $x + 1;
        }
        
        ?>
    </tr>  
    <!-- Linha 5 com datas --> 
    <tr> 
        <?php
        $x = 0;
        while ($x < 2) { 
            $D = 0;
            while ($D < 7) {
                
                if ($x == 0){ 
                    $dataVar = strval($mes[$aux1+$D].'-09');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';
                    }
                }else{ 
                    $dataVar = strval($mes[$aux2+$D].'-10');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux2+$D].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux2+$D].'</td>';
                    }
                }
                if($x == 0 and $D == 6){ 
                    $aux1 = $mes[$D + $aux1]; 
                }
                

                $D = $D + 1; 
            }
            if (in_array($idTexo, $id_do_textoBD)) {
                $key = array_search($idTexo, $id_do_textoBD);
                $texto = $texto_BD[$key];
                echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
            } else {
                echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
            }

            $idTexo = $idTexo + 1;
            $x = $x + 1;
        }
        
        ?>
    </tr>
    <!-- Linha 6 com datas --> 
    <tr> 
        <?php
        $x = 0;
        while ($x < 2) { 
            $D = 0;
            while ($D < 7) {
                if ($x == 0){ 
                    $dataVar = strval($mes[$aux1+$D].'-09');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td style="text-align: center; vertical-align: middle; width: 20px; height: 20px; "></td>';
                        
                    }
                    else{
                        echo '<td style="text-align: center; vertical-align: middle; width: 20px; height: 20px; "></td>';
                    }
                }else{ 
                    echo '<td style="text-align: center; vertical-align: middle; width: 20px; height: 20px; "></td>';
                }
                
                if($x == 0 and $D == 6){ 
                    $aux1 = $mes[$D + $aux1]; 
                }
                elseif($x ==1 and $D == 6 ){ 
                    $aux2 = $mes[$D + $aux2];
                }

                $D = $D + 1; 
        }
        echo '<form id="formulario" method="POST" action="salvar">';
        if (in_array($idTexo, $id_do_textoBD)) {
            $key = array_search($idTexo, $id_do_textoBD);
            $texto = $texto_BD[$key];
            echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
        } else {
            echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
        }
        echo '</form>';
        $idTexo = $idTexo + 1;
        $x = $x + 1;
        }
        
        ?>
    </tr>
    </tbody>
</table>

            <!--Inicio Novembro e Dezembro--> 
            <table border="1" cellpadding="1" cellspacing="1" height="213" style="margin-left:auto;margin-right:auto;" width="1000">

<tbody>
    <tr>
        <td colspan="7" rowspan="1" style="width: 140px; height: 25px; text-align: center; vertical-align: middle;"><strong>11 - NOVEMBRO 2023</strong></td>
        <td style="text-align: right; vertical-align: middle; width: 300px; height: 25px;"><strong>&nbsp; </strong></td>
        <td colspan="7" rowspan="1" style="width: 140px; height: 25px; text-align: center; vertical-align: middle;"><strong>12 - DEZEMBRO 2023</strong></td>
        <td style="text-align: right; vertical-align: middle; width: 300px; height: 25px;"><strong></strong></td>
    </tr>
    <!-- Dias da semana --> 
    <tr>
        <?php
                $x = 0;

                while ($x < 2) {
                    $D = 0;

                    while ($D < 7) {
                        echo '<td style="text-align: center; vertical-align: middle; width: 20px; height: 20px;"><strong>'.$DataSemana[$D].'</strong></td>';
                        $D = $D + 1;
                    }

                    if (in_array($idTexo, $id_do_textoBD)) {
                        $key = array_search($idTexo, $id_do_textoBD);
                        $texto = $texto_BD[$key];
                        echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
                    } else {
                        echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
                    }

                    $idTexo = $idTexo + 1;
                    $x = $x + 1;
                }
        ?>

    </tr> 
    <!-- Linha 1 com datas --> 
    <tr> 
        <?php
        $x = 0;
        while ($x < 2) { 
            $D = 0;
            while ($D < 7) {
                if($x == 1 and $D > 4){ 
                    $dataVar = strval($mes[$D-6].'-12'); 
                        if(in_array($dataVar , $datasArray)){
                            $posicaoCor = array_search($dataVar, $datasArray); 
                            echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D-5].'</td>';    
                            $posicaoCor = $posicaoCor + 1; 
                        }else{ 
                            echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D-5].'</td>';
                        }
                                                   
                $aux2 = $mes[$D-6]; 
                }else{ 
                    echo'<td style="text-align: center; vertical-align: middle; width: 20px; height: 20px;"><strong></strong></td>';
                }

                $D = $D + 1; 
            }
            if (in_array($idTexo, $id_do_textoBD)) {
                $key = array_search($idTexo, $id_do_textoBD);
                $texto = $texto_BD[$key];
                echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
            } else {
                echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
            }

            $idTexo = $idTexo + 1;
            $x = $x + 1;
        }
        
        ?>
    </tr> 
    <!-- Linha 2 com datas --> 
    <tr> 
        <?php
        $x = 0;
        while ($x < 2) { 
            $D = 0;
            while ($D < 7) {
                if ($x == 0){ 
                    $dataVar = strval($mes[$D-3].'-11');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D-3].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D-3].'</td>';
                    }
                    
                }else{ 
                    $dataVar = strval($mes[$aux2+$D].'-12');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D+1].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$D+1].'</td>';
                    }}
                if($x == 0 and $D == 6){ 
                    $aux1 = $mes[($D-3) + $aux1]; 
                }
                elseif($x ==1 and $D == 6 ){ 
                    $aux2 = $mes[$D + $aux2];
                }

                $D = $D + 1; 
            }
            if (in_array($idTexo, $id_do_textoBD)) {
                $key = array_search($idTexo, $id_do_textoBD);
                $texto = $texto_BD[$key];
                echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
            } else {
                echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
            }

            $idTexo = $idTexo + 1;
            $x = $x + 1; 
        }
        
        ?>
    </tr>
    <!-- Linha 3 com datas --> 
    <tr> 
        <?php
        $x = 0;
        while ($x < 2) { 
            $D = 0;
            while ($D < 7) {
                if ($x == 0){ 
                    $dataVar = strval($mes[$aux1+$D].'-11');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';
                    }
                }else{ 
                    $dataVar = strval($mes[$aux2+$D].'-12');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux2+$D].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux2+$D].'</td>';
                    }
                }
                if($x == 0 and $D == 6){ 
                    $aux1 = $mes[$D + $aux1]; 
                }
                elseif($x ==1 and $D == 6 ){ 
                    $aux2 = $mes[$D + $aux2];
                }

                $D = $D + 1; 
            }
            if (in_array($idTexo, $id_do_textoBD)) {
                $key = array_search($idTexo, $id_do_textoBD);
                $texto = $texto_BD[$key];
                echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
            } else {
                echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
            }

            $idTexo = $idTexo + 1;
            $x = $x + 1; 
        }
        
        ?>
    </tr>  
    <!-- Linha 4 com datas --> 
    <tr> 
        <?php
        $x = 0;
        while ($x < 2) { 
            $D = 0;
            while ($D < 7) {
                if ($x == 0){ 
                    $dataVar = strval($mes[$aux1+$D].'-11');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';
                    }
                }else{ 
                    $dataVar = strval($mes[$aux2+$D].'-12');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux2+$D].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux2+$D].'</td>';
                    }
                }
                if($x == 0 and $D == 6){ 
                    $aux1 = $mes[$D + $aux1]; 
                }
                elseif($x ==1 and $D == 6 ){ 
                    $aux2 = $mes[$D + $aux2];
                }

                $D = $D + 1; 
            }
            if (in_array($idTexo, $id_do_textoBD)) {
                $key = array_search($idTexo, $id_do_textoBD);
                $texto = $texto_BD[$key];
                echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
            } else {
                echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
            }

            $idTexo = $idTexo + 1;
            $x = $x + 1;
        }
        
        ?>
    </tr>  
    <!-- Linha 5 com datas --> 
    <tr> 
        <?php
        $x = 0;
        while ($x < 2) { 
            $D = 0;
            while ($D < 7) {
                
                if ($x == 0){ 
                    $dataVar = strval($mes[$aux1+$D].'-11');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';
                    }
                }else{ 
                    $dataVar = strval($mes[$aux2+$D].'-12');
                    if(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux2+$D].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux2+$D].'</td>';
                    }
                }
                if($x == 0 and $D == 6){ 
                    $aux1 = $mes[$D + $aux1]; 
                }
                

                $D = $D + 1; 
            }
            if (in_array($idTexo, $id_do_textoBD)) {
                $key = array_search($idTexo, $id_do_textoBD);
                $texto = $texto_BD[$key];
                echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
            } else {
                echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
            }

            $idTexo = $idTexo + 1;
            $x = $x + 1;
        }
        
        ?>
    </tr>
    <!-- Linha 6 com datas --> 
    <tr> 
        <?php
        $x = 0;
        while ($x < 2) { 
            $D = 0;
            while ($D < 7) {
           
                if ($x == 0){ 
                    $dataVar = strval($mes[$aux1+$D].'-11');
                    if($D == 5 ){
                        echo '<td style="text-align: center; vertical-align: middle; width: 20px; height: 20px; "></td>';
                    }
                    elseif(in_array($dataVar , $datasArray)){
                        $posicaoCor = array_search($dataVar, $datasArray); 
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color:'.$coresArray[$posicaoCor].'; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';    
                        
                    }
                    else{
                        echo '<td class = "date-cell" data-date="'.$dataVar.'" style="background-color: white; text-align: center; vertical-align: middle; width: 20px; height: 20px;">'.$mes[$aux1+$D].'</td>';
                    }
                }else{ 
                    echo '<td style="text-align: center; vertical-align: middle; width: 20px; height: 20px; "></td>';
                }
                
                if($x == 0 and $D == 6){ 
                    $aux1 = $mes[$D + $aux1]; 
                }
                elseif($x ==1 and $D == 6 ){ 
                    $aux2 = $mes[$D + $aux2];
                }

                $D = $D + 1; 
        }
        echo '<form id="formulario" method="POST" action="salvar">';
        if (in_array($idTexo, $id_do_textoBD)) {
            $key = array_search($idTexo, $id_do_textoBD);
            $texto = $texto_BD[$key];
            echo "<td><input type='text' name='texto' id='".$idTexo."' value='".$texto."' style='width: 300px;' class='texto-input'></td>";
        } else {
            echo "<td><input type='text' name='texto' id='".$idTexo."' style='width: 300px;' class='texto-input'></td>";
        }
        echo '</form>';
        $idTexo = $idTexo + 1;
        $x = $x + 1;
        }
        
        ?>
    </tr>


    </tbody>
</table>
    </div>

</body>
</html>