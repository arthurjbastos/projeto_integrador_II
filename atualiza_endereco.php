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

   $endereco = $_POST['rua'] .', '.$_POST['numero'].', '.$_POST['bairro'].', '.$_POST['cidade'];
   $endereco = filter_var($endereco, FILTER_SANITIZE_STRING);

   $update_endereco = $conn->prepare("UPDATE `usuarios` set endereco = ? WHERE id = ?");
   $update_endereco->execute([$endereco, $id_usuario]);

   $mensagem[] = 'endereço salvo com sucesso!';

}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Atualizar endereço</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   <link rel="shortcut icon" href="imagens/logo.jpg" type="image/x-icon">

</head>
<body>
   
<?php include 'components/user_header.php' ?>

<section class="form-container">

   <form action="" method="post">
      <h3>Seu endereço</h3>
      <input type="text" class="box" placeholder="Nome da rua" required maxlength="50" name="rua">
      <input type="text" class="box" placeholder="Nº " required maxlength="50" name="numero">
      <input type="text" class="box" placeholder="Bairro" required maxlength="50" name="bairro">
      <input type="text" class="box" placeholder="Cidade" required maxlength="50" name="cidade">
      <input type="submit" value="salvar endereco" name="submit" class="btn">
   </form>

</section>

<?php include 'components/footer.php' ?>

<script src="js/script.js"></script>

</body>
</html>