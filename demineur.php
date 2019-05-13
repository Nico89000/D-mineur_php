<?php


if(empty($_POST))
{
	echo '<form method="POST" action="demineur.php"><p><label for="nbbombe">Choisisser le nombre de bombes :</label><input required type="number" name="nbbombe" id="nbbombe" placeholder="Nombre de Bombes" step="1" min="1" max="479"></p><p><input  type="submit" value="Jouer"/></p></form>';
}
else if(empty($_POST['essais']))
{
	$nbBombes=$_POST["nbbombe"];
	$Mines=array();
	for ($k=0; $k<$nbBombes; $k++)
	{
		$randi=rand(1,16);
		$randj=rand(1,30);
		$tabRand=array($randi,$randj);
		$dejafait=false;
		foreach ($Mines as $key => $value) 
		{
			if ($tabRand==$value) 
			{
				$dejafait=true;
				break;
			}
		}
		if ($dejafait==true) 
		{
			$k--;
		}
		else
		{
			$Mines[$k]=$tabRand;
		}
		
	}

	$placeBombes="";

	echo '<table style="border-collapse:collapse;text-align:center">';
	for ($i=0; $i <17 ; $i++) 
	{ 
		echo "<tr>";
		for ($j=0; $j <31; $j++) 
		{ 
			if ($i==0 && $j==0)
			{
				$tableau[$i][$j]="x";
				echo '<td style="border:1px solid black">'.$tableau[$i][$j]."</td>";
			}
			else if ($i==0)
			{
				$tableau[$i][$j]=$j;
				echo '<td style="border:1px solid black">'.$tableau[$i][$j]."</td>";
			}
			else if ($j==0)
			{
				$tableau[$i][$j]=$i;
				echo '<td style="border:1px solid black">'.$tableau[$i][$j]."</td>";
			}
			else
			{
				$mine=false;
				foreach ($Mines as $key => $value) 
				{
					$temp=array($i,$j);
					if ($temp==$value) 
					{
						$mine=true;
						break;
					}
				}

				if ($mine==true) 
				{
					echo '<td style="border:1px solid black;background-color:darkgrey;color:lightgrey; height:30px;width:30px"></td>';
					$placeBombes.="x";
				}
				else
				{
					echo '<td style="border:1px solid black;background-color:darkgrey;color:darkgrey; height:30px;width:30px"></td>';
					$placeBombes.="+";
				}
			}	
		}
		// if ($i!=0)
		// {
		// 	$placeBombes.="/";
		// }
		
		echo "</tr>";
	}
	echo "</table>";


	echo '<form method="POST" action="demineur.php"><p><label for="ligne">Choisisser la ligne (max=16) :</label><input required type="number" name="ligne" id="ligne" placeholder="Nb ligne" step="1"  min="1" max="16"></p><p><label for="colonne">Choisisser la Colonne (max=30) :</label><input required type="number" name="colonne" id="colonne" placeholder="Nb colonne" step="1" min="1" max="30"></p><p><input  type="submit" value="Jouer"/></p><input type="textarea" hidden " name="placeBombe" value="'.$placeBombes.'"><input type="textarea" hidden " name="essais" value="1"></form><form method="POST" action="demineur.php"><p><input  type="submit" value="Recommencer"/></p></form>';
	
}
else
{

	$Mines=array();
	$placeBombes="";
// strlen($_POST['placeBombe'])
	for ($i=1; $i<17; $i++) 
	{ 
		for ($j=1; $j <31 ; $j++) 
		{ 
			$start=$j-1+30*($i-1);
			$Mines[$i][$j]=substr($_POST['placeBombe'], $start,1);
		}
	}

	if($Mines[($_POST['ligne'])][($_POST['colonne'])]=="x")
	{
		echo '<p>Dommage, vous vous êtes explosé dans une bombe ! Vous avez donc perdu !! C’est la piquette Jack... Tu sais pas jouer Jack ! T’es mauvais ! </p><div><form method="GET" action="demineur.php"><p><input  type="submit" value="Recommencer"/></p></form><div>';
	}
	else
	{
		$Mines[($_POST['ligne'])][($_POST['colonne'])]="o";
		echo '<table style="border-collapse:collapse;text-align:center">';
	for ($i=0; $i <17 ; $i++) 
	{ 
		echo "<tr>";
		for ($j=0; $j <31; $j++) 
		{ 
			if ($i==0 && $j==0)
			{
				$tableau[$i][$j]="x";
				echo '<td style="border:1px solid black">'.$tableau[$i][$j]."</td>";
			}
			else if ($i==0)
			{
				$tableau[$i][$j]=$j;
				echo '<td style="border:1px solid black">'.$tableau[$i][$j]."</td>";
			}
			else if ($j==0)
			{
				$tableau[$i][$j]=$i;
				echo '<td style="border:1px solid black">'.$tableau[$i][$j]."</td>";
			}
			else
			{
				if ($Mines[$i][$j]=="x") 
				{
					echo '<td style="border:1px solid black;background-color:darkgrey;color:lightgrey; height:30px;width:30px"></td>';
					$placeBombes.="x";
				}
				elseif ($Mines[$i][$j]=="+") 
				{
					echo '<td style="border:1px solid black;background-color:darkgrey;color:darkgrey; height:30px;width:30px"></td>';
					$placeBombes.="+";
				}
				elseif ($Mines[$i][$j]=="o") 
				{
					$nbBombesProch=0;

					if($i>1&&$j>1)
					{
						if ($Mines[$i-1][$j-1]=="x") 
						{
							$nbBombesProch++;
						}
					}
					if($j>1)
					{
						if ($Mines[$i][$j-1]=="x") 
						{
							$nbBombesProch++;
						}
					}
					
					if($i>1)
					{
						if ($Mines[$i-1][$j]=="x") 
						{
							$nbBombesProch++;
						}
					}

					if($i<16&&$j<30)
					{
						if ($Mines[$i+1][$j+1]=="x") 
						{
							$nbBombesProch++;
						}
					}

					if($i<16&&$j>1)
					{
						if ($Mines[$i+1][$j-1]=="x") 
						{
							$nbBombesProch++;
						}
					}

					if($i>1&&$j<30)
					{
						if ($Mines[$i-1][$j+1]=="x") 
						{
							$nbBombesProch++;
						}
					}

					if($j<30)
					{
						if ($Mines[$i][$j+1]=="x") 
						{
							$nbBombesProch++;
						}
					}

					if($i<16)
					{
						if ($Mines[$i+1][$j]=="x") 
						{
							$nbBombesProch++;
						}
					}

					if($nbBombesProch==0)
					{
						echo '<td style="border:1px solid black;background-color:#efefef;color:#f8f8f8; height:30px;width:30px"></td>';
					}
					elseif($nbBombesProch==1)
					{
						echo '<td style="border:1px solid black;background-color:#efefef;color:green; height:30px;width:30px">'.$nbBombesProch.'</td>';
					}
					elseif($nbBombesProch==2)
					{
						echo '<td style="border:1px solid black;background-color:#efefef;color:blue; height:30px;width:30px">'.$nbBombesProch.'</td>';
					}
					elseif($nbBombesProch==3)
					{
						echo '<td style="border:1px solid black;background-color:#efefef;color:#0080ff; height:30px;width:30px">'.$nbBombesProch.'</td>';
					}
					elseif($nbBombesProch==4)
					{
						echo '<td style="border:1px solid black;background-color:#efefef;color:aqua; height:30px;width:30px">'.$nbBombesProch.'</td>';
					}
					elseif($nbBombesProch==5)
					{
						echo '<td style="border:1px solid black;background-color:#efefef;color:purple; height:30px;width:30px">'.$nbBombesProch.'</td>';
					}
					elseif($nbBombesProch==6)
					{
						echo '<td style="border:1px solid black;background-color:#efefef;color:fuchsia; height:30px;width:30px">'.$nbBombesProch.'</td>';
					}
					elseif($nbBombesProch==7)
					{
						echo '<td style="border:1px solid black;background-color:#efefef;color:#ff80; height:30px;width:30px">'.$nbBombesProch.'</td>';
					}
					elseif($nbBombesProch==8)
					{
						echo '<td style="border:1px solid black;background-color:#efefef;color:#ff0000; height:30px;width:30px">'.$nbBombesProch.'</td>';
					}





					
					$placeBombes.="o";
				}
			}	
		}
		// if ($i!=0)
		// {
		// 	$placeBombes.="/";
		// }
		
		echo "</tr>";
	}
	echo "</table>";



	echo '<form method="POST" action="demineur.php"><p><label for="ligne">Choisisser la ligne (max=16) :</label><input required type="number" name="ligne" id="ligne" placeholder="Nb ligne" step="1"  min="1" max="16"></p><p><label for="colonne">Choisisser la Colonne (max=30) :</label><input required type="number" name="colonne" id="colonne" placeholder="Nb colonne" step="1" min="1" max="30"></p><p><input  type="submit" value="Jouer"/></p><input type="textarea" hidden " name="placeBombe" value="'.$placeBombes.'"><input type="textarea" hidden " name="essais" value="'.($_POST['essais']+1).'"></form><form method="POST" action="demineur.php"><p><input  type="submit" value="Recommencer"/></p></form>';
	
	}

	
	
}






	


?>