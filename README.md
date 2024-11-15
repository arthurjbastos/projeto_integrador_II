# projeto_integrador_II
Arquivos do Projeto Integrador II da UNIVESP, do grupo DRP04-PJI240-SALA-003 GRUPO-006, membros: 
Arthur Jorge Bastos, RA 2216121
Felipe de Souza Andrade Pereira, RA 2213677
Guilherme José Nieri de Barros, RA 2215391
Janaina Silvino de Paula, RA 2231664
Marcelo Alves de Oliveira, RA 1709270
Marcelo Henrique Moraes, RA 1817666, Orientadora: Giulia Bauab Levai.

(Os arquivos estavam em outro repositório do Github, de outro membro do grupo, porém de forma privada, ou seja, apenas transferi os arquivos para um novo repositório público para a avaliação.)

Os testes foram realizados utilizando XAMPP, com Apache e MySQL, (apachefriends.org/pt_br/index.html)
Usando o "phpMyAdmin" incluso no XAMPP para banco de dados.

Em caso de erro:

- verificar se "extension=pdo_mysql" está comentado no arquivo "php.ini",
abra o XAMPP, clique nas configurações do Apache, php.ini, e remova o ponto e vírgula do começo de "extension=pdo_mysql".

- verificar se o phpMyAdmin foi instalado junto com o XAMPP durante a instalação do XAMPP

  

------------------------------------

  

PARA IMPORTAR O BANCO DE DADOS:

Acesse o phpMyAdmin na URL (localhost/phpmyadmin) com o servidor e o MySQL ligados no XAMPP.

Crie um novo banco de dados na esquerda em "Novo"

Coloque como nome "marchiatto_db"

Ainda no phpMyAdmin, Selecione "Importar" no topo do menu, adicione o arquivo do repositório,

importe o arquivo "marchiatto_db.sql"

Mantenha todas as opções padrão, clique em "Importar" no fim da página.

Agora sua máquina tem o banco de dados atualizado com o usuário admin.

---------------------------

Administrador padrão: admin, senha: 111
Usuário padrão: teste@gmail.com, senha: 123

