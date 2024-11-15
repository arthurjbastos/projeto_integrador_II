<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['submit'])){

   $nome = $_POST['nome'];
   $nome = filter_var($nome, FILTER_SANITIZE_STRING);
   $senha = sha1($_POST['senha']);
   $senha = filter_var($senha, FILTER_SANITIZE_STRING);
   $csenha = sha1($_POST['csenha']);
   $csenha = filter_var($csenha, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE nome = ?");
   $select_admin->execute([$nome]);
   
   if($select_admin->rowCount() > 0){
      $mensagem[] = 'Usuário já cadastrado!';
   }else{
      if($senha != $csenha){
         $mensagem[] = 'A senha e a confimação da senha precisam serem iguais!';
      }else{
         $insert_admin = $conn->prepare("INSERT INTO `admin`(nome, senha) VALUES(?,?)");
         $insert_admin->execute([$nome, $csenha]);
         $mensagem[] = 'Novo Admin cadastrado!';
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
    <title>Cadastro de admin</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="shortcut icon" href="../imagens/logo.jpg" type="image/x-icon">

</head>

<body>

    <?php include '../components/admin_header.php' ?>

    <section class="form-container">

        <form action="" method="POST">
            <h3>Cadastrar novo Admin</h3>
            <input type="text" name="nome" maxlength="20" required placeholder="Digite o nome de usuário" class="box"
                oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="senha" maxlength="20" required placeholder="Digite a senha" class="box"
                oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="csenha" maxlength="20" required placeholder="Confirme a senha" class="box"
                oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" value="Cadastrar" name="submit" class="btn">
        </form>

    </section>

    <script src="../js/admin_script.js"></script>

</body>

</html>