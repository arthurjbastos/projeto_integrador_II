<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['id_usuario'])){
   $id_usuario = $_SESSION['id_usuario'];
}else{
   $id_usuario = '';
};

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $senha = sha1($_POST['senha']);
   $senha = filter_var($senha, FILTER_SANITIZE_STRING);

   $select_usuario = $conn->prepare("SELECT * FROM `usuarios` WHERE email = ? AND senha = ?");
   $select_usuario->execute([$email, $senha]);
   $row = $select_usuario->fetch(PDO::FETCH_ASSOC);

   if($select_usuario->rowCount() > 0){
      $_SESSION['id_usuario'] = $row['id'];
      header('location:index.php');
   }else{
      $mensagem[] = 'Login ou senha incorreta!';
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
   <link rel="stylesheet" href="css/style.css">
   <link rel="shortcut icon" href="imagens/logo.jpg" type="image/x-icon">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>


<section class="form-container">

   <form action="" method="post">
      <h3>login</h3>
      <input type="email" name="email" required placeholder="Digite seu e-mail" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="senha" required placeholder="Digite sua senha" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Entrar" name="submit" class="btn">
      <p>Ainda não tem uma conta? <a href="cadastro.php">Cadastrar agora</a></p>
   </form>

</section>


<?php include 'components/footer.php'; ?>


<script src="js/script.js"></script>

</body>
</html>