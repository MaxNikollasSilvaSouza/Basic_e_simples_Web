
<?php
$O=$_POST["nOpcao"];
$D=$_POST["nDist"];
$V=$_POST["nVel"];
$T=$_POST["nTemp"];

define("UmDia",24);

if($O=="distancia"){
	
	$D=$V*$T;
	echo "A Distância é: $D";
	
}else if($O=="velocidade"){
	if(($D>=0)&&($T>0)){
		$V=$D/$T;
		echo "A velocidade é: $V";
	}else{
		echo"<script>alert('Verifique os dados digitados como entrada');</script>";
	}

}else{
	if(($D>=0)and($V>0)){
		$T=$D/$V;
		$horasrestante=$T%UmDia;
		$T=$T-$horasrestante;
		$dias=$T/UmDia;
		echo "Quantidade de dias: $dias e quantidade de $horasrestante ";
	}else{
		echo"<script>alert('Verifique os dados digitados como entrada');</script>";
	}
}


for($i=2;$i<5;$i++){
			
				echo "<br>".$i."<br>";
	
}












/*

for($i=0;$i<=5;$i++){
	
}

>
<
>=
<=
!=  
==

and
or

Após chover na cidade de São Paulo, as águas da chuva descerão o rio Tietê até o rio Paraná, percorrendo cerca de 1.000km. Sendo de 4km/h a velocidade média das águas, o percurso mencionado será cumprido pelas águas da chuva em aproximadamente:


variáveis de Entrada:  
Distância($D) 
Velocidade($V)


Variáveis de saída:
Tempo($T)


Fórmula usada:

$V=$D/$T => $T=$D/$V


*/

?>




