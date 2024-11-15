<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['id_usuario'])){
   $id_usuario = $_SESSION['id_usuario'];
}else{
   $id_usuario = '';
};

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sobre</title>

    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="imagens/logo.jpg" type="image/x-icon">

</head>

<body>

    <?php include 'components/user_header.php'; ?>


    <div class="heading">
        <h3>Sobre nós</h3>
        <p><a href="index.php">home</a> <span> / sobre</span></p>
    </div>

    <section class="sobre">

        <div class="row">

            <div class="imagem">
                <img src="imagens/foto-site10.jpg" alt="">
            </div>

            <div class="conteudo">
                <h3>Por quer nos escolher?</h3>
                <p>Nosso nome é uma homenagem quase-que-direta a clássica bebida 
                    Caffè macchiato, que é um espresso finalizado com espuma de leite, 
                    dando aquele toque especial.</p>
                <p>E também, conta a história, de um menino chamado Caio Marcatto, 
                    que foi apelidado trabalhando na Starbucks de "Marchiatto", 
                    que depois de 10 anos, abriu sua cafeteria em sua cidade natal, no interior, 
                    fazendo uma mistura do que aprendeu na caminhada.</p>
                <p>E é essa história, repleta de café, criatividade e coisa boa, 
                que vamos conversar, contar e construir juntos a cada dia. 
                Em um palco movido a cafeína e inovação.</p>
                <p>Bateu aquela vontade?</p>
                <a href="menu.php" class="btn">nosso menu</a>
            </div>

        </div>

    </section>


    <section class="steps">

        <h1 class="title">simples e rápido!</h1>

        <div class="box-container">

            <div class="box">
                <img src="imagens/step-1.png" alt="">
                <h3>Faça o pedido</h3>
                <p>Venha nos visitar e faça um pedido à moda antiga! Aproveite para bater um papo!</p>
            </div>

            <div class="box">
                <img src="imagens/step-2.png" alt="">
                <h3>entrega rápida</h3>
                <p>Ou acesse o site e peça através deste site, depois é só esperar na sua mesa!</p>
            </div>

            <div class="box">
                <img src="imagens/step-3.png" alt="">
                <h3>aproveite nossos produtos</h3>
                <p>Aproveite para fazer um pedido bem recheado, temos diversas opções!</p>
            </div>

        </div>

    </section>

    <?php include 'components/footer.php'; ?>

    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

    <script src="js/script.js"></script>

    <script>
    var swiper = new Swiper(".reviews-slider", {
        loop: true,
        grabCursor: true,
        spaceBetween: 20,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
            },
            700: {
                slidesPerView: 2,
            },
            1024: {
                slidesPerView: 3,
            },
        },
    });
    </script>

</body>

</html>