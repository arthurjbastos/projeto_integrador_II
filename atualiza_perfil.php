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

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $telefone = $_POST['telefone'];
   $telefone = filter_var($telefone, FILTER_SANITIZE_STRING);

   if(!empty($nome)){
      $update_nome = $conn->prepare("UPDATE `usuarios` SET nome = ? WHERE id = ?");
      $update_nome->execute([$nome, $id_usuario]);
   }

   if(!empty($email)){
      $select_email = $conn->prepare("SELECT * FROM `usuarios` WHERE email = ?");
      $select_email->execute([$email]);
      if($select_email->rowCount() > 0){
         $mensagem[] = 'email já cadastrado!';
      }else{
         $update_email = $conn->prepare("UPDATE `usuarios` SET email = ? WHERE id = ?");
         $update_email->execute([$email, $id_usuario]);
      }
   }

   if(!empty($telefone)){
      $select_telefone = $conn->prepare("SELECT * FROM `usuarios` WHERE telefone = ?");
      $select_telefone->execute([$telefone]);
      if($select_telefone->rowCount() > 0){
         $mensagem[] = 'telefone já cadastrado!';
      }else{
         $update_telefone = $conn->prepare("UPDATE `usuarios` SET telefone = ? WHERE id = ?");
         $update_telefone->execute([$telefone, $id_usuario]);
      }
   }
   
   $empty_senha = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $select_prev_senha = $conn->prepare("SELECT senha FROM `usuarios` WHERE id = ?");
   $select_prev_senha->execute([$id_usuario]);
   $fetch_prev_senha = $select_prev_senha->fetch(PDO::FETCH_ASSOC);
   $prev_senha = $fetch_prev_senha['senha'];
   $velha_senha = sha1($_POST['velha_senha']);
   $velha_senha = filter_var($velha_senha, FILTER_SANITIZE_STRING);
   $nova_senha = sha1($_POST['nova_senha']);
   $nova_senha = filter_var($nova_senha, FILTER_SANITIZE_STRING);
   $confirma_senha = sha1($_POST['confirma_senha']);
   $confirma_senha = filter_var($confirma_senha, FILTER_SANITIZE_STRING);

   if($old_senha != $empty_senha){
      if($velha_senha != $prev_senha){
         $mensagem[] = 'senha antiga !';
      }elseif($nova_senha != $confirm_senha){
         $mensagem[] = 'confirme a senha!';
      }else{
         if($new_senha != $empty_senha){
            $update_senha = $conn->prepare("UPDATE `usuarios` SET senha = ? WHERE id = ?");
            $update_senha->execute([$confirma_senha, $id_usuario]);
            $mensagem[] = 'senha alterada com sucesso!';
         }else{
            $mensagem[] = 'digite a nova senha!';
         }
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
   <title>Atualizar perfil</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   <link rel="shortcut icon" href="imagens/logo.jpg" type="image/x-icon">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="form-container update-form">

   <form action="" method="post">
      <h3>Atualizar perfil</h3>
      <input type="text" name="nome" placeholder="<?= $fetch_profile['nome']; ?>" class="box" maxlength="50">
      <input type="email" name="email" placeholder="<?= $fetch_profile['email']; ?>" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="number" name="telefone" placeholder="<?= $fetch_profile['telefone']; ?>"" class="box" min="0" max="9999999999" maxlength="10">
      <input type="password" name="velha_senha" placeholder="digite sua senha antiga" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="nova_senha" placeholder="digite sua senha" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="confirma_senha" placeholder="confirme sua senha" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="atualizar" name="submit" class="btn">
   </form>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>