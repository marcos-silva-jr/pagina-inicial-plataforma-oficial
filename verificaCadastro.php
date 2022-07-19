<!-- =======================================================-->
<!--------------------- COMEÇANDO CÓDIGO PHP ----------------->
<!-- =======================================================-->

<?php
	
	//PEGA AS VARIAVEIS VINDAS DO OUTRO ARQUIVO
	$cpf =  $_POST['cpf'];
	$nome =  $_POST['nome'];
	$senha =  $_POST['senha'];
	$filial =  $_POST['filial'];
	$tipo =  $_POST['tipo'];

	require_once "conexaoSQL/Conexao.php";

	date_default_timezone_set('America/Sao_Paulo');
	$hoje = date('Y.m.d H:i:s'); //PEGA DATA ATUAL PARA PREENCHER AUTOMATICO NA BAIXA
	
	// ==================== ***************************************** ==================			
	// ==================== INSERT PARA INSERIR USUARIOS NO SISTEMA
	// ==================== ***************************************** ==================
	try {
		$Conexao    = Conexao::getConnection(); //conecta com o banco
		
        $usuarios   = $query->fetchAll();		
	}
	catch (Exception $e){ } 
	echo "<script type='text/javascript'>alert('OK :: Usuário $nome cadastrado com sucesso.'); window.location='painel-Administrativo.php';</script>";			
?>

<!DOCTYPE html>
    <html>
    <head>
	<link rel="shortcut icon" type="imagex/png" href="logoOficialIco.ico">
    <title>AUTENTICACAO DE LOGIN - BAIXA MOBILE [ATUEX]</title>
    </head>
    <body>
    </body>
    </html>