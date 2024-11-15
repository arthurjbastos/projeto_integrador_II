<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DASHBOARD</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="shortcut icon" href="../imagens/logo.jpg" type="image/x-icon">

</head>

<body>

    <?php include '../components/admin_header.php' ?>


    <section class="dashboard">

        <h1 class="heading">dashboard</h1>

        <div class="box-container">

            <div class="box">
                <h3>Bem vindo!</h3>
                <p><?= $fetch_profile['nome']; ?></p>
                <a href="atualiza_perfil.php" class="btn">Atualizar perfil</a>
            </div>

            <div class="box">
                <?php
         $total_pendentes = 0;
         $select_pendentes = $conn->prepare("SELECT * FROM `pedidos` WHERE status_pagamento = ?");
         $select_pendentes->execute(['pendente']);
         while($fetch_pendentes = $select_pendentes->fetch(PDO::FETCH_ASSOC)){
            $total_pendentes += $fetch_pendentes['valor_total'];
         }
      ?>
                <h3><span>R$</span><?= $total_pendentes; ?><span></span></h3>
                <p>total pendentes</p>
                <a href="pedidos.php" class="btn">Ver pedidos</a>
            </div>

            <div class="box">
                <?php
         $total_finalizados = 0;
         $select_finalizados = $conn->prepare("SELECT * FROM `pedidos` WHERE status_pagamento = ?");
         $select_finalizados->execute(['finalizados']);
         while($fetch_finalizados = $select_finalizados->fetch(PDO::FETCH_ASSOC)){
            $total_finalzados += $fetch_finalizados['valor_total'];
         }
      ?>
                <h3><span>R$</span><?= $total_finalizados; ?><span></span></h3>
                <p>total finalizados</p>
                <a href="pedidos.php" class="btn">Ver pedidos</a>
            </div>

            <div class="box">
                <?php
         $select_pedidos = $conn->prepare("SELECT * FROM `pedidos`");
         $select_pedidos->execute();
         $quantidade_pedidos = $select_pedidos->rowCount();
      ?>
                <h3><?= $quantidade_pedidos; ?></h3>
                <p>total de pedidos</p>
                <a href="pedidos.php" class="btn">Ver pedidos</a>
            </div>

            <div class="box">
                <?php
         $select_produtos = $conn->prepare("SELECT * FROM `produtos`");
         $select_produtos->execute();
         $quantidade_produtos = $select_produtos->rowCount();
      ?>
                <h3><?= $quantidade_produtos; ?></h3>
                <p>produtos adicionados</p>
                <a href="produtos.php" class="btn">Ver produtos</a>
            </div>

            <div class="box">
                <?php
         $select_usuarios = $conn->prepare("SELECT * FROM `usuarios`");
         $select_usuarios->execute();
         $quantidade_usuarios = $select_usuarios->rowCount();
      ?>
                <h3><?= $quantidade_usuarios; ?></h3>
                <p>contas de usuários</p>
                <a href="contas_usuarios.php" class="btn">ver todos usuarios</a>
            </div>

            <div class="box">
                <?php
         $select_admins = $conn->prepare("SELECT * FROM `admin`");
         $select_admins->execute();
         $quantidade_admins = $select_admins->rowCount();
      ?>
                <h3><?= $quantidade_admins; ?></h3>
                <p>admins</p>
                <a href="contas_admins.php" class="btn">ver todos admins</a>
            </div>

            <div class="box">
                <?php
         $select_mensagens = $conn->prepare("SELECT * FROM `mensagens`");
         $select_mensagens->execute();
         $quantidade_mensagens = $select_mensagens->rowCount();
      ?>
                <h3><?= $quantidade_mensagens; ?></h3>
                <p>novas mensagens</p>
                <a href="mensagens.php" class="btn">ver mensagens</a>
            </div>

        </div>

    </section>



    <?php include '../components/creditos.php' ?>

    <script src="../js/admin_script.js"></script>

</body>

</html>