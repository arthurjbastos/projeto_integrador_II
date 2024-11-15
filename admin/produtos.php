<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['add_produto'])){

   $nome = $_POST['nome'];
   $nome = filter_var($nome, FILTER_SANITIZE_STRING);
   $preco = $_POST['preco'];
   $preco = filter_var($preco, FILTER_SANITIZE_STRING);
   $categoria = $_POST['categoria'];
   $categoria = filter_var($categoria, FILTER_SANITIZE_STRING);

   $imagem = $_FILES['imagem']['name'];
   $imagem = filter_var($imagem, FILTER_SANITIZE_STRING);
   $imagem_size = $_FILES['imagem']['size'];
   $imagem_tmp_name = $_FILES['imagem']['tmp_name'];
   $imagem_folder = '../uploaded_img/'.$imagem;

   $select_produtos = $conn->prepare("SELECT * FROM `produtos` WHERE nome = ?");
   $select_produtos->execute([$nome]);

   if($select_produtos->rowCount() > 0){
      $mensagem[] = 'O nome desse produto já está cadastrado!';
   }else{
      if($imagem_size > 2000000){
         $mensagem[] = 'A imagem é muito grande';
      }else{
         move_uploaded_file($imagem_tmp_name, $imagem_folder);

         $insert_produto = $conn->prepare("INSERT INTO `produtos`(nome, categoria, preco, imagem) VALUES(?,?,?,?)");
         $insert_produto->execute([$nome, $categoria, $preco, $imagem]);

         $mensagem[] = 'Produto adicionado com sucesso!';
      }

   }

}

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_produto_imagem = $conn->prepare("SELECT * FROM `produtos` WHERE id = ?");
   $delete_produto_imagem->execute([$delete_id]);
   $fetch_delete_imagem = $delete_produto_imagem->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_img/'.$fetch_delete_imagem['imagem']);
   $delete_produto = $conn->prepare("DELETE FROM `produtos` WHERE id = ?");
   $delete_produto->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `carrinho` WHERE pid = ?");
   $delete_cart->execute([$delete_id]);
   header('location:produtos.php');

}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>produtos</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="shortcut icon" href="../imagens/logo.jpg" type="image/x-icon">

</head>

<body>

    <?php include '../components/admin_header.php' ?>

    <section class="add-produtos">

        <form action="" method="POST" enctype="multipart/form-data">
            <h3>Adicionar produto</h3>
            <input type="text" required placeholder="Digite o nome do produto" name="nome" maxlength="100" class="box">
            <input type="number" min="0" step="0.010"  max="9999999999" required placeholder="Digite o preço do produto" name="preco"
                onkeypress="if(this.value.length == 10) return false;" class="box">
            <select name="categoria" class="box" required>
                <option value="" disabled selected>Selecione a categoria --</option>
                <option value="cafés">cafés</option>
                <option value="cappuccinos">cappucinos</option>
                <option value="doces">doces</option>
                <option value="salgados">salgados</option>
            </select>
            <input type="file" name="imagem" class="box" accept="image/*" required>
            <input type="submit" value="adicionar" name="add_produto" class="btn">
        </form>

    </section>



    <section class="show-produtos" style="padding-top: 0;">

        <div class="box-container">

            <?php
      $show_produtos = $conn->prepare("SELECT * FROM `produtos`");
      $show_produtos->execute();
      if($show_produtos->rowCount() > 0){
         while($fetch_produtos = $show_produtos->fetch(PDO::FETCH_ASSOC)){  
   ?>
            <div class="box">
                <img src="../uploaded_img/<?= $fetch_produtos['imagem']; ?>" alt="">
                <div class="flex">
                    <div class="preco"><span>R$</span><?= number_format($fetch_produtos['preco'],2,',',' '); ?><span></span></div>
                    <div class="categoria"><?= $fetch_produtos['categoria']; ?></div>
                </div>
                <div class="name"><?= $fetch_produtos['nome']; ?></div>
                <div class="flex-btn">
                    <a href="atualiza_produto.php?update=<?= $fetch_produtos['id']; ?>" class="option-btn">atualizar</a>
                    <a href="produtos.php?delete=<?= $fetch_produtos['id']; ?>" class="delete-btn"
                        onclick="return confirm('deseja deletar este produto?');">deletar</a>
                </div>
            </div>
            <?php
         }
      }else{
         echo '<p class="empty">Nenhum produto adicionado ainda!</p>';
      }
   ?>

        </div>

    </section>


    <script src="../js/admin_script.js"></script>

</body>

</html>