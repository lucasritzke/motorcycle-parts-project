<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $id = $_POST["id"];
  $newName = $_POST["newName"];
  $newPrice = $_POST["newPrice"];
  $newAmount = $_POST["newAmount"];

  $servername = "localhost";
  $port = "3306";
  $username = "lritzke";
  $password = "lritzke";
  $database = "BikeShop";

  $conn = new mysqli($servername, $username, $password, $database, $port);

  if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
  }

  $sql = "UPDATE parts SET name_piece=?, price=?, amount=? WHERE id_part=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssi", $newName, $newPrice, $newAmount, $id);

  if ($stmt->execute()) {
    echo "Atualização realizada com sucesso!";
  } else {
    echo "Erro na atualização: " . $stmt->error;
  }

  $stmt->close();
  $conn->close();
}
?>

