<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['submit'])){

   $nome = $_POST['nome'];
   $nome = filter_var($nome, FILTER_SANITIZE_STRING);

   if(!empty($nome)){
      $select_nome = $conn->prepare("SELECT * FROM `admin` WHERE nome = ?");
      $select_nome->execute([$nome]);
      if($select_nome->rowCount() > 0){
         $msg[] = 'Usuário já cadastrado!';
      }else{
         $atualiza_nome = $conn->prepare("UPDATE `admin` SET nome = ? WHERE id = ?");
         $atualiza_nome->execute([$nome, $admin_id]);
      }
   }

   $empty_senha = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $select_velha_senha = $conn->prepare("SELECT senha FROM `admin` WHERE id = ?");
   $select_velha_senha->execute([$admin_id]);
   $fetch_prev_senha = $select_velha_senha->fetch(PDO::FETCH_ASSOC);
   $prev_senha = $fetch_prev_senha['senha'];
   $velha_senha = sha1($_POST['velha_senha']);
   $velha_senha = filter_var($velha_senha, FILTER_SANITIZE_STRING);
   $nova_senha = sha1($_POST['nova_senha']);
   $nona_senha = filter_var($nova_senha, FILTER_SANITIZE_STRING);
   $confirma_senha = sha1($_POST['confirma_senha']);
   $confirma_senha = filter_var($confirma_senha, FILTER_SANITIZE_STRING);

   if($velha_senha != $empty_senha){
      if($velha_senha != $prev_senha){
         $msg[] = 'Senha antiga incorreta!';
      }elseif($nova_senha != $confirma_senha){
         $msg[] = 'As novas senha não conferem!';
      }else{
         if($nova_senha != $empty_senha){
            $atualiza_senha = $conn->prepare("UPDATE `admin` SET senha = ? WHERE id = ?");
            $atualiza_senha->execute([$confirma_senha, $admin_id]);
            $msg[] = 'Senha atualizada com sucesso!';
         }else{
            $msg[] = 'Digite a nova senha!';
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
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="shortcut icon" href="../imagens/logo.jpg" type="image/x-icon">

</head>

<body>

    <?php include '../components/admin_header.php' ?>



    <section class="form-container">

        <form action="" method="POST">
            <h3>Atualizar perfil</h3>
            <input type="text" name="nome" maxlength="20" class="box"
                oninput="this.value = this.value.replace(/\s/g, '')" placeholder="<?= $fetch_profile['nome']; ?>">
            <input type="password" name="velha_senha" maxlength="20" placeholder="Digite a senha antiga" class="box"
                oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="nova_senha" maxlength="20" placeholder="Digite a nova senha" class="box"
                oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="confirma_senha" maxlength="20" placeholder="Confirme a senha" class="box"
                oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" value="Atualizar" name="submit" class="btn">
        </form>

    </section>

    <script src="../js/admin_script.js"></script>

</body>

</html>