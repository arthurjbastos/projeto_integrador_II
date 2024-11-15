<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['atualiza_pagamento'])){

   $id_pedido = $_POST['id_pedido'];
   $status_pagamento = $_POST['status_pagamento'];
   $atualiza_status = $conn->prepare("UPDATE `pedidos` SET status_pagamento = ? WHERE id = ?");
   $atualiza_status->execute([$status_pagamento, $id_pedido]);
   $mensagem[] = 'Status de pagamento atualizado';

}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_pedido = $conn->prepare("DELETE FROM `pedidos` WHERE id = ?");
   $delete_pedido->execute([$delete_id]);
   header('location:pedidos.php');
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">>
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="shortcut icon" href="../imagens/logo.jpg" type="image/x-icon">

</head>

<body>

    <?php include '../components/admin_header.php' ?>


    <section class="pedidos-feitos">

        <h1 class="heading">Pedidos</h1>

        <div class="box-container">

            <?php
      $select_pedidos = $conn->prepare("SELECT * FROM `pedidos`");
      $select_pedidos->execute();
      if($select_pedidos->rowCount() > 0){
         while($fetch_pedidos = $select_pedidos->fetch(PDO::FETCH_ASSOC)){
   ?>
            <div class="box">
                <p> id do usuário : <span><?= $fetch_pedidos['id_usuario']; ?></span> </p>
                <p> realizado em : <span><?= date('d/m/Y', strtotime($fetch_pedidos['data_pedido'])); ?></span> </p>
                <p> nome : <span><?= $fetch_pedidos['nome']; ?></span> </p>
                <p> e-mail : <span><?= $fetch_pedidos['email']; ?></span> </p>
                <p> telefone : <span><?= $fetch_pedidos['telefone']; ?></span> </p>
                <p> endereço : <span><?= $fetch_pedidos['endereco']; ?></span> </p>
                <p> total de produtos : <span><?= str_replace('.',',',$fetch_pedidos['qtd_produtos']); ?></span> </p>
                <p> valor total : <span>R$ <?= str_replace('.',',',$fetch_pedidos['valor_total']); ?></span> </p>
                <p> metodo de pagamentpo : <span><?= $fetch_pedidos['metodo']; ?></span> </p>
                <form action="" method="POST">
                    <input type="hidden" name="id_pedido" value="<?= $fetch_pedidos['id']; ?>">
                    <select name="status_pagamento" class="drop-down">
                        <option value="" selected disabled><?= $fetch_pedidos['status_pagamento']; ?></option>
                        <option value="pendente">pendente</option>
                        <option value="finalizado">finalizado</option>
                    </select>
                    <div class="flex-btn">
                        <input type="submit" value="atualizar" class="btn" name="atualiza_pagamento">
                        <a href="pedidos.php?delete=<?= $fetch_pedidos['id']; ?>" class="delete-btn"
                            onclick="return confirm('deseja deletar este pedido?');">deletar</a>
                    </div>
                </form>
            </div>
            <?php
      }
   }else{
      echo '<p class="empty">Nenhum pedido realizado ainda!</p>';
   }
   ?>

        </div>

    </section>


    <script src="../js/admin_script.js"></script>

</body>

</html>