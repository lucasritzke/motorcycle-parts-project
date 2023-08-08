<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Loja de Peças de Motos</title>
  <link rel="stylesheet" href="style.css">
</head>
<center>
<body>
<div id="background-paragraph"></div> <!-- Parágrafo para a imagem de fundo com contraste -->
  <section id="menu">
    <header>
      <h1>Loja de Peças de Motos</h1>
      <nav>
        <ul>
          <li><a href="/">Home</a></li>
          <li><a href="shopping.php">Shopping</a></li>
          <li><a href="registro.html">Registro</a></li>
	  <li><a href="stock.php">Stock</a></li>
          <li><a href="add_part.php">Add part</a></li>
        </ul>
      </nav>
    </header>
  </section>
  <main>
    <section>
      <h2>Informações das Peças:</h2>
      <table>
        <tr>
          <th>ID</th>
          <th>Nome da Peça</th>
          <th>Preço</th>
          <th>Quantidade</th>
          <th>Ação</th>
        </tr>
      </table>
    </section>
    <section>
      <h2>Adicionar Nova Peça:</h2>
      <form action="" method="post">
        <label for="partName">Nome da Peça:</label>
        <input type="text" id="partName" name="partName" required><br>

        <label for="partPrice">Preço:</label>
        <input type="text" id="partPrice" name="partPrice" required><br>

        <label for="partAmount">Quantidade:</label>
        <input type="text" id="partAmount" name="partAmount" required><br>

        <button type="submit">Adicionar Peça</button>
      </form>
      <?php
      $servername = "localhost";
      $port = "3306";
      $username = "lritzke";
      $password = "lritzke";
      $database = "BikeShop";

      if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $conn = new mysqli($servername, $username, $password, $database, $port);

        if ($conn->connect_error) {
          die("Falha na conexão: " . $conn->connect_error);
        }

        $partName = $_POST["partName"];
        $partPrice = $_POST["partPrice"];
        $partAmount = $_POST["partAmount"];

        $sql = "INSERT INTO parts (name_piece, price, amount) VALUES ('$partName', '$partPrice', '$partAmount')";

        if ($conn->query($sql) === TRUE) {
          echo "Peça adicionada com sucesso!";
        } else {
          echo "Erro ao adicionar peça: " . $conn->error;
        }

        $conn->close();
      }
      ?>
    </section>
  </main>
</body>
</center>
</html>
