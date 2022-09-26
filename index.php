<?php
	date_default_timezone_set('America/Sao_Paulo');
	$hoje = date('Y'); //PEGA DATA ATUAL PARA PREENCHER AUTOMATICO NA BAIXA
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
	   $d4ispositivo = "mobile"; //SE FOR MOBILE REDIRECIONA PARA A OUTRA PAGIN
	   header('Location: mobile-index.php');
	}

	else { $dispositivo = "computador";} //SE NÃO MANTEM A VERSÃO DESKTOP :)		
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		
		<link rel="shortcut icon" type="imagex/png" href="fav.png"> <!--ICONE-->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Plataforma Oficial</title>

		<!--Carrega as bibliotecas JavaSript para as máscaras de CPF, Celular, etc. -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/4.0.9/jquery.inputmask.bundle.min.js"></script>

		<!--CHAMANDO O ARQUIVO CSS E JAVA SCRIPT-->
		<link rel="stylesheet" type="text/css" href="css/estilo.css" media="screen" />
		<link rel="stylesheet" type="text/javascript" href="javascript/javascript.js" media="screen" />

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
		<script language="javascript" type="text/javascript"> 
			function limitText(limitField, limitNum) { //FUNÇÃO PARA TRAVAR OS 11 CARACTERES DO CPF E OS 44 DO CONHECIMENTO
				if (limitField.value.length > limitNum) {
					limitField.value = limitField.value.substring(0, limitNum);
				}
			}
			
			function mascaraMutuario(o, f) {
			  v_obj = o
			  v_fun = f
			  setTimeout('execmascara()', 1)
			}

			function execmascara() {
			  v_obj.value = v_fun(v_obj.value)
			}
			
			function cpfCnpj(v) {
			  //Remove tudo o que não é dígito
			  v = v.replace(/\D/g, '')

			  if (v.length <= 13) {
				//CPF

				//Coloca um ponto entre o terceiro e o quarto dígitos
				v = v.replace(/(\d{3})(\d)/, '$1.$2')

				//Coloca um ponto entre o terceiro e o quarto dígitos
				//de novo (para o segundo bloco de números)
				v = v.replace(/(\d{3})(\d)/, '$1.$2')

				//Coloca um hífen entre o terceiro e o quarto dígitos
				v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2')
			  } else {
				//CNPJ

				//Coloca ponto entre o segundo e o terceiro dígitos
				v = v.replace(/^(\d{2})(\d)/, '$1.$2')

				//Coloca ponto entre o quinto e o sexto dígitos
				v = v.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3')

				//Coloca uma barra entre o oitavo e o nono dígitos
				v = v.replace(/\.(\d{3})(\d)/, '.$1/$2')

				//Coloca um hífen depois do bloco de quatro dígitos
				v = v.replace(/(\d{4})(\d)/, '$1-$2')
			  }

			  return v
			}
		</script>
		</head>

<!---------------------------COMEÇANDO CORPO DA PÁGINA---------------------------->

<body style="background: url(fundo.png) no-repeat center top fixed; overflow: hidden; position: fixed; height: 100%; width: 100%; background-size: cover;">
	
	<div id="login-container" style="width: 35%; margin-left: 2rem; margin-top:2rem;">
		<img src="inicial.png" title="Logo" style="width: 230px; height: 90px; text-align: center;"/>
		<label for="logins" style="text-align: center; font-size: 1.8rem;"></label>  
			<form action="verificaLogin.php" method="post">
			<label for="usuario" style='font-size: 1.6rem;'>Usuário</label>
			<input type="text" style='font-size: 1.6rem;' onKeyDown="limitText(this,18);" onKeyUp="limitText(this,18); mascaraMutuario(this,cpfCnpj)" placeholder="Digite o seu CPF/CNPJ" required name="login" id="login" autocomplete="off"><br/><br>
			<label for="senha" style='font-size: 1.6rem;'>Senha</label>
			<input type="password" style='font-size: 1.6rem;'onKeyDown="limitText(this,5);" onKeyUp="limitText(this,5);" placeholder="Digite a sua senha" required name="senha" id="senha"> 
			<input  type="submit" value="LOGIN" style='font-size: 1.6rem; height:3rem;' id="entrar" name="entrar" >
		</form>	
		<!-- =========================================== ********************************** ===========================
		======================================================== DIV RODAPÉ ===========================================
		=========================================== ********************************======================================-->
		<div id="rodape">
				<label style="background-color: #042f66;    text-align: center;    font-weight:normal;    width:100%;
				color:white;     position:fixed;     bottom:0px;       font-size: 0.9rem;    height: 1.8rem;">
					<?php echo date('Y'); ?> Desenvolvido por Marcos Silva
					</label>
		</div>
	</div>	
</body>
</html>
