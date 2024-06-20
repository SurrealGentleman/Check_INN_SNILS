<?php 
	if (isset($_POST['inn'])) {
		CheckINN($_POST['inn']);
	}
	if (isset($_POST['snils'])) {
		CheckSNILS($_POST['snils']);
	}
?>


<?php
	function CheckINN(string $inn)
	{
		$controllistN2 = [7, 2, 4, 10, 3, 5, 9, 4, 6, 8];
		$controllistN1 = [3, 7, 2, 4, 10, 3, 5, 9, 4, 6, 8];
		$controllistN = [2, 4, 10, 3, 5, 9, 4, 6, 8];
		$n2 = 0;
		$n1 = 0;
		$n = 0;
		if (is_numeric($inn) && ($inn > 0) && !empty($inn)) {
			if (strlen($inn) == 12){
				$charlist = str_split($inn);
				for ($i=0; $i < count($controllistN2); $i++) { 
					$n2 += ($charlist[$i]*$controllistN2[$i]);
				}
				$n2 = $n2 % 11;
				if ($n2 == 10){
					$n2 = 0;
				}
				for ($j=0; $j < count($controllistN1); $j++) { 
					$n1 += ($charlist[$j]*$controllistN1[$j]);
				}
				$n1 = $n1 % 11;
				if ($n1 == 10){
					$n1 = 0;
				}
				if ($n2 == $charlist[10] && $n1 == $charlist[11]){
					echo "<br> ИНН ПРАВИЛЬНЫЙ";
				}
				else{
					echo "<br> ИНН НЕПРАВИЛЬНЫЙ";
				}
			}
			elseif (strlen($inn) == 10) {
			 	$charlist = str_split($inn);
				for ($k=0; $k < count($controllistN); $k++) { 
					$n += $charlist[$k]*$controllistN[$k];
				}
				$n = $n % 11;
				if ($n == 10){
					$n = 0;
				}
				if ($n == $charlist[9]){
					echo "<br> ИНН ПРАВИЛЬНЫЙ";
				}
				else{
					echo "<br> ИНН НЕПРАВИЛЬНЫЙ";
				}
			}
			else{
				echo "<br> ИНН НЕПРАВИЛЬНЫЙ";
			}
		}
		elseif(empty($inn)){
			null;
		}
		else{
			echo "<br> НЕВЕРНЫЕ ДАННЫЕ";
		}
	}

	function CheckSNILS(string $snils)
	{
		$controllistPOS = [9, 8, 7, 6, 5, 4, 3, 2, 1];
		$w = 0;
		$prov = 1;
		$res = preg_replace("/[^0-9]/", "", $snils );
		$last2symbol = substr($res, -2);
		$charlistSN = str_split($res);
		$str = substr($res,0,-2);
		settype($str, 'integer');
		if ($str > 1001998 && !empty($snils)){
			for ($g=0; $g < strlen($res)-2; $g++) { 
				$w += ($charlistSN[$g] * $controllistPOS[$g]);
			}
			while ($prov == 1) {
				if ($w < 100) {
					if ($w == $last2symbol) {
						echo "СНИЛС ПРАВИЛЬНЫЙ";
						$prov = 0;
					}
					else{
						echo "СНИЛС НЕПРАВИЛЬНЫЙ";
						$prov = 0;
					}
				}
				elseif ($w == 100 || $w == 101) {
					if ($last2symbol == 00){
						echo "СНИЛС ПРАВИЛЬНЫЙ";
						$prov = 0;
					}
					else{
						echo "СНИЛС НЕПРАВИЛЬНЫЙ";
						$prov = 0;
					}
				}
				else{
					$w = $w % 101;
				}
			}
		}
		elseif(empty($snils)){
			null;
		}
		else{
			echo "Данный СНИЛС меньше номера допустимого для проверки";
		}
	}
?>