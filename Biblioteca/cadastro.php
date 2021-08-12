<?php
include "DadosServidor.php";

$conexao=mysqli_connect($Servidor,$Usuario,$Senha,$BaseDeDados);


$DadosDoLivro=$_POST['DadosDoLivro'];

$titulo=$DadosDoLivro[0];

$subtitulo=$DadosDoLivro[1];
$peso=$DadosDoLivro[2];
$isbn10=$DadosDoLivro[3];
$isbn13=$DadosDoLivro[4];
$edicao=$DadosDoLivro[5];

$tipoedicao=$DadosDoLivro[6];

$volume=$DadosDoLivro[7];
$paginas=$DadosDoLivro[8];
$local=$DadosDoLivro[9];
$ano=$DadosDoLivro[10];
$valor=$DadosDoLivro[11];


if(empty($titulo) || empty($subtitulo) || empty($peso) || empty($isbn10) || empty($isbn13) || empty($edicao) || empty($tipoedicao) || empty($volume) || empty($paginas) || empty($local) || empty($ano) || empty($valor))
 {
	header('location: cadastro.php');
	exit();
}

$Capa=$_FILES["nCapa"];// carrega a imagem para variável capa
$nomeFinal = 'temp/'.time().'.jpg'; // atribui um nome temporário
move_uploaded_file($Capa['tmp_name'], $nomeFinal); //move a imagem para um doiretório temporário temp
$tamanhoImg = filesize($nomeFinal);// pega o tamanho do arquivo da imagem
$capa = addslashes(fread(fopen($nomeFinal, "r"), $tamanhoImg)); // abre o arquivo, faz a leitura e codifica a imagem para o formato de texto.

 if(empty($capa))
 {
 	header('location: cadastro.php');
	exit();
 }

$editora=$_POST['Editora'];

if ($editora[0]==0){
	$sql="INSERT INTO `editoras`(`idEditora`, `nome`, `site`) VALUES (null,'$editora[1]','$editora[2]')";
	mysqli_query($conexao,$sql);
	$Editora= mysqli_insert_id($conexao);

}else{
	$Editora=$editora[0];
}


$categoria=$_POST['Categoria'];
if ($categoria[0]==0){
	$sql="INSERT INTO `categorias`(`idCategoria`, `categoria`) VALUES (null,'$categoria[1]')";
	mysqli_query($conexao,$sql);
	$Categoria= mysqli_insert_id($conexao);

}else{
	$Categoria=$categoria[0];
}


$idioma=$_POST['Idioma'];
if ($idioma[0]==0){
	$sql="INSERT INTO `idiomas`(`ididioma`, `idioma`) VALUES (null,'$idioma[1]')";
	
	mysqli_query($conexao,$sql);
	$Idioma= mysqli_insert_id($conexao);
}else{
	$Idioma=$categoria[0];
}



$link=$_POST['Link'];
if ($link[0]==0){
	$Link="exemplares/".$isbn13.".pdf";
}else{
	$Link=$link[1];
}


$autor=$_POST['Autor'];
if ($autor[0]==0){
	$sql="INSERT INTO `idiomas`(`ididioma`, `idioma`) VALUES (null,'$idioma[1]')";
	
	mysqli_query($conexao,$sql);
	$autor= mysqli_insert_id($conexao);
}else{
	$autor=$categoria[0];
}


$referencia=$DadosDoLivro[12];



$sql="INSERT INTO `livros`(`idlivro`, `lfk_idEditora`, `lfk_idCategoria`, `titulo`, `subtitulo`, `isbn10`, `isbn13`, `edicao`, `TipoDeEdicao`, `volume`, `paginas`, `ano`, `capa`, `link`, `peso`, `valor`, `referencia`) VALUES (null,$Editora,$Categoria,'$titulo','$subtitulo',$isbn10,$isbn13,$edicao,$tipoedicao,$volume,$paginas,$ano,'$capa','$Link',$peso,$valor,'$referencia')";


mysqli_query($conexao,$sql);

unlink($nomeFinal);


