<?php

include '../components/connect.php';

session_start();

if(isset($_POST['submit'])){

   $nome = $_POST['nome'];
   $nome = filter_var($nome, FILTER_SANITIZE_STRING);
   $senha = sha1($_POST['senha']);
   $senha = filter_var($senha, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE nome = ? AND senha = ?");
   $select_admin->execute([$nome, $senha]);
   
   if($select_admin->rowCount() > 0){
      $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
      $_SESSION['admin_id'] = $fetch_admin_id['id'];
      header('location:index.php');
   }else{
      $mensagem[] = 'Login de usuário ou senha incorreta!';
   }

}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="shortcut icon" href="../imagens/logo.jpg" type="image/x-icon">

</head>

<body>

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

    <section class="form-container">

        <form action="" method="POST">
            <h3>Acessar Agora</h3>
            <input type="text" name="nome" maxlength="20" required placeholder="digite seu login de usuário" class="box"
                oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="senha" maxlength="20" required placeholder="digite a sua senha" class="box"
                oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" value="Entrar" name="submit" class="btn">
        </form>

    </section>

</body>

</html>