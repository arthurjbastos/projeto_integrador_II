<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['id_usuario'])){
   $id_usuario = $_SESSION['id_usuario'];
}else{
   $id_usuario = '';
};

if(isset($_POST['submit'])){

   $nome = $_POST['nome'];
   $nome = filter_var($nome, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $telefone = $_POST['telefone'];
   $telefone = filter_var($telefone, FILTER_SANITIZE_STRING);
   $senha = sha1($_POST['senha']);
   $senha = filter_var($senha, FILTER_SANITIZE_STRING);
   $csenha = sha1($_POST['csenha']);
   $csenha = filter_var($csenha, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `usuarios` WHERE email = ? OR telefone = ?");
   $select_user->execute([$email, $telefone]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $mensagem[] = 'email ou telefone já cadastrado!';
   }else{
      if($senha != $csenha){
         $mensagem[] = 'confirme a senha!';
      }else{
         $insert_user = $conn->prepare("INSERT INTO `usuarios`(nome, email, telefone, senha) VALUES(?,?,?,?)");
         $insert_user->execute([$nome, $email, $telefone, $csenha]);
         $select_user = $conn->prepare("SELECT * FROM `usuarios` WHERE email = ? AND senha = ?");
         $select_user->execute([$email, $senha]);
         $row = $select_user->fetch(PDO::FETCH_ASSOC);
         if($select_user->rowCount() > 0){
            $_SESSION['id_usuario'] = $row['id'];
            header('location:index.php');
         }
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Cadastro</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   <link rel="shortcut icon" href="imagens/logo.jpg" type="image/x-icon">

</head>
<body>
   

<?php include 'components/user_header.php'; ?>


<section class="form-container">

   <form action="" method="post">
      <h3>cadastro</h3>
      <input type="text" name="nome" required placeholder="digite seu nome" class="box" maxlength="50">
      <input type="email" name="email" required placeholder="digite seu e-mail" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="number" name="telefone" required placeholder="digite seu telefone" class="box" min="0" maxlength="15">
      <input type="password" name="senha" required placeholder="digite sua senha" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="csenha" required placeholder="confirme sua senha" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Cadastrar agora" name="submit" class="btn">
      <p>Já tem uma conta? <a href="login.php">Entrar agora</a></p>
   </form>

</section>











<?php include 'components/footer.php'; ?>







<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>