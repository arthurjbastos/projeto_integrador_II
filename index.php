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
   <title>Marchiatto</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   <link rel="shortcut icon" href="imagens/logo.jpg" type="image/x-icon">

</head>
<body>

<?php include 'components/user_header.php'; ?>



<section class="principal">

   <div class="swiper principal-slider">

      <div class="swiper-wrapper">

         <div class="swiper-slide slide">
            <div class="conteudo">
               <span>Pedido On-line</span>
               <h3>A cada xícara,<br> uma Ideia!</h3>
               <a href="menu.php" class="btn">Ver Menu</a>
            </div>
            <div class="imagem">
               <img src="imagens/foto-site2.jpg" alt="">
            </div>
         </div>

         <div class="swiper-slide slide">
            <div class="conteudo">
               <span>Pedido On-line</span>
               <h3>Que tal um Cappuccino?</h3>
               <a href="menu.php" class="btn">Ver Menu</a>
            </div>
            <div class="imagem">
               <img src="imagens/foto-site6.jpg" alt="">
            </div>
         </div>

         <div class="swiper-slide slide">
            <div class="conteudo">
               <span>Pedido On-line</span>
               <h3>Para combinar com <br>o seu dia!</h3>
               <a href="menu.php" class="btn">Ver Menu</a>
            </div>
            <div class="imagem">
               <img src="imagens/foto-site4.jpg" alt="">
            </div>
         </div>

      </div>

      <div class="swiper-pagination"></div>

   </div>

</section>

<section class="categoria">

   <h1 class="title">Categorias</h1>

   <div class="box-container">

      <a href="categoria.php?categoria=cafes" class="box">
         <img src="imagens/cat-1.png" alt="">
         <h3>Cafés</h3>
      </a>

      <a href="categoria.php?categoria=cappuccinos" class="box">
         <img src="imagens/cat-2.png" alt="">
         <h3>Capuccinos</h3>
      </a>

      <a href="categoria.php?categoria=doces" class="box">
         <img src="imagens/cat-3.png" alt="">
         <h3>Doces</h3>
      </a>

      <a href="categoria.php?categoria=salgados" class="box">
         <img src="imagens/cat-4.png" alt="">
         <h3>Salgados</h3>
      </a>

   </div>

</section>




<section class="produtos">

   <h1 class="title">Nossos produtos</h1>

   <div class="box-container">

      <?php
         $select_produtos = $conn->prepare("SELECT * FROM `produtos` LIMIT 6");
         $select_produtos->execute();
         if($select_produtos->rowCount() > 0){
            while($fetch_produtos = $select_produtos->fetch(PDO::FETCH_ASSOC)){
      ?>
      <form action="" method="post" class="box">
         <input type="hidden" name="pid" value="<?= $fetch_produtos['id']; ?>">
         <input type="hidden" name="nome" value="<?= $fetch_produtos['nome']; ?>">
         <input type="hidden" name="preco" value="<?= $fetch_produtos['preco']; ?>">
         <input type="hidden" name="imagem" value="<?= $fetch_produtos['imagem']; ?>">
         <a href="visualizart.php?pid=<?= $fetch_produtos['id']; ?>" class="fas fa-eye"></a>
         <button type="submit" class="fas fa-shopping-cart" name="add_no_carrinho"></button>
         <img src="uploaded_img/<?= $fetch_produtos['imagem']; ?>" alt="">
         <a href="categoria.php?categoria=<?= $fetch_produtos['categoria']; ?>" class="cat"><?= $fetch_produtos['categoria']; ?></a>
         <div class="nome"><?= $fetch_produtos['nome']; ?></div>
         <div class="flex">
            <div class="preco"><span>R$</span><?= number_format($fetch_produtos['preco'],2,',',' '); ?></div>
            <input type="number" name="quantidade" class="quantidade" min="1" max="99" value="1" maxlength="2">
         </div>
      </form>
      <?php
            }
         }else{
            echo '<p class="empty">Nehum produto adicionado ainda!</p>';
         }
      ?>

   </div>

   <div class="more-btn">
      <a href="menu.php" class="btn">Veja mais</a>
   </div>

</section>



<?php include 'components/footer.php'; ?>



<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".principal-slider", {
   loop:true,
   grabCursor: true,
   effect: "flip",
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
});

</script>

</body>
</html>