<?php
$clickedDate = $_POST['clickedDate'];
$selectedColor = $_POST['selectedColor'];
$textValues = $_POST['textValues'];
$host = 'localhost';
$usuario = 'root';
$senha = 'root';
$bancoDeDados = 'calendario';

$conexao = new mysqli($host, $usuario, $senha, $bancoDeDados);

// Verifica se houve algum erro na conexão
if ($conexao->connect_error) {
    die('Erro na conexão com o banco de dados: ' . $conexao->connect_error);
}

// Atualiza ou insere os valores no banco de dados
foreach ($clickedDate as $index => $date) {
    $color = $selectedColor[$index];
    $id = intval(str_replace("-", "", $date));

    // Verificar se o par de data e cor já existe no banco de dados
    $query = "SELECT data, cor FROM datascores WHERE data = '$date'";
    $result = $conexao->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $existingColor = $row['cor'];

        if ($existingColor !== $color) {
            // A cor é diferente, então atualize a entrada no banco de dados
            $sql = "UPDATE datascores SET cor = '$color' WHERE data = '$date'";
            $conexao->query($sql);
        }
    } else {
        // O par de data e cor não existe no banco de dados, então insira uma nova entrada
        $sql = "INSERT INTO datascores (id, data, cor) VALUES ('$id', '$date', '$color')";
        $conexao->query($sql);
    }
}

// Salva os valores dos campos de texto no banco de dados
foreach ($textValues as $inputId => $inputText) {
    // Atualiza ou insere os valores dos campos de texto no banco de dados
    $inputId = $conexao->real_escape_string($inputId);
    $inputText = $conexao->real_escape_string($inputText);
    $sql = "INSERT INTO textocalendario (id, texto) VALUES ('$inputId', '$inputText')
            ON DUPLICATE KEY UPDATE texto = '$inputText'";
    $conexao->query($sql);
}

// Fecha a conexão com o banco de dados
$conexao->close();
$response = array(
    'mensagem' => 'Valores recebidos e salvos com sucesso!',
    'textValues' => $textValues
);

// Defina o cabeçalho para retornar JSON
header('Content-Type: application/json');

// Converte o array para JSON e imprime na saída
echo json_encode($response);
?>
