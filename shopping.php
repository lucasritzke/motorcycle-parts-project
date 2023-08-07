<!DOCTYPE html>
<html lang="pt-br">
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
        </ul>
      </nav>
    </header>
  </section>
  <main>
    <section>
      <h2>Selecione um item para comprar:</h2>
      <form action="service.php" method="get" onsubmit="return openNewWindow()">
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
    <section id="sobre-nos">
      <h2>Sobre Nós</h2>
      <p>Nós oferecemos uma grande variedade de peças e acessórios para motocicletas, sempre com a melhor qualidade.</p>
      <p>Telefone: (11) 1234-5678</p>
      <p>Endereço: Rua Fictícia, 123 - Cidade Fictícia</p>
    </section>
  </main>

  <script>
    function openNewWindow() {
      const selectedItem = document.getElementById("item").value;
      
      if (selectedItem === "") {
        alert("Selecione um item antes de continuar.");
        return false;
      }
      header('Content-Disposition: none');
      window.open(`service.php?item=${encodeURIComponent(selectedItem)}`, "_blank");
    }
  </script>
</body>
</html>
