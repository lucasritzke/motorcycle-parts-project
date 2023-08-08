<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Loja de Peças de Motos</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<center>
  <div id="background-paragraph"></div>
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
        <?php
        $servername = "localhost"; 
        $port = "3306"; 
        $username = "lritzke";
        $password = "lritzke";
        $database = "BikeShop";

        $conn = new mysqli($servername, $username, $password, $database, $port);

        if ($conn->connect_error) {
          die("Falha na conexão: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM parts;";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row["id_part"] . "</td>";
          echo "<td><input type='text' id='name_$row[id_part]' value='$row[name_piece]'></td>";
          echo "<td><input type='text' id='price_$row[id_part]' value='$row[price]'></td>";
          echo "<td><input type='text' id='amount_$row[id_part]' value='$row[amount]'></td>";
          echo "<td><button onclick='updatePart($row[id_part])'>Editar</button></td>";
          echo "</tr>";
        }
        $conn->close();
        ?>
      </table>
    </section>
  </main>

  <script>
    function updatePart(id) {
      const newName = document.getElementById(`name_${id}`).value;
      const newPrice = document.getElementById(`price_${id}`).value;
      const newAmount = document.getElementById(`amount_${id}`).value;

      $.ajax({
        type: "POST",
        url: "update_handler.php",
        data: { id: id, newName: newName, newPrice: newPrice, newAmount: newAmount },
        success: function(response) {
          console.log(response); 
        }
      });
    }
  </script>
</body>
</center>
</html>
