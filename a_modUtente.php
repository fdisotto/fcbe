<?php
##################################################################################
#    FANTACALCIOBAZAR EVOLUTION
#    Copyright (C) 2003-2009 by Antonello Onida
#
#    This program is free software; you can redistribute it and/or modify
#    it under the terms of the GNU General Public License as published by
#    the Free Software Foundation; either version 2 of the License, or
#    (at your option) any later version.
#
#    This program is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU General Public License for more details.
#
#    You should have received a copy of the GNU General Public License
#    along with this program; if not, write to the Free Software
#    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
##################################################################################
require_once ("./controlla_pass.php");
include("./header.php");


if ($_SESSION['valido'] == "SI" and $_SESSION['permessi'] >= 0) {
	if ($_SESSION['permessi'] == 5) require ("./a_menu.php");
	elseif ($_SESSION['permessi'] <= 4) require ("./menu.php");

	$canc = strip_tags($_GET['canc']);
	$nomeimg = strip_tags($_GET['nomeimg']);

	if(file_exists($nomeimg) AND $canc == 'ok' ){
		unlink($nomeimg);
		echo "<div class='evidenziato'>Avatar cancellato!</div>";
	}
	unset($canc,$nomeimg);

	if(isset($_GET['cambia']) OR $_SESSION['permessi'] >= 4) $id = $_GET['cambia'];
	else $id = $_SESSION['uid'];

	if($id){

		if($_GET['go']){

			if ($_SESSION['permessi'] == 5) $id_torneo = $_GET['id_torneo'];
			else $id_torneo = $_SESSION['torneo'];

			if($id == 0) {
				echo "<center><h3>Impossibile modificare questo utente</h3></td></tr></table>";
				include("./footer.php");
				exit;
			}
			else {
				$percorso_file = $percorso_cartella_dati."/utenti_$id_torneo.php";

				$ofile = @file($percorso_file);
				@list($outente, $opass, $opermessi, $oemail, $ourl, $osquadra, $otorneo, $oserie, $ocitta, $ocrediti, $ovariazioni, $ocambi, $oreg, $otitolari, $opanchina, $onome, $ocognome, $ocassa, $otemp4, $otemp5, $otemp6, $otemp7, $otemp8, $otemp9, $otemp0) = explode("<del>", $ofile[$id]);


				if ($_SESSION['permessi'] < 4) {
					if ($outente != $_SESSION['utente'])  {
						echo "<center><h3>Impossibile modificare questo utente</h3></td></tr></table>";
						include("./footer.php");
						exit;
					}
				}

				if($_POST["ipass"]) $Npass = md5(strip_tags($_POST["ipass"]));
				else $Npass = $opass;

				if($_POST["ipermessi"] OR $_POST["ipermessi"] == "0") $Npermessi = $_POST["ipermessi"];
				else $Npermessi = $opermessi;

				if($_POST["iemail"]) $Nemail = strip_tags($_POST["iemail"]);
				else $Nemail = $oemail;

				$Nurl = strip_tags(trim($_POST["iurl"]));

				if($_POST["isquadra"]) $Nsquadra = strip_tags($_POST["isquadra"]);
				else $Nsquadra = $osquadra;

				if($_POST["inome"]) $Nnome = strip_tags($_POST["inome"]);
				else $Nnome = $onome;

				if($_POST["icognome"]) $Ncognome = strip_tags($_POST["icognome"]);
				else $Ncognome = $ocognome;

				if($_POST["icassa"])  $Ncassa = strip_tags($_POST["icassa"]);
				else $Ncassa = $ocassa;

				if($_POST["itorneo"]) $Ntorneo = strip_tags($_POST["itorneo"]);
				else $Ntorneo = $otorneo;

				if($_POST["iserie"]) $Nserie = strip_tags($_POST["iserie"]);
				else $Nserie = $oserie;

				$Ncitta = strip_tags(trim($_POST["icitta"]));

				if($_POST["icrediti"] or $_POST["icrediti"] == "0") $Ncrediti = $_POST["icrediti"];
				else $Ncrediti = "$ocrediti";

				if($_POST["ivariazioni"] or $_POST["ivariazioni"] == "0") $Nvariazioni = $_POST["ivariazioni"];
				else $Nvariazioni = "$ovariazioni";

				if($_POST["icambi"] or $_POST["icambi"] == "0") $Ncambi = $_POST["icambi"];
				else $Ncambi = "$ocambi";

				if($_POST["ilogo"]) $Nlogo = strip_tags($_POST["ilogo"]);
				else $Nlogo = $ologo;

				if (!preg_match("/^[a-z0-9][_\.a-z0-9-]+@([a-z0-9][0-9a-z-]+\.)+([a-z]{2,4})/",$_POST['iemail']))
				$err[] = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- email non corretta";

				if (($_POST["ipass"]!="")&&(!preg_match("/^[a-zA-Z0-9]{4,10}/",$_POST["ipass"])))
				$err[] = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- password non corretta";

				if ($ipass!==$ipass2)
				$err[]="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- le password non coincidono";

				if ($iemail!==$iemail2)
				$err[]="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- le email non coincidono";


				if(!empty($err)){
					$tr=implode("</td></tr><tr><td>",$err);

					echo "
					<table summary='Modifica utente' width='100%' cellpadding = '3' align = 'center' bgcolor='$sfondo_tab'>
					<caption>Modifica utente</caption>
					<tr><td><center><h2>Errori in fase di modifica</h2></center>
					<br/><br/><br/>$tr</td></tr>
					<tr><td><br/><br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='#' onclick='history.go(-1)'>torna al modulo di modifica</a>
					</td></tr></table>";
					unset($err,$tr);
					}else{ // nn ci sono errori
						$stringa = "$outente<del>$Npass<del>$Npermessi<del>$Nemail<del>$Nurl<del>$Nsquadra<del>$Ntorneo<del>$Nserie<del>$Ncitta<del>$Ncrediti<del>$Nvariazioni<del>$Ncambi<del>$oreg<del>$otitolari<del>$opanchina<del>$Nnome<del>$Ncognome<del>$Ncassa<del>$otemp4<del>$otemp5<del>$otemp6<del>$otemp7<del>$otemp8<del>$otemp9<del>$otemp0";

						$ofile[$id] = $stringa;
						$nuovo_file = implode("",$ofile);

						$fp = fopen($percorso_file, "wb+");
						flock($fp, LOCK_EX);
						fwrite($fp, $nuovo_file);
						flock($fp, LOCK_UN);
						fclose($fp);
						echo "<table summary='Modifica utente' bgcolor='$sfondo_tab' cellpadding = '5' width = '100%' align = 'center'>
						<caption>Modifica utente</caption>
						<tr><td align = 'center'><font size='+1'>Utente <u>$outente</u> modificato</font></td></tr>
						<tr><td align = 'center'>Le modifiche effettuate saranno funzionali da subito ma visualizzate al prossimo accesso!</td></tr></table>";
						include("./footer.php");
						exit;
					}
				}
			}
			else {

				if ($_SESSION['permessi'] == 5) $id_torneo = $_GET['itorneo'];
				else $id_torneo = $_SESSION['torneo'];

				if($id == 0) {
					echo "<center><h3>Impossibile modificare questo utente</h3></td></tr></table>";
					include("./footer.php");
					exit;
				}

				$percorso_file = $percorso_cartella_dati."/utenti_".$id_torneo.".php";

				$ifile = file($percorso_file);
				@list($iutente, $ipass, $ipermessi, $iemail, $iurl, $isquadra, $itorneo, $iserie, $icitta, $icrediti, $ivariazioni, $icambi, $ireg, $ititolari, $ipanchina, $inome, $icognome, $icassa, $itemp4, , $itemp5, $itemp6, $itemp7, $itemp8, $itemp9, $itemp0) = explode("<del>", trim($ifile[$id]));

				if ($_SESSION['permessi'] < 4) {
					if ( $iutente != $_SESSION['utente'])  {
						echo "<center><h3>Impossibile modificare questo utente</h3></td></tr></table>";
						include("./footer.php");
						exit;
					}
				}

				$vedi_tornei_attivi = "<select name='itorneo' DISABLED>";
				$tornei = @file($percorso_cartella_dati."/tornei.php");
				$linee = count($tornei);
				$num_tornei = 0;
				for($num1 = 0; $num1 < $linee; $num1++){
					$num_tornei++;
				}

				for ($num1 = 1 ; $num1 < $num_tornei; $num1++) {
					@list($tid, $tdenom, $tpart, $tserie) = explode(",", $tornei[$num1]);
					$tdenom = preg_replace("/'/","",$tdenom);

					if ($itorneo == $tid) $vedi_tornei_attivi .= "<option value='$tid' selected>$tdenom</option>";
					else $vedi_tornei_attivi .= "<option value='$tid'>$tdenom</option>";

				} # fine for $num1

				$vedi_tornei_attivi .= "</select>";

				$vedi_serie = "<select name='iserie' DISABLED>";
				$vedi_serie .= "<option value='$tid' selected>$iserie</option>";
				$vedi_serie .= "</select>";


				?>
				<form method = "post" action = "<?php print($_SERVER['PHP_SELF']. '?cambia='.$id.'&amp;id_torneo='.$id_torneo.'&amp;go=1'); ?>">
					<table summary="Modifica utente" width="100%" bgcolor= "<?php echo "$sfondo_tab"; ?>" cellpadding = "5" align = "center">
						<caption>Modifica i dettagli della squadra di <u><?php echo $iutente; ?></u></caption>
						<tr align="left">
							<td width = "30%" valign = "bottom">Nome Cognome</td>
							<td width = "70%" valign = "bottom">
							<input type = "text" name = "inome" value = "<?php echo $inome; ?>" />
							<input type = "text" name = "icognome" value = "<?php echo $icognome; ?>" /></td>
						</tr>
						<tr align="left">
							<td width = "30%" valign = "bottom">password:</td>
							<td width = "70%" valign = "bottom">
							<input type = "password" name = "ipass" size = "13" maxlength = "12" /></td>
						</tr>
						<tr align="left">
							<td width = "30%" valign = "bottom">conferma password:</td>
							<td width = "70%" valign = "bottom">
							<input type = "password" name = "ipass2" size = "13" maxlength = "12" /></td>
						</tr>
						<tr align="left">
							<td width = "30%" valign = "bottom">permessi (-1, 0, 1, 2, 3, 4, 5):</td>
							<td width = "70%" valign = "bottom">

								<?php
								$_SESSION['utente_sel']=$iutente;
								if ($_SESSION['permessi'] >= 4) echo "<select name='ipermessi'>";
								else echo "<select name='ipermessi' DISABLED>";

								if ($ipermessi == "-1") echo "<option value='-1' SELECTED> -1 </option>";
								else echo "<option value='-1'> -1 </option>";

								if ($ipermessi == "0") echo "<option value='0' SELECTED> 0 </option>";
								else echo "<option value='0'> 0 </option>";

								if ($ipermessi == "1") echo "<option value='1' SELECTED> 1 </option>";
								else echo "<option value='1'> 1 </option>";

								if ($ipermessi == "2") echo "<option value='2' SELECTED> 2 </option>";
								else echo "<option value='2'> 2 </option>";

								if ($ipermessi == "3") echo "<option value='3' SELECTED> 3 </option>";
								else echo "<option value='3'> 3 </option>";

								if ($ipermessi == "4") echo "<option value='4' SELECTED> 4 </option>";
								else echo "<option value='4'> 4 </option>";

								if ($_SESSION['permessi'] == 5){
									if ($ipermessi == "5") echo "<option value='5' SELECTED> 5 </option>";
									else echo "<option value='5'> 5 </option>";
								}
								?>
							</select>
						</tr>
						<tr align="left">
							<td width = "30%" valign = "bottom">email:</td>
							<td width = "70%" valign = "bottom">
							<input type = "text" name = "iemail" value = "<?php echo $iemail; ?>" /></td>
						</tr>
						<tr align="left">
							<td width = "30%" valign = "bottom">conferma email:</td>
							<td width = "70%" valign = "bottom">
							<input type = "text" name = "iemail2" value = "<?php echo $iemail; ?>" /></td>
						</tr>
						<tr align="left">
							<td width = "30%" valign = "bottom">Sito web</td>
							<td width = "70%" valign = "bottom">
							<input type = "text" name = "iurl" value = "<?php if ($iurl) echo "$iurl";?>" /></td>
						</tr>
						<?php

						if ($consenti_logo == "SI" AND $_SESSION['permessi'] <= 4) {
							echo "<tr align='left'>
							<td width = '30%' valign = 'bottom'>Logo squadra<br/></td>
							<td width = '70%' valign = 'bottom'>";

							if (file_exists("./immagini/loghi/".$_SESSION['utente'].".jpg")) $nomeimg = "./immagini/loghi/".$_SESSION['utente'].".jpg";
							if (file_exists("./immagini/loghi/".$_SESSION['utente'].".gif")) $nomeimg = "./immagini/loghi/".$_SESSION['utente'].".gif";


							if(file_exists("$nomeimg")){
								echo "<img src='$nomeimg' border='1' /> - <a href='./a_modUtente.php?cambia=".$_SESSION['uid']."&amp;canc=ok&amp;nomeimg=$nomeimg'>Cancella logo</a>";
							}
							else {
								echo "Avatar non presente - <a href='logo_upload.php'>Caricane uno!</a></td>";
							}
							echo"</tr>";
						}
						elseif ($consenti_logo == "SI"){
							echo "<tr align='left'>
							<td width = '30%' valign = 'bottom'>Logo squadra<br/></td>
							<td width = '70%' valign = 'bottom'>";

							if (file_exists("./immagini/loghi/".$iutente.".jpg")) $nomeimg = "./immagini/loghi/".$iutente.".jpg";
							if (file_exists("./immagini/loghi/".$iutente.".gif")) $nomeimg = "./immagini/loghi/".$iutente.".gif";

							if(file_exists($nomeimg)){
								echo"<img src='$nomeimg' border='0' alt='Logo utente' />
								<a href='./a_modUtente.php?cambia=".$id."&amp;canc=ok&amp;nomeimg=$nomeimg'>Cancella logo</a></td>";
							}
							else {
								echo "Avatar non presente - <a href='logo_upload.php'>Caricane uno!</a></td>";
							}
							echo"</tr>";
						}
						else echo "<tr align='left'>
						<td width = '30%' valign = 'bottom'>Logo squadra<br/></td>
						<td width = '70%' valign = 'bottom'>DISABILITATO</td></tr>";

						if ($_SESSION['permessi'] >= 3) echo "<tr align='left'>
						<td width = '30%' valign = 'bottom'>squadra:</td>
						<td width = '70%' valign = 'bottom'>
						<input type = 'text' name = 'isquadra' value = '$isquadra'></td>
						</tr>";
						else echo "<input type = 'hidden' name = 'isquadra' value = '$isquadra'>";
						?>
						<tr align="left">
							<td width = "30%" valign = "bottom"><a href="./vedi_tornei.php">Visiona e scegli un torneo</a></td>
							<td width = "70%" valign = "bottom"><?php echo $vedi_tornei_attivi ?></td>
						</tr>
						<tr align="left">
							<td width = "30%" valign = "bottom">serie:<br/>attualmente non implementato!</td>
							<td width = "70%" valign = "bottom"><?php echo $vedi_serie ?></td>
						</tr>
						<tr align="left">
							<td width = "30%" valign = "bottom">citt&agrave;:</td>
							<td width = "70%" valign = "bottom">
							<input type = "text" name = "icitta" value = "<?php echo $icitta ?>" /></td>
						</tr>
						<?php
						if ($_SESSION['permessi'] >= 4) {echo "<tr align='left'>
						<td width = '30%' valign = 'bottom'>crediti:</td>
						<td width = '70%' valign = 'bottom'>
						<input type = 'text' name = 'icrediti' value = '$icrediti' size = '4' maxlength = '4' /></td>
						</tr>
						<tr align='left'>
						<td width = '30%' valign = 'bottom'>variazioni:</td>
						<td width = '70%' valign = 'bottom'>
						<input type = 'text' name = 'ivariazioni' value = '$ivariazioni' size = '4' maxlength = '4' /></td>
						</tr>
						<tr align='left'>
						<td width = '30%' valign = 'bottom'>cambi:</td>
						<td width = '70%' valign = 'bottom'>
						<input type = 'text' name = 'icambi' value = '$icambi' size = '3' maxlength = '3' /></td>
						</tr>												
						<tr align='left'>
						<td width = '30%' valign = 'bottom'>cassa:</td>
						<td width = '70%' valign = 'bottom'>
						<input type = 'text' name = 'icassa' value = '$icassa' size = '4' maxlength = '4' /></td>
						</tr>";}
						elseif ($_SESSION['permessi'] == 5) {echo "
						
						<input type = 'hidden' name = 'ipermessi' value = '$ipermessi' />
						<input type = 'hidden' name = 'icrediti' value = '$icrediti' />
						<input type = 'hidden' name = 'ivariazioni' value = '$ivariazioni' />
						<input type = 'hidden' name = 'icassa' value = '$icassa' />
						<input type = 'hidden' name = 'icambi' value = '$icambi' />
						<input type = 'hidden' name = 'ititolari' value = '$ititolari' />
						<input type = 'hidden' name = 'ipanchinari' value = '$ipanchinari' />
						<input type = 'hidden' name = 'itemp3' value = '$itemp3' />
						<input type = 'hidden' name = 'itemp4' value = '$itemp4' />
						<input type = 'hidden' name = 'itemp5' value = '$itemp5' />
						<input type = 'hidden' name = 'itemp6' value = '$itemp6' />
						<input type = 'hidden' name = 'itemp7' value = '$itemp7' />
						<input type = 'hidden' name = 'itemp8' value = '$itemp8' />
						<input type = 'hidden' name = 'itemp9' value = '$itemp9' />
						<input type = 'hidden' name = 'itemp0' value = '$itemp0' />";}
						?>
						<tr align="left">
							<td width = "30%" valign = "bottom">conferma e registra:</td>
							<td width = "70%" valign = "bottom">
							<input type = "Image" src = "immagini/next.gif" name = "submit" alt = "Procedi con la modifica" align = "top" /></td>
						</tr>
					</table>
				</form>
			</td></tr></table>

			<?php
		}
	}
	else {
		?>
		<table summary='Modifica utente' bgcolor= "<?php echo "$sfondo_tab"; ?>" cellpadding = "10" width = "100%" align = "center">
			<caption>Modifica utente</caption>
			<tr>
				<td valign = "top" style = "border: 3px double #888888;">
					<?php
					if ($_SESSION['permessi'] == 5) $percorso_file = $percorso_cartella_dati."/utenti_$itorneo.php";
					else $percorso_file = $percorso_cartella_dati."/utenti_".$_SESSION['torneo'].".php";

					$ofile = file($percorso_file);
					$linee = count($ofile);
					for($linea = 1; $linea < $linee; $linea++){
						@list($outente, $opass, $opermessi, $oemail, $ourl, $osquadra, $otorneo, $oserie, $ocitta, $ocrediti, $ovariazioni, $ocambi, $oreg, $otitolari, $opanchina, $onome, $ocognome, $ocassa, $otemp4, $otemp5, $otemp6, $otemp7, $otemp8, $otemp9, $otemp0) = explode("<del>", trim($ofile[$linea]));

						$stringa = "<a href = 'a_modUtente.php?cambia=".$linea."' class='user'>".$outente." </a><br/>";
						$stringa .= "nome: ".$onome. "<br/>";
						$stringa .= "cognome: ".$ocognome. "<br/>";
						$stringa .= "password (md5()): ".$opassword. "<br/>";
						$stringa .= "permessi: ". $opermessi. "<br/>";
						$stringa .= "email: ". $oemail. "<br/>";
						$stringa .= "url: ". $ourl. "<br/>";
						$stringa .= "logo: ". $ologo. "<br/>";
						$stringa .= "squadra: ". $osquadra. "<br/>";
						$stringa .= "id torneo: ". $otorneo. "<br/>";
						$stringa .= "id serie: ". $oserie. "<br/>";
						$stringa .= "citt&agrave;: ". $ocitta. "<br/>";
						$stringa .= "crediti: ". $ocrediti. "<br/>";
						$stringa .= "variazioni: ". $ovariazioni. "<br/>";
						$stringa .= "cassa: ". $ocassa. "<br/>";
						$stringa .= "cambi: ". $ocambi. "<br/>";
						$stringa .= "registrato dal: ". $oreg. "<br/><br/>";
						echo $stringa;
					}
					?>
				</td>
			</tr>
		</table>
		<?php
	}
}
else header("location: index.php?fallito=1");
include("./footer.php");
?>
