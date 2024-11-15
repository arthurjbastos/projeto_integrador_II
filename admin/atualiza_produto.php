<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['update'])){

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $nome = $_POST['nome'];
   $nome = filter_var($nome, FILTER_SANITIZE_STRING);
   $preco = $_POST['preco'];
   $preco = filter_var($preco, FILTER_SANITIZE_STRING);
   $categoria = $_POST['categoria'];
   $categoria = filter_var($categoria, FILTER_SANITIZE_STRING);

   $update_produto = $conn->prepare("UPDATE `produtos` SET nome = ?, categoria = ?, preco = ? WHERE id = ?");
   $update_produto->execute([$nome, $categoria, $preco, $pid]);

   $mensagem[] = 'produto atualizado!';

   $velha_imagem = $_POST['velha_imagem'];
   $imagem = $_FILES['imagem']['name']; 
   $imagem = filter_var($imagem, FILTER_SANITIZE_STRING);
   $imagem_size = $_FILES['imagem']['size'];
   $imagem_tmp_name = $_FILES['imagem']['tmp_name'];
   $imagem_folder = '../uploaded_img/'.$imagem;

   if(!empty($imagem)){
      if($imagem_size > 2000000){
         $mensagem[] = 'A imagem é muito grande!';
      }else{
         $atualiza_imagem = $conn->prepare("UPDATE `produtos` SET imagem = ? WHERE id = ?");
         $atualiza_imagem->execute([$imagem, $pid]);
         move_uploaded_file($imagem_tmp_name, $imagem_folder);
         unlink('../uploaded_img/'.$velha_imagem);
         $mensagem[] = 'Imagem atualizada!';
      }
   }

}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar produto</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="shortcut icon" href="../imagens/logo.jpg" type="image/x-icon">

</head>

<body>

    <?php include '../components/admin_header.php' ?>


    <section class="update-produto">

        <h1 class="heading">Atualizar produto</h1>

        <?php
      $update_id = $_GET['update'];
      $show_produtos = $conn->prepare("SELECT * FROM `produtos` WHERE id = ?");
      $show_produtos->execute([$update_id]);
      if($show_produtos->rowCount() > 0){
         while($fetch_produtos = $show_produtos->fetch(PDO::FETCH_ASSOC)){  
   ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="pid" value="<?= $fetch_produtos['id']; ?>">
            <input type="hidden" name="velha_imagem" value="<?= $fetch_produtos['imagem']; ?>">
            <img src="../uploaded_img/<?= $fetch_produtos['imagem']; ?>" alt="">
            <span>Atualizar nome</span>
            <input type="text" required placeholder="Digite o nome do produto" name="nome" maxlength="100" class="box"
                value="<?= $fetch_produtos['nome']; ?>">
            <span>Atualizar preço</span>
            <input type="number" min="0" max="9999999999" required placeholder="Digite o preço do produto" name="preco"
                onkeypress="if(this.value.length == 10) return false;" class="box"
                value="<?= $fetch_produtos['preco']; ?>">
            <span>Atualizar categoria</span>
            <select name="categoria" class="box" required>
                <option selected value="<?= $fetch_produtos['categoria']; ?>"><?= $fetch_produtos['categoria']; ?>
                </option>
                <option value="cafés">cafés</option>
                <option value="cappuccinos">cappuccinos</option>
                <option value="doces">doces</option>
                <option value="salgados">salgados</option>
            </select>
            <span>Atualizar imagem</span>
            <input type="file" name="imagem" class="box" accept="image/*">
            <div class="flex-btn">
                <input type="submit" value="atualizar" class="btn" name="update">
                <a href="produtos.php" class="option-btn">Voltar</a>
            </div>
        </form>
        <?php
         }
      }else{
         echo '<p class="empty">Nenhum produto adicionado ainda!</p>';
      }
   ?>

    </section>

    <script src="../js/admin_script.js"></script>

</body>

</html>