$Livro= mysqli_insert_id($conexao);


$sql="INSERT INTO `idiomadolivro`(`ifk_idlivro`, `ifk_idEditora`, `ifk_idCategoria`, `ifk_ididioma`) VALUES ($Livro,$Editora,$Categoria,$Idioma)";
mysqli_query($conexao,$sql);

$autores=$_POST['Autor'];

foreach ($autores as $autor) {

if($autor!=""){
	echo$autor;
	$sql="SELECT COUNT(*) as quantidade FROM autores WHERE nome='$autor'";
	$result=mysqli_query($conexao,$sql);
	$data=mysqli_fetch_assoc($result);

	if($data["quantidade"]==0){//se houver necessidade de cadastrar o autor
		$sql="INSERT INTO `autores`(`idAutores`, `Nome`) VALUES (null,'$autor')";
		mysqli_query($conexao,$sql);
		$Autor= mysqli_insert_id($conexao);
		$sql="INSERT INTO `autoresdolivro`(`afk_idAutores`, `afk_idlivro`, `afk_idEditora`, `afk_idCategoria`) VALUES ($Autor,$Livro,$Editora,$Categoria)";
		mysqli_query($conexao,$sql);
		
	}else{// se não houver necessidade de cadastro e sim apenas viculação do autor ao livro
		
		$sql="SELECT `idAutores` as idAutor FROM `autores` WHERE Nome='$autor'";
		$result=mysqli_query($conexao,$sql);
		$data=mysqli_fetch_assoc($result);
		$Autor=$data["idAutor"];
		$sql="INSERT INTO `autoresdolivro`(`afk_idAutores`, `afk_idlivro`, `afk_idEditora`, `afk_idCategoria`) VALUES ($Autor,$Livro,$Editora,$Categoria)";
		mysqli_query($conexao,$sql);
		
	}

}

}


?>

<html>
	<head>
	</head>
	<body>
		<?php 
			$result=mysqli_query($conexao,"SELECT * FROM livros where idlivro=$Livro");
			
			while($row=mysqli_fetch_assoc($result)) { 
			
			
			echo"
				<h3> Você acabou de cadastrar com sucesso o livro:</h3>
				<table>
					<tr>
						<td colspan='3'><h3 style='text-align:center'>".$row['titulo']."</h3><br><h5 style='text-align:center'>".$row['subtitulo']."</h5></td>					

					</tr>
					<tr>
						<td rowspan='10' >";
						
						echo"<a href='#'><img style='width:250px; height:300px;' src='data:image/jpeg;base64,".base64_encode( $row['capa'] )."'></a>";
						
			echo"
						</td>
						<td>ISBN10:</td>
						<td>".$row['isbn10']."</td>							
					</tr>
					<tr>
						<td>ISBN13:</td>	
						<td>".$row['isbn13']."</td>							
					</tr>
					<tr>
						<td>Edição:</td>	
						<td>".$row['edicao']."</td>							
					</tr>
					<tr>
						<td>Tipo de Edição:</td>	
						<td>".$row['TipoDeEdicao']."</td>							
					</tr>
					<tr>
						<td>Tipo de Volume:</td>	
						<td>".$row['volume']."</td>							
					</tr>
					<tr>
						<td>Páginas:</td>	
						<td>".$row['paginas']."</td>							
					</tr>
					<tr>
						<td>Ano:</td>	
						<td>".$row['ano']."</td>							
					</tr>
					<tr>
						<td>Peso:</td>	
						<td>".$row['peso']."</td>							
					</tr>
					<tr>
						<td>valor:</td>	
						<td>".$row['valor']."</td>							
					</tr>
					<tr>
						<td>Referência:</td>	
						<td>".$row['referencia']."</td>							
					</tr>
					<tr>
						<td colspan='3'><a href=''>Consultar</a>
						<a href='editar.php'>Editar</a>
						<a href='cadastro.php'>Cadastrar</a></td>							
					</tr>
				</table>
			";

			}
			mysqli_close($conexao);
		?>
</body>
</html>