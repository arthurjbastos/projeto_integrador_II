<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <section class="flex">

   <a href="index.php" class="logo"><img src="imagens\logo.png" width="80" height="80" alt=""></a>

      <nav class="navbar">
         <a href="index.php">home</a>
         <a href="sobre.php">sobre</a>
         <a href="menu.php">menu</a>
         <a href="pedidos.php">pedidos</a>
         <a href="contato.php">contato</a>
      </nav>

      <div class="icons">
         <?php
            $count_carrinho_items = $conn->prepare("SELECT * FROM `carrinho` WHERE id_usuario = ?");
            $count_carrinho_items->execute([$id_usuario]);
            $total_carrinho_items = $count_carrinho_items->rowCount();
         ?>
         <a href="pesquisar.php"><i class="fas fa-search"></i></a>
         <a href="carrinho.php"><i class="fas fa-shopping-cart"></i><span>(<?= $total_carrinho_items; ?>)</span></a>
         <div id="user-btn" class="fas fa-user"></div>
         <div id="menu-btn" class="fas fa-bars"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `usuarios` WHERE id = ?");
            $select_profile->execute([$id_usuario]);
            if($select_profile->rowCount() > 0){
               $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p class="nome"><?= $fetch_profile['nome']; ?></p>
         <div class="flex">
            <a href="perfil.php" class="btn">perfil</a>
            <a href="components/user_logout.php" onclick="return confirm('Deseja sair?');" class="delete-btn">sair</a>
         </div>
         <p class="account">
            <a href="login.php">login</a> ou
            <a href="register.php">cadastrar</a>
         </p> 
         <?php
            }else{
         ?>
            <p class="nome">Faça o login primeiro!</p>
            <a href="login.php" class="btn">login</a>
         <?php
          }
         ?>
      </div>

   </section>

</header>

