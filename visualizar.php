<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['id_usuario'])){
   $id_usuario = $_SESSION['id_usuario'];
}else{
   $id_usuario = '';
};

include 'components/add_carrinho.php';

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>visualizar</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   <link rel="shortcut icon" href="imagens/logo.jpg" type="image/x-icon">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="visualizar">

   <h1 class="title">visualizar</h1>

   <?php
      $pid = $_GET['pid'];
      $select_produtos = $conn->prepare("SELECT * FROM `produtos` WHERE id = ?");
      $select_produtos->execute([$pid]);
      if($select_produtos->rowCount() > 0){
         while($fetch_produtos = $select_produtos->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="pid" value="<?= $fetch_produtos['id']; ?>">
      <input type="hidden" name="nome" value="<?= $fetch_produtos['nome']; ?>">
      <input type="hidden" name="preco" value="<?= $fetch_produtos['preco']; ?>">
      <input type="hidden" name="imagem" value="<?= $fetch_produtos['imagem']; ?>">
      <img src="uploaded_img/<?= $fetch_produtos['imagem']; ?>" alt="">
      <a href="categoria.php?categoria=<?= $fetch_produtos['categoria']; ?>" class="cat"><?= $fetch_produtos['categoria']; ?></a>
      <div class="nome"><?= $fetch_produtos['nome']; ?></div>
      <div class="flex">
         <div class="preco"><span>R$</span><?= $fetch_produtos['preco']; ?></div>
         <input type="number" name="quantidade" class="quantidade" min="1" max="99" value="1" maxlength="2">
      </div>
      <button type="submit" name="add_no_carrinho" class="carrinho-btn">adicionar no carrinho</button>
   </form>
   <?php
         }
      }else{
         echo '<p class="empty">nehum produto adicionado ainda!</p>';
      }
   ?>

</section>



<?php include 'components/footer.php'; ?>


<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>


</body>
</html>