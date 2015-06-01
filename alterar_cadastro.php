<?php
  extract($_REQUEST);
  session_start();
  if (isset($_SESSION["login"]) == false) {
      header("Location: index.php");
      return;
  }
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <link rel="stylesheet" type="text/css" href="tema.css">
  </head>
  <body>
    <nav id="navigation" class="clearfix">
      <ul>
        <li><a href="index.php"   >Home    </a></li>
        <li><a href="listar.php"  >Listar  </a></li>
        <li><a href="busca.php"   >Buscar  </a></li>
        <li><a href="carrinho.php">Carrinho</a></li>
      </ul>
    </nav>
    <div align="right">
        <a href="alterar_cadastro.php"><?= $_SESSION["login"]. ","?></a>
        <a href="logout.php"> sair</a>
    </div>
    <?php
      require 'conexao.php';

      $id_cliente = $_SESSION["id_cliente"];
      $sql_preenche_formulario  = "SELECT * 
                                   FROM clientes
                                   WHERE id_cliente = {$id_cliente}";
      
      $cliente = mysqli_fetch_assoc(mysqli_query($conexao,
                                                 $sql_preenche_formulario));
    ?>

    <form accept-charset="utf-8" method=POST action="alterar_cadastro.php">
      <b>Nome:     <br><input type="text"     name="nome"  value="<?= $cliente["nome"]  ?>"><p>
         E-mail:   <br><input type="text"     name="email" value="<?= $cliente["email"] ?>"><p>
         Login:    <br><input type="text"     name="login" value="<?= $_SESSION["login"]?>"><p>
         Senha:</b><br><input type="password" name="senha" value=""                        ><p>
                       <input type="submit"   value="Alterar">
    </form>
    
    <?php
      header('Content-type: text/html; charset=UTF-8');
      extract($_POST, EXTR_PREFIX_ALL);

      $nome  =     $_POST["nome"];
      $email =     $_POST["email"];
      $login =     $_POST["login"];
      $senha = md5($_POST["senha"]);

      if (isset($nome) || isset($email) || isset($login) || isset($senha)) {
        if ($conexao) {
          $sql_altera  = "UPDATE clientes
                          SET nome='{$nome}',
                              email='{$email}',
                              login='{$login}',
                              senha='{$senha}'
                          WHERE id_cliente = {$id_cliente}";
        }
        else {
          exit("<p>Falha na conexão: " . mysqli_connect_error());
        }

        if (mysqli_query($conexao, $sql_altera)) {
          echo "Registro alterado com sucesso!";
        }
        else {
          echo "Erro ao alterar registro: " . mysqli_error($conexao);
        }
      }
      mysqli_close($conexao);
    ?>
  </body>
</html>