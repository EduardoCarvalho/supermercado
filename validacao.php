<?php
    extract($_REQUEST);
    session_start();

    require 'conexao.php';

    if ($conexao) {
        $sql_verifica_usuario  = "SELECT * FROM clientes 
                                  WHERE login='{$login}' 
                                  AND senha='{$senha}'";
    }
    else {
        exit("Falha na conexão: " . mysqli_connect_error());
    }

    $resultado = mysqli_query($conexao, $sql_verifica_usuario);
    $linha = mysqli_num_rows($resultado);

    if ($linha == 1) {
        header("Location: listar.php");
        $_SESSION["login"]      = $login;
        $_SESSION["id_cliente"] = mysqli_fetch_assoc($resultado)["id_cliente"];
    }
    else {
        header("Location: index.php");
    }

    mysqli_close($conexao);
?>