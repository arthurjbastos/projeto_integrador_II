<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['id_usuario'])){
   $id_usuario = $_SESSION['id_usuario'];
}else{
   $id_usuario = '';
   header('location:index.php');
};

if(isset($_POST['delete'])){
   $carrinho_id = $_POST['carrinho_id'];
   $delete_carrinho_item = $conn->prepare("DELETE FROM `carrinho` WHERE id = ?");
   $delete_carrinho_item->execute([$carrinho_id]);
   $mensagem[] = 'item do carrinho deletado!';
}

if(isset($_POST['delete_tudo'])){
   $delete_carrinho_item = $conn->prepare("DELETE FROM `carrinho` WHERE id_usuario = ?");
   $delete_carrinho_item->execute([$id_usuario]);
   // header('location:carrinho.php');
   $mensagem[] = 'Todo o carrinho deletado!';
}

if(isset($_POST['atualiza_quantidade'])){
   $carrinho_id = $_POST['carrinho_id'];
   $quantidade = $_POST['quantidade'];
   $quantidade = filter_var($quantidade, FILTER_SANITIZE_STRING);
   $atualiza_quantidade = $conn->prepare("UPDATE `carrinho` SET quantidade = ? WHERE id = ?");
   $atualiza_quantidade->execute([$quantidade, $carrinho_id]);
   $mensagem[] = 'Quantidade atualizado';
}

$valor_total = 0;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>carrinho</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   <link rel="shortcut icon" href="imagens/logo.jpg" type="image/x-icon">

</head>
<body>
   

<?php include 'components/user_header.php'; ?>

<div class="heading">
   <h3>carrinho</h3>
   <p><a href="index.php">home</a> <span> / carrinho</span></p>
</div>



<section class="produtos">

   <h1 class="title">Seu carrinho</h1>

   <div class="box-container">

      <?php
         $valor_total = 0;
         $select_carrinho = $conn->prepare("SELECT * FROM `carrinho` WHERE id_usuario = ?");
         $select_carrinho->execute([$id_usuario]);
         if($select_carrinho->rowCount() > 0){
            while($fetch_carrinho = $select_carrinho->fetch(PDO::FETCH_ASSOC)){
      ?>
      <form action="" method="post" class="box">
         <input type="hidden" name="carrinho_id" value="<?= $fetch_carrinho['id']; ?>">
         <a href="visualizar.php?pid=<?= $fetch_carrinho['pid']; ?>" class="fas fa-eye"></a>
         <button type="submit" class="fas fa-times" name="delete" onclick="return confirm('deletar este item?');"></button>
         <img src="uploaded_img/<?= $fetch_carrinho['imagem']; ?>" alt="">
         <div class="name"><?= $fetch_carrinho['nome']; ?></div>
         <div class="flex">
            <div class="preco"><span>R$</span><?= str_replace('.',',',$fetch_carrinho['preco']); ?></div>
            <input type="number" name="quantidade" class="quantidade" min="1" max="99" value="<?= $fetch_carrinho['quantidade']; ?>" maxlength="2">
            <button type="submit" class="fas fa-edit" name="atualiza_quantidade"></button>
         </div>
         <div class="sub-total"> sub total : <span>R$<?= str_replace('.',',',$sub_total = ($fetch_carrinho['preco'] * $fetch_carrinho['quantidade'])); ?></span> </div>
      </form>
      <?php
               $valor_total += $sub_total;
            }
         }else{
            echo '<p class="empty">Seu carrinho está vazio</p>';
         }
      ?>

   </div>

   <div class="total_carrinho">
      <p>total do carrinho : <span>R$<?= str_replace('.',',',$valor_total); ?></span></p>
      <a href="checkout.php" class="btn <?= ($valor_total > 1)?'':'disabled'; ?>">ir para o checkout</a>
   </div>

   <div class="more-btn">
      <form action="" method="post">
         <button type="submit" class="delete-btn <?= ($valor_total > 1)?'':'disabled'; ?>" name="delete_tudo" onclick="return confirm('deseja deletar tudo?');">deletar tudo</button>
      </form>
      <a href="menu.php" class="btn">continue comprando</a>
   </div>

</section>


<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>