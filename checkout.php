<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['id_usuario'])){
   $id_usuario = $_SESSION['id_usuario'];
}else{
   $id_usuario = '';
   header('location:index.php');
};

if(isset($_POST['submit'])){

   $nome = $_POST['nome'];
   $nome = filter_var($nome, FILTER_SANITIZE_STRING);
   $telefone = $_POST['telefone'];
   $telefone = filter_var($telefone, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $metodo = $_POST['metodo'];
   $metodo = filter_var($metodo, FILTER_SANITIZE_STRING);
   $endereco = $_POST['endereco'];
   $endereco = filter_var($endereco, FILTER_SANITIZE_STRING);
   $qtd_produtos = $_POST['qtd_produtos'];
   $valor_total = $_POST['valor_total'];

   $check_carrinho = $conn->prepare("SELECT * FROM `carrinho` WHERE id_usuario = ?");
   $check_carrinho->execute([$id_usuario]);

   if($check_carrinho->rowCount() > 0){

      if($endereco == ''){
         $mensagem[] = 'Digite seu endereço!';
      }else{
         
         $insert_order = $conn->prepare("INSERT INTO `pedidos`(id_usuario, nome, telefone, email, metodo, endereco, qtd_produtos, valor_total) VALUES(?,?,?,?,?,?,?,?)");
         $insert_order->execute([$id_usuario, $nome, $telefone, $email, $metodo, $endereco, $qtd_produtos, $valor_total]);

         $delete_carrinho = $conn->prepare("DELETE FROM `carrinho` WHERE id_usuario = ?");
         $delete_carrinho->execute([$id_usuario]);

         $mensagem[] = 'Pedido realizado com sucesso!';
      }
      
   }else{
      $mensagem[] = 'Seu carrinho está vazio';
   }

}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>checkout</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="imagens/logo.jpg" type="image/x-icon">

</head>

<body>


    <?php include 'components/user_header.php'; ?>


    <div class="heading">
        <h3>checkout</h3>
        <p><a href="index.php">home</a> <span> / checkout</span></p>
    </div>

    <section class="checkout">

        <h1 class="title">Sumario do pedido</h1>

        <form action="" method="post">

            <div class="carrinho-items">
                <h3>itens do carrinho</h3>
                <?php
         $valor_total = 0;
         $carrinho_items[] = '';
         $select_carrinho = $conn->prepare("SELECT * FROM `carrinho` WHERE id_usuario = ?");
         $select_carrinho->execute([$id_usuario]);
         if($select_carrinho->rowCount() > 0){
            while($fetch_carrinho = $select_carrinho->fetch(PDO::FETCH_ASSOC)){
               $carrinho_items[] = $fetch_carrinho['nome'].' ('.$fetch_carrinho['preco'].' x '. $fetch_carrinho['quantidade'].') - ';
               $qtd_produtos = implode($carrinho_items);
               $valor_total += ($fetch_carrinho['preco'] * $fetch_carrinho['quantidade']);
      ?>
                <p><span class="nome"><?= $fetch_carrinho['nome']; ?></span><span
                        class="preco">R$<?= str_replace('.',',',$fetch_carrinho['preco']); ?> x <?= $fetch_carrinho['quantidade']; ?></span>
                </p>
                <?php
            }
         }else{
            echo '<p class="empty">Seu carrinho está vazio!</p>';
         }
      ?>
                <p class="valor-total"><span class="nome">valor total :</span><span
                        class="preco">R$<?= str_replace('.',',',$valor_total); ?></span></p>
                <a href="carrinho.php" class="btn">ver carrinho</a>
            </div>

            <input type="hidden" name="qtd_produtos" value="<?= $qtd_produtos; ?>">
            <input type="hidden" name="valor_total" value="<?= $valor_total; ?>" value="">
            <input type="hidden" name="nome" value="<?= $fetch_profile['nome'] ?>">
            <input type="hidden" name="telefone" value="<?= $fetch_profile['telefone'] ?>">
            <input type="hidden" name="email" value="<?= $fetch_profile['email'] ?>">
            <input type="hidden" name="endereco" value="<?= $fetch_profile['endereco'] ?>">

            <div class="user-info">
                <h3>Suas informações</h3>
                <p><i class="fas fa-user"></i><span><?= $fetch_profile['nome'] ?></span></p>
                <p><i class="fas fa-phone"></i><span><?= $fetch_profile['telefone'] ?></span></p>
                <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['email'] ?></span></p>
                <a href="atualiza_perfil.php" class="btn">atualizar informações</a>
                <h3>endereço para entrega</h3>
                <p><i
                        class="fas fa-map-marker-alt"></i><span><?php if($fetch_profile['endereco'] == ''){echo 'digite seu endereco';}else{echo $fetch_profile['endereco'];} ?></span>
                </p>
                <a href="atualiza_endereco.php" class="btn">atualizar endereço</a>
                <select name="metodo" class="box" required>
                    <option value="" disabled selected>selecione o metodo de pagamento--</option>
                    <option value="dinheiro">dinheiro</option>
                    <option value="cartao de credito">cartão de credito</option>
                    <option value="pix">pix</option>
                </select>
                <input type="submit" value="fazer pedido"
                    class="btn <?php if($fetch_profile['endereco'] == ''){echo 'disabled';} ?>"
                    style="width:100%; background:var(--red); color:var(--white);" name="submit">
            </div>

        </form>

    </section>


    <?php include 'components/footer.php'; ?>

    <script src="js/script.js"></script>

</body>

</html>