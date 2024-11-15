<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_mensagem = $conn->prepare("DELETE FROM `mensagens` WHERE id = ?");
   $delete_mensagem->execute([$delete_id]);
   header('location:mensagens.php');
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensagens</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="shortcut icon" href="../imagens/logo.jpg" type="image/x-icon">

</head>

<body>

    <?php include '../components/admin_header.php' ?>

    <section class="mensagens">

        <h1 class="heading">Mensagens</h1>

        <div class="box-container">

            <?php
      $select_mensagens = $conn->prepare("SELECT * FROM `mensagens`");
      $select_mensagens->execute();
      if($select_mensagens->rowCount() > 0){
         while($fetch_mensagens = $select_mensagens->fetch(PDO::FETCH_ASSOC)){
   ?>
            <div class="box">
                <p> Nome : <span><?= $fetch_mensagens['nome']; ?></span> </p>
                <p> Telefone : <span><?= $fetch_mensagens['telefone']; ?></span> </p>
                <p> E-mail : <span><?= $fetch_mensagens['email']; ?></span> </p>
                <p> Mensagem : <span><?= $fetch_mensagens['mensagem']; ?></span> </p>
                <a href="mensagens.php?delete=<?= $fetch_mensagens['id']; ?>" class="delete-btn"
                    onclick="return confirm('deseja deletar esta mensagem?');">deletar</a>
            </div>
            <?php
         }
      }else{
         echo '<p class="empty">Você não tem nenhuma mensagem</p>';
      }
   ?>

        </div>

    </section>

    <script src="../js/admin_script.js"></script>

</body>

</html>