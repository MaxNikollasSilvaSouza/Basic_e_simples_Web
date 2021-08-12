<?php
	include "DadosServidor.php";
	$conexao=mysqli_connect($Servidor,$Usuario,$Senha,$BaseDeDados);
?>

<!DOCTYPE html>
<html>
	<head>
	<meta charset="UTF-8">
	<title>Biblioteca Virtual</title>
	<!-- Bootstra -->
	<link rel="stylesheet" type="text/css" href="boot/css/bootstrap.min.css">
		<script>
			function NovaEditora(editora) {
				if (editora=="0"){
					document.getElementById("ieEditora").style.visibility = "visible";
					document.getElementById("ieSite").style.visibility = "visible";
				}else{
					document.getElementById("ieEditora").style.visibility = "hidden";
					document.getElementById("ieSite").style.visibility = "hidden";
				}
			}

			function NovaCategoria(categoria) {
				if (categoria=="0"){
					document.getElementById("ieCategoria").style.visibility = "visible";
				}else{
					document.getElementById("ieCategoria").style.visibility = "hidden";
				}
			}

			function NovoIdioma(idioma) {
				if (idioma=="0"){
					document.getElementById("ieIdioma").style.visibility = "visible";
				}else{
					document.getElementById("ieIdioma").style.visibility = "hidden";
				}
			}

			function NovoLink(link) {
				if (link=="0"){
					document.getElementById("ieLink").style.visibility = "hidden";
				}else{
					document.getElementById("ieLink").style.visibility = "visible";
				}
			}
		</script>

	<style>
		input,select{width: 100%;}
		body{background-image: url('fundo.jpg');background-repeat: no-repeat;background-size: cover;}
	</style>
