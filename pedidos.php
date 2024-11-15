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
   <title>Pedidos</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   <link rel="shortcut icon" href="imagens/logo.jpg" type="image/x-icon">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<div class="heading">
   <h3>pedidos</h3>
   <p><a href="index.php">home</a> <span> / pedidos</span></p>
</div>

<section class="pedidos">

   <h1 class="title">seus pedidos</h1>

   <div class="box-container">

   <?php
      if($id_usuario == ''){
         echo '<p class="empty">faça login para ver seus pedidos</p>';
      }else{
         $select_pedidos = $conn->prepare("SELECT * FROM `pedidos` WHERE id_usuario = ?");
         $select_pedidos->execute([$id_usuario]);
         if($select_pedidos->rowCount() > 0){
            while($fetch_pedidos = $select_pedidos->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p>pedido realizado em : <span><?= date('d/m/Y', strtotime($fetch_pedidos['data_pedido'])); ?></span></p>
      <p>nome : <span><?= $fetch_pedidos['nome']; ?></span></p>
      <p>email : <span><?= $fetch_pedidos['email']; ?></span></p>
      <p>telefone : <span><?= $fetch_pedidos['telefone']; ?></span></p>
      <p>endereço : <span><?= $fetch_pedidos['endereco']; ?></span></p>
      <p>metodo de pagamento : <span><?= $fetch_pedidos['metodo']; ?></span></p>
      <p>seus pedidos : <span><?= str_replace('.',',',$fetch_pedidos['qtd_produtos']); ?></span></p>
      <p>valor total : <span>R$<?= str_replace('.',',',number_format($fetch_pedidos['valor_total'],2,',',' ')); ?></span></p>
      <p>status de pagamentos : <span style="color:<?php if($fetch_pedidos['status_pagamento'] == 'pendente'){ echo 'red'; }else{ echo 'green'; }; ?>"><?= $fetch_pedidos['status_pagamento']; ?></span> </p>
   </div>
   <?php
      }
      }else{
         echo '<p class="empty">nenhum pedido realizado ainda!</p>';
      }
      }
   ?>

   </div>

</section>


<?php include 'components/footer.php'; ?>
<script src="js/script.js"></script>

</body>
</html>