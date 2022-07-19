<!--SCRIPT PARA EVITAR QUE O USUARIO VISUALIZE O CÓDIGO FONTE -->
<script language="JavaScript">
			$(document).keydown(function(event){
   			 if(event.keyCode==123){
        		return false;
    		 }
   			 else if (event.ctrlKey && event.shiftKey && event.keyCode==73){        
             	return false;
    		 }
			 });

			$(document).on("contextmenu",function(e){        
   			e.preventDefault();
			});
    		function protegercodigo() {
    			if (event.button==2||event.button==3){
        		alert('ATENÇÃO::AÇÃO BLOQUEADA');}
    		}
    		document.onmousedown=protegercodigo
</script>

<!-- =======================================================-->
<!--------------------- COMEÇANDO CÓDIGO PHP ----------------->
<!-- =======================================================-->

<?php
	$login =  $_POST['login'];	
	$espec = $_POST['login'];	
	$senha =  $_POST['senha'];

	require_once "conexaoSQL/Conexao.php";

	date_default_timezone_set('America/Sao_Paulo');
	$hoje = date('Y.m.d'); //PEGA DATA ATUAL PARA PREENCHER AUTOMATICO NA BAIXA
	$hora = date('H:i:s'); //PEGA HORA ATUAL PARA PREENCHER AUTOMATICO NA BAIXA
	$dt_login = $hoje." ".$hora;
	$validarLogin=0;

	
	// ==================== ***************************************** ==================			
	// ==================== SELECT PARA VERIFICAR USUARIOS NO SISTEMA
	// ==================== ***************************************** ==================

	try {
		$Conexao    = Conexao::getConnection(); //conecta com o banco
		
        $usuarios   = $query->fetchAll();
		
			foreach($usuarios as $busca_usuario) {
				if($login==$busca_usuario['USUARIO_CPF']){ //PROCURA CPF DIGITADO
					if($senha==$busca_usuario['SENHA_USUARIO']){ //PROCURA SENHA PARA VER SE CONFERE
						if($busca_usuario['STATUS_USUARIO']==0){ //VERIFICA SE USUARIO ESTÁ ATIVADO PARA PODER DEIXAR LOGAR
							$login=$busca_usuario['NOME_USUARIO']; //SE SIM SALVA O NOME NA VARIAVEL LOGIN
							$tipoUsuario=$busca_usuario['TIPO_USUARIO']; //SALVA O TIPO DO USUARIO PARA AUTENTICACAO NO QUE LIBERAR PARA ELE
							$validarLogin=1; //E ALTERA A VARIAVEL QUE VALIDA
							// ==================== ************************ ==================
							// ==================== INSERT DE REGISTRO LOGIN ==================
							// ==================== ************************ ==================
							
							$insert = $queryInsert->fetchAll();
						}
					}	
					else{ echo "<script type='text/javascript'>alert('ERRO :: SENHA INCORRETA'); window.location='index.php';</script>"; }									
				}
				else { $validarLogin=2;	} 
			}
	} //========= FECHA TRY
	 catch (Exception $e){
		if($validarLogin==1){ //SE VALIDADOR ESTA OK MOSTRA MENSAGEM E REDIRECIONA PARA OUTRA PAGINA			
	
			/* CONFERENCIA DE DISPOSITIVO SE É MOBILE OU DESKTOP */

			$iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
			$ipad = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");
			$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
			$palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
			$berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
			$ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
			$symbian = strpos($_SERVER['HTTP_USER_AGENT'],"Symbian");
			$windowsphone = strpos($_SERVER['HTTP_USER_AGENT'],"Windows Phone");

			if ($iphone || $ipad || $android || $palmpre || $ipod || $berry || $symbian || $windowsphone == true) {
				
				//SE FOR MOBILE REDIRECIONA PARA A OUTRA PAGINA
				
				session_start(); //INICIA A SESSÃO DO USUARIO PARA IR PARA OUTRA PAGINA JÁ LOGADO
				$_SESSION['login']=$login; //SESSÃO DO USUARIO GANHA O NOME DO USUARIO QUE ACABOU DE LOGAR
				/*
				if($espec == "32.172.865/0001-21"){ //BLOQUEIA RENORMA
					echo "<script type='text/javascript'>alert('ERRO :: Baixas apenas via DESKTOP'); window.location='index.php'</script>";
				}*/
				if($tipoUsuario=="0"){
					echo "<script type='text/javascript'>alert('Bem-vindo(a) ao sistema, $login - [MÓDULO ADMIN]'); window.location='painel-Administrativo.php'</script>";
				}
				else if($tipoUsuario=="1"){
					echo "<script type='text/javascript'>alert('Bem-vindo(a) ao sistema, $login - [MÓDULO OPERACIONAL]'); window.location='painel-Operacional.php'</script>";
				}
				else if($tipoUsuario=="2"){
					echo "<script type='text/javascript'>alert('Bem-vindo(a) ao sistema, $login - [MÓDULO MOTORISTAS]'); window.location='mobile-Painel-ModuloMotorista.php'</script>";
				}
				else if($tipoUsuario=="3"){
					echo "<script type='text/javascript'>alert('Bem-vindo(a) ao sistema, $login - [MÓDULO AGREGADOS]'); window.location='enviarDados-ModuloMotorista.php'</script>";					
				}
				else if($tipoUsuario=="4"){					
					echo "<script type='text/javascript'>alert('Bem-vindo(a) ao sistema, $login - [MÓDULO PARCEIROS]'); window.location='mobile-dashboardParceiros.php'</script>";
				}
				else if($tipoUsuario=="5"){
					echo "<script type='text/javascript'>alert('Bem-vindo(a) ao sistema, $login - [MÓDULO CLIENTE]'); window.location='dashboard-cliente.php?pagina=1'</script>";
				}
				else if($tipoUsuario=="6"){ //VENDEDORES
					echo "<script type='text/javascript'>alert('Bem-vindo(a) ao sistema, $login - [MÓDULO GERENCIAMENTO DE PARCEIROS]'); window.location='dashboard-gerenciamento-parceiros.php'</script>";
				}
				else{
					echo "<script type='text/javascript'>alert('ERRO :: Usuário $login [NÃO LOCALIZADO]'); window.location='index.php'</script>";
				}
			}
			else{
				session_start(); //INICIA A SESSÃO DO USUARIO PARA IR PARA OUTRA PAGINA JÁ LOGADO
				$_SESSION['login']=$login; //SESSÃO DO USUARIO GANHA O NOME DO USUARIO QUE ACABOU DE LOGAR
				
				/* =====================================================================================================
				============= AUTENTICA CONFORME NIVEL DE ACESSO DO USUARIO E REDIRECIONA PARA TELA ESPECIFICA =========
				===================================================================================================== */
				
				if($tipoUsuario=="0"){ //ADMIN
					echo "<script type='text/javascript'>alert('Bem-vindo(a) ao sistema, $login - [MÓDULO ADMIN]'); window.location='painel-Administrativo.php'</script>";
				}
				else if($tipoUsuario=="1"){ //FUNCIONARIOS
					//if($espec == "099.994.898-93"){
					//	echo "<script type='text/javascript'>alert('Bem-vindo(a) ao sistema, $login - [MÓDULO GERENCIAMENTO DE PARCEIROS]'); window.location='dashboard-gerenciamento-parceiros.php'</script>";
					//}
					echo "<script type='text/javascript'>alert('Bem-vindo(a) ao sistema, $login - [MÓDULO OPERACIONAL]'); window.location='painel-Operacional.php'</script>";
				}
				else if($tipoUsuario=="2"){ //MOTORISTAS
					echo "<script type='text/javascript'>alert('Bem-vindo(a) ao sistema, $login - [MÓDULO MOTORISTAS]'); window.location='enviarDados-ModuloMotorista.php'</script>";
				}
				else if($tipoUsuario=="3"){ //AGREGADOS
					echo "<script type='text/javascript'>alert('Bem-vindo(a) ao sistema, $login - [MÓDULO AGREGADOS]'); window.location='enviarDados-ModuloMotorista.php'</script>";					
				}
				else if($tipoUsuario=="4"){ //PARCEIROS												
					echo "<script type='text/javascript'>alert('[NOVIDADE] :: A partir de agora é possível realizar as baixas de comprovante por dispositivo móvel, ou seja, de qualquer smartphone ou tablet. Já está disponível a Nova Versão do App de Baixas de Comprovante para Parceiros – V2.7.22. Para acessar basta acessar este mesmo endereço URL pelo celular em seu navegador.'); </script>";						
					echo "<script type='text/javascript'>alert('Bem-vindo(a) ao sistema, $login - [MÓDULO PARCEIRO]'); window.location='enviarDados-ModuloParceiro.php?pagina=1'</script>";	
				}
				else if($tipoUsuario=="5"){ //CLIENTES
					echo "<script type='text/javascript'>alert('Bem-vindo(a) ao sistema, $login - [MÓDULO CLIENTE]'); window.location='dashboard-cliente.php?pagina=1'</script>";
				}
				else if($tipoUsuario=="6"){ //VENDEDORES
					echo "<script type='text/javascript'>alert('Bem-vindo(a) ao sistema, $login - [MÓDULO GERENCIAMENTO DE PARCEIROS]'); window.location='dashboard-gerenciamento-parceiros.php'</script>";
				}
				else{
					echo "<script type='text/javascript'>alert('ERRO :: Usuário $login [NÃO LOCALIZADO]'); window.location='index.php'</script>";
				}
			}
			exit;
		}
	} //========== FECHA CATCH
	if ($validarLogin==2){
		echo "<script type='text/javascript'>alert('ERRO :: DADOS INCORRETOS, VERIFIQUE NOVAMENTE'); window.location='index.php';</script>"; 
		exit;
	}
	
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