</head>
<body>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-4">
			<form method="POST" action="cadastro.php" enctype="multipart/form-data">
			<!-- titulo -->
			<legend>Título do livro:</legend>
			<input type="text" name="DadosDoLivro[]" id="iTitulo">

			<!-- subtitulo -->
			<legend>Subtítulo livro:</legend>
			<input type="text" name="DadosDoLivro[]" id="iSubtitulo">

			<!-- Peso -->
			<legend>Peso (Kg):</legend>
			<input type="number" name="DadosDoLivro[]" id="iPeso">

			<!-- isbn -->
			<legend>ISBN-10:</legend>
			<input type="number" name="DadosDoLivro[]" id="iIsbn10">

			<!-- Isbn -->
			<legend>ISBN-13:</legend>
			<input  type="number" name="DadosDoLivro[]" id="iIsbn13">

			<!-- Select -->
			<legend>Edição:</legend>
			<input  type="number" name="DadosDoLivro[]" id="iEdicao">
			<select name="DadosDoLivro[]">
				<option value="0" select>Não especificada</option>
				<option value="1">Revisada</option>
				<option value="2">Atualizada</option>
				<option value="3">Aumentada</option>
				<option value="4">Revisada e Autalizada</option>
				<option value="5">Revisada e Aumentada</option>
				<option value="6">Atualizada e Aumentada</option>
				<option value="7">Revisada, Autalizada e Aumentada</option>
			</select>
		</div>

		<!-- Segunda divisão -->
		<div class="col-md-4">
			<!-- Select 2 -->
			<legend>Volume:</legend>
			<select name="DadosDoLivro[]" id="iVolume">
				<option value="0">Único</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
			</select>

			<!-- Paginas -->
			<legend>Páginas:</legend>
			<input type="number" name="DadosDoLivro[]" id="ipagina">

			<!-- Publicação -->
			<legend>Local de Publicação:</legend>
			<input  type="text" name="DadosDoLivro[]" id="iLocal">

			<!-- ano -->
			<legend>Ano:</legend>
			<input type="number" name="DadosDoLivro[]" id="iAno">

			<!-- valor -->
			<legend>Valor:</legend>
			<input type="number" name="DadosDoLivro[]" id="iValor">

			<!-- capa -->
			<legend>Capa:</legend>
			<input type="file" name="nCapa" id="iCapa">
		</div>

		<div class="col-md-4">
			<!-- Editora -->
			<legend>Editora:</legend>
			<select style="width:100%" name="Editora[]" id="isEditora" onchange="NovaEditora(this.value)">
				<?php
					$sql="SELECT * FROM `editoras`";
					$result=mysqli_query($conexao,$sql);
					$posicao=true;
					while($row = mysqli_fetch_assoc($result)){
						if($posicao==true){
							echo"<option select value='".$row["idEditora"]."'>".$row["nome"]."</option>";
							$posicao=false;
						}else{
							echo"<option value='".$row["idEditora"]."'>".$row["nome"]."</option>";
						}
					}	
				?>
				<option value="0">outra</option>
			</select>
			<input placeholder="Digite o nome da editora" style="width:96%;margin-top:5px;visibility:hidden;" id="ieEditora" name="Editora[]" type="text">
			<input placeholder="Digite o site da editora" style="width:96%;margin-top:5px;visibility:hidden;" id="ieSite" name="Editora[]" type="text">

			<!-- Categoria -->
			<legend>Categoria:</legend>
			<select style="width:100%" name="Categoria[]" id="isCategoria" onchange="NovaCategoria(this.value)">
				<?php
					$sql="SELECT * FROM `categorias`";
					$result=mysqli_query($conexao,$sql);
					$posicao=true;
					while($row = mysqli_fetch_assoc($result)){
						if($posicao==true){
							echo"<option select value='".$row["idCategoria"]."'>".$row["categoria"]."</option>";
							$posicao=false;
						}else{
							echo"<option value='".$row["idCategoria"]."'>".$row["categoria"]."</option>";
						}
					}	
				?>
			<option value="0">outra</option>
			</select>
			<input style="width:97%;margin-top:5px;visibility:hidden;" id="ieCategoria" name="Categoria[]" type="text">

			<!-- Idioma -->
			<legend>Idioma:</legend>
			<select style="width:103%" name="Idioma[]" id="iIdioma"  onchange="NovoIdioma(this.value)">
				<?php
					$sql="SELECT * FROM `idiomas`";
					$result=mysqli_query($conexao,$sql);
					$posicao=true;
					while($row = mysqli_fetch_assoc($result)){
						if($posicao==true){
							echo"<option select value='".$row["ididioma"]."'>".$row["idioma"]."</option>";
							$posicao=false;
						}else{
							echo"<option value='".$row["ididioma"]."'>".$row["idioma"]."</option>";
						}
					}	
				?>
				<option value="0">outro</option>
			</select>
			<input style="width:97%;margin-top:5px;visibility:hidden;" id="ieIdioma" name="Idioma[]" type="text">

			<!-- Referencia -->
			<legend>Referência:</legend>
			<input style="width:100%" type="text" name="DadosDoLivro[]" id="iReferencia">

			<!-- Link -->
			<legend>Link de acesso:</legend>
			<select style="width:100%" name="Link[]" id="iLink"  onchange="NovoLink(this.value)">
				<option value='0'>Definir link depois</option>
				<option value='1'>Definir link agora</option>
			</select>
			<input style="width:100%;margin-top:5px;visibility:hidden;" type="text" name="link[]" id="ieLink">

			<!-- Autores -->
			<legend>Autores:</legend>
			<input placeholder="Digite o nome do primeiro autor" style="width:100%" type="text" name="Autor[]" id="iAutor">
			<input placeholder="Digite o nome do segundo autor" style="width:100%;margin-top:5px;" type="text" name="Autor[]" id="iAutor1">
			<input placeholder="Digite o nome do terceiro autor"style="width:100%; margin-top:5px;" type="text" name="Autor[]" id="iAutor2">
			<input placeholder="Digite o nome do quarto autor" style="width:100%; margin-top:5px;" type="text" name="Autor[]" id="iAutor3">
			<input placeholder="Digite o nome do quinto autor" style="width:100%; margin-top:5px;" type="text" name="Autor[]" id="iAutor4">

			<!-- Input -->
			<input type="submit">
		</div></form>
		</div>
	</div>
</div>
<?php

mysqli_close($conexao);
?>
</body>
</html>