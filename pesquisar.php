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
    <title>pesquisa</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="imagens/logo.jpg" type="image/x-icon">

</head>

<body>

    <?php include 'components/user_header.php'; ?>


    <section class="pesquisa-form">
        <form method="post" action="">
            <input type="text" name="search_box" placeholder="digite para pesquisar..." class="box">
            <button type="submit" name="search_btn" class="fas fa-search"></button>
        </form>
    </section>


    <section class="produtos" style="min-height: 100vh; padding-top:0;">

        <div class="box-container">

            <?php
         if(isset($_POST['search_box']) OR isset($_POST['search_btn'])){
         $search_box = $_POST['search_box'];
         $select_produtos = $conn->prepare("SELECT * FROM `produtos` WHERE nome LIKE '%{$search_box}%'");
         $select_produtos->execute();
         if($select_produtos->rowCount() > 0){
            while($fetch_produtos = $select_produtos->fetch(PDO::FETCH_ASSOC)){
      ?>
            <form action="" method="post" class="box">
                <input type="hidden" name="pid" value="<?= $fetch_produtos['id']; ?>">
                <input type="hidden" name="nome" value="<?= $fetch_produtos['nome']; ?>">
                <input type="hidden" name="preco" value="<?= $fetch_produtos['preco']; ?>">
                <input type="hidden" name="imagem" value="<?= $fetch_produtos['imagem']; ?>">
                <a href="visualizar.php?pid=<?= $fetch_produtos['id']; ?>" class="fas fa-eye"></a>
                <button type="submit" class="fas fa-shopping-cart" name="add_no_carrinho"></button>
                <img src="uploaded_img/<?= $fetch_produtos['imagem']; ?>" alt="">
                <a href="categoria.php?categoria=<?= $fetch_produtos['categoria']; ?>"
                    class="cat"><?= $fetch_produtos['categoria']; ?></a>
                <div class="nome"><?= $fetch_produtos['nome']; ?></div>
                <div class="flex">
                    <div class="preco"><span>R$</span><?= $fetch_produtos['preco']; ?></div>
                    <input type="number" name="quantidade" class="quantidade" min="1" max="99" value="1" maxlength="2">
                </div>
            </form>
            <?php
            }
         }else{
            echo '<p class="empty">nenhum produto adicionado ainda!</p>';
         }
      }
      ?>

        </div>

    </section>


    <?php include 'components/footer.php'; ?>

    <script src="js/script.js"></script>

</body>

</html>