<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['id_usuario'])){
   $id_usuario = $_SESSION['id_usuario'];
}else{
   $id_usuario = '';
};

if(isset($_POST['send'])){

   $nome = $_POST['nome'];
   $nome = filter_var($nome, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $telefone = $_POST['telefone'];
   $telefone = filter_var($telefone, FILTER_SANITIZE_STRING);
   $mensagem = $_POST['mensagem'];
   $mensagem = filter_var($mensagem, FILTER_SANITIZE_STRING);

   $select_mensagem = $conn->prepare("SELECT * FROM `mensagens` WHERE nome = ? AND email = ? AND telefone = ? AND mensagem = ?");
   $select_mensagem->execute([$nome, $email, $telefone, $mensagem]);

   if($select_mensagem->rowCount() > 0){
      $msg[] = 'Mensagem já enviada!';
   }else{

      $insert_mensagem = $conn->prepare("INSERT INTO `mensagens`(id_usuario, nome, email, telefone, mensagem) VALUES(?,?,?,?,?)");
      $insert_mensagem->execute([$id_usuario, $nome, $email, $telefone, $mensagem]);

      $msg[] = 'Mensagem enviada com sucesso!';

   }

}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contato</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   <link rel="shortcut icon" href="imagens/logo.jpg" type="image/x-icon">

</head>
<body>

<?php include 'components/user_header.php'; ?>


<div class="heading">
   <h3>contato</h3>
   <p><a href="index.php">home</a> <span> / contato</span></p>
</div>

<section class="contato">

   <div class="row">

      <div class="imagem">
         <img src="imagens/contato.png" alt="">
      </div>

      <form action="" method="post">
         <h3>Entre em contato!</h3>
         <input type="text" name="nome" maxlength="50" class="box" placeholder="Digite seu nome" required>
         <input type="number" name="telefone" min="0" max="9999999999" class="box" placeholder="Digite seu telefone" required maxlength="10">
         <input type="email" name="email" maxlength="50" class="box" placeholder="Digite o e-mail" required>
         <textarea name="mensagem" class="box" required placeholder="Digite sua mensagem" maxlength="500" cols="30" rows="10"></textarea>
         <input type="submit" value="enviar mensagem" name="send" class="btn">
      </form>

   </div>

</section>


<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>