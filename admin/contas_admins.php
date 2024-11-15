<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_admin = $conn->prepare("DELETE FROM `admin` WHERE id = ?");
   $delete_admin->execute([$delete_id]);
   header('location:contas_admins.php');
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conta de administradores</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="shortcut icon" href="../imagens/logo.jpg" type="image/x-icon">

</head>

<body>

    <?php include '../components/admin_header.php' ?>

    <section class="contas">

        <h1 class="heading">Conta de administradores</h1>

        <div class="box-container">

            <div class="box">
                <p>Cadastrar novo admin</p>
                <a href="cadastro_admin.php" class="option-btn">cadastrar</a>
            </div>

    <?php
      $select_conta = $conn->prepare("SELECT * FROM `admin`");
      $select_conta->execute();
      if($select_conta->rowCount() > 0){
         while($fetch_contas = $select_conta->fetch(PDO::FETCH_ASSOC)){  
   ?>
            <div class="box">
                <p> ID do admin : <span><?= $fetch_contas['id']; ?></span> </p>
                <p> Nome de usuário : <span><?= $fetch_contas['nome']; ?></span> </p>
                <div class="flex-btn">
                    <a href="contas_admins.php?delete=<?= $fetch_contas['id']; ?>" class="delete-btn"
                        onclick="return confirm('deseja deletar esta conta?');">deletar</a>
                    <?php
            if($fetch_contas['id'] == $admin_id){
               echo '<a href="atualiza_perfil.php" class="option-btn">Atualizar</a>';
            }
         ?>
                </div>
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