<?php

if(isset($_POST['add_no_carrinho'])){

   if($id_usuario == ''){
      header('location:login.php');
   }else{

      $pid = $_POST['pid'];
      $pid = filter_var($pid, FILTER_SANITIZE_STRING);
      $nome = $_POST['nome'];
      $nome = filter_var($nome, FILTER_SANITIZE_STRING);
      $preco = $_POST['preco'];
      $preco = filter_var($preco, FILTER_SANITIZE_STRING);
      $imagem = $_POST['imagem'];
      $imagem = filter_var($imagem, FILTER_SANITIZE_STRING);
      $quantidade = $_POST['quantidade'];
      $quantidade = filter_var($quantidade, FILTER_SANITIZE_STRING);

      $check_carrinho = $conn->prepare("SELECT * FROM `carrinho` WHERE nome = ? AND id_usuario = ?");
      $check_carrinho->execute([$nome, $id_usuario]);

      if($check_carrinho->rowCount() > 0){
         $mensagem[] = 'Já adicionado no carrinho!';
      }else{
         $insert_carrinho = $conn->prepare("INSERT INTO `carrinho`(id_usuario, pid, nome, preco, quantidade, imagem) VALUES(?,?,?,?,?,?)");
         $insert_carrinho->execute([$id_usuario, $pid, $nome, $preco, $quantidade, $imagem]);
         $mensagem[] = 'Adicionado ao carrinho!';
         
      }

   }

}

?>