<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['id_usuario'])){
   $id_usuario = $_SESSION['id_usuario'];
}else{
   $id_usuario = '';
   header('location:index.php');
};

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>perfil</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   <link rel="shortcut icon" href="imagens/logo.jpg" type="image/x-icon">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="detalhe-user">

   <div class="user">
      <?php
         
      ?>
      <img src="imagens/user-icon.png" alt="">
      <p><i class="fas fa-user"></i><span><span><?= $fetch_profile['nome']; ?></span></span></p>
      <p><i class="fas fa-phone"></i><span><?= $fetch_profile['telefone']; ?></span></p>
      <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['email']; ?></span></p>
      <a href="atualiza_perfil.php" class="btn">atualizar informações</a>
      <p class="endereco"><i class="fas fa-map-marker-alt"></i><span><?php if($fetch_profile['endereco'] == ''){echo 'digite seu endereço';}else{echo $fetch_profile['endereco'];} ?></span></p>
      <a href="atualiza_endereco.php" class="btn">atualizar endereço</a>
   </div>

</section>


<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>