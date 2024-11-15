<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_usuarios = $conn->prepare("DELETE FROM `usuarios` WHERE id = ?");
   $delete_usuarios->execute([$delete_id]);
   $delete_pedido = $conn->prepare("DELETE FROM `pedidos` WHERE id_usuario = ?");
   $delete_pedido->execute([$delete_id]);
   $delete_carrinho = $conn->prepare("DELETE FROM `carrinho` WHERE id_usuario = ?");
   $delete_carrinho->execute([$delete_id]);
   header('location:contas_usuarios.php');
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contas de Usuário</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="shortcut icon" href="../imagens/logo.jpg" type="image/x-icon">

</head>

<body>

    <?php include '../components/admin_header.php' ?>

    <section class="contas">

        <h1 class="heading">Contas de Usuário</h1>

        <div class="box-container">

            <?php
      $select_conta = $conn->prepare("SELECT * FROM `usuarios`");
      $select_conta->execute();
      if($select_conta->rowCount() > 0){
         while($fetch_contas = $select_conta->fetch(PDO::FETCH_ASSOC)){  
   ?>
            <div class="box">
                <p> ID do Usuário : <span><?= $fetch_contas['id']; ?></span> </p>
                <p> Nome de Login : <span><?= $fetch_contas['nome']; ?></span> </p>
                <a href="contas_usuarios.php?delete=<?= $fetch_contas['id']; ?>" class="delete-btn"
                    onclick="return confirm('Deseja deletar está conta?');">deletar</a>
            </div>
            <?php
      }
   }else{
      echo '<p class="empty">Nenhuma conta cadastrada</p>';
   }
   ?>

        </div>

    </section>

    <script src="../js/admin_script.js"></script>

</body>

</html>