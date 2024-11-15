<?php
if(isset($mensagem)){
   foreach($mensagem as $mensagem){
      echo '
      <div class="mensagem">
         <span>'.$mensagem.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <section class="flex">

      <a href="index.php" class="logo"><img src="..\imagens\logo.png" width="80" height="80" alt=""></a>
      <a href="index.php" class="logo">Painel<span class="border-text">Administrativo</span></a>

      <nav class="navbar">
         <a href="index.php">home</a>
         <a href="produtos.php">Produtos</a>
         <a href="pedidos.php">Pedidos</a>
         <a href="contas_admins.php">Admins</a>
         <a href="contas_usuarios.php">Usuários</a>
         <a href="mensagens.php">Mensagens</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `admin` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p><?= $fetch_profile['nome']; ?></p>
         <a href="atualiza_perfil.php" class="btn">Atualizar perfil</a>
         <div class="flex-btn">
            <a href="admin_login.php" class="option-btn">login</a>
            <a href="cadastro_admin.php" class="option-btn">cadastrar</a>
         </div>
         <a href="../components/admin_logout.php" onclick="return confirm('Deseja sair?');" class="delete-btn">sair</a>
      </div>

   </section>

</header>