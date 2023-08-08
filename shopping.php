<!DOCTYPE html>
<html lang="pt-br">
<center>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Loja de Peças de Motos</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
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
    <section id="select-item-section">
      <h2>Selecione um item para comprar:</h2>
      <form action="" method="get" onsubmit="return openNewWindow()">
        <label for="item">Itens disponíveis:</label>
        <select name="item" id="item">
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

            $sql = "SELECT name_piece FROM parts WHERE amount > 0;";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['name_piece'] . "'>" . $row['name_piece'] . "</option>";
              }
            } else {
              echo "<option value=''>Nenhum item disponível</option>";
            }

            $conn->close();
          ?>
        </select>
        <button type="submit">Comprar</button>
      </form>
    </section>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['action']) && $_GET['action'] === "details") {
      $servername = "localhost";
      $port = "3306";
      $username = "lritzke";
      $password = "lritzke";
      $database = "BikeShop";

      $conn = new mysqli($servername, $username, $password, $database, $port);

      if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
      }

      if (isset($_GET['item'])) {
        $selectedItem = $_GET['item'];
        $sql = "SELECT name_piece, price, amount FROM parts WHERE name_piece = '$selectedItem'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          echo "<section id='item-details-section'>";
          echo "<h2>Detalhes da Peça</h2>";
          echo "<p>Nome da Peça: " . $row['name_piece'] . "</p>";
          echo "<p>Preço: R$ " . $row['price'] . "</p>";
          echo "<p>Quantidade em Estoque: " . $row['amount'] . "</p>";
          echo "<form action='' method='post'>";
          echo "<input type='hidden' name='item' value='" . $row['name_piece'] . "'>";
          echo "<label for='quantity'>Quantidade (até 3):</label>";
          echo "<select name='quantity' id='quantity'>";
          for ($i = 1; $i <= min(3, $row['amount']); $i++) {
            echo "<option value='$i'>$i</option>";
          }
          echo "</select>";
          echo "<button type='submit'>Comprar</button>";
          echo "</form>";
          echo "</section>";
        } else {
          echo "<section id='item-details-section'>";
          echo "<h2>Detalhes da Peça</h2>";
          echo "<p>Peça não encontrada.</p>";
          echo "</section>";
        }
      } else {
        echo "<section id='item-details-section'>";
        echo "<h2>Detalhes da Peça</h2>";
        echo "<p>Nenhuma peça selecionada.</p>";
        echo "</section>";
      }

      $conn->close();
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $servername = "localhost";
      $port = "3306";
      $username = "lritzke";
      $password = "lritzke";
      $database = "BikeShop";

      $conn = new mysqli($servername, $username, $password, $database, $port);

      if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
      }

      if (isset($_POST['item']) && isset($_POST['quantity'])) {
        $selectedItem = $_POST['item'];
        $quantity = $_POST['quantity'];

        $sql = "SELECT amount FROM parts WHERE name_piece = '$selectedItem'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          $currentAmount = $row['amount'];

          if ($currentAmount >= $quantity) {
            $newAmount = $currentAmount - $quantity;
            $sql = "UPDATE parts SET amount = $newAmount WHERE name_piece = '$selectedItem'";
            if ($conn->query($sql) === TRUE) {
              echo "<section id='purchase-details-section'>";
              echo "<h2>Compra realizada com sucesso!</h2>";
              echo "<p>Você comprou $quantity unidades de $selectedItem.</p>";
              echo "<button onclick='showSelectItemSection()'>Comprar novamente</button>";
              echo "</section>";
            } else {
              echo "<section id='purchase-details-section'>";
              echo "<h2>Erro ao atualizar o estoque</h2>";
              echo "<p>" . $conn->error . "</p>";
              echo "<button onclick='showSelectItemSection()'>Tentar novamente</button>";
              echo "</section>";
            }
          } else {
            echo "<section id='purchase-details-section'>";
            echo "<h2>Quantidade em estoque insuficiente</h2>";
            echo "<p>Infelizmente, só temos $currentAmount unidades de $selectedItem em estoque.</p>";
            echo "<button onclick='showSelectItemSection()'>Tentar novamente</button>";
            echo "</section>";
          }
        } else {
          echo "<section id='purchase-details-section'>";
          echo "<h2>Peça não encontrada</h2>";
          echo "<p>A peça selecionada não foi encontrada no estoque.</p>";
          echo "<button onclick='showSelectItemSection()'>Tentar novamente</button>";
          echo "</section>";
        }
      } else {
        echo "<section id='purchase-details-section'>";
        echo "<h2>Erro na compra</h2>";
        echo "<p>Algo deu errado na compra, por favor, tente novamente.</p>";
        echo "<button onclick='showSelectItemSection()'>Tentar novamente</button>";
        echo "</section>";
      }

      $conn->close();
    }
    ?>
  </main>

  <script>
    function openNewWindow() {
      const selectedItem = document.getElementById("item").value;
      
      if (selectedItem === "") {
        alert("Selecione um item antes de continuar.");
        return false;
      }
      window.open(`shopping.php?action=details&item=${encodeURIComponent(selectedItem)}`, "_blank");
      return false;
    }

    function showSelectItemSection() {
      document.getElementById("select-item-section").style.display = "block";
      document.getElementById("item-details-section").style.display = "none";
      document.getElementById("purchase-details-section").style.display = "none";
    }
  </script>

</body>
</center>
</html>


