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

# Menu amministrazione

if ($_SESSION['permessi'] == 5) {
	echo "<div class='testa1' style='padding:3px; margin: 1px'>G E S T I O N E</div>
	<div class='menu_s' style='text-align:left; background-color: $sfondo_tab3; color: $carattere_colore_chiaro'>
	<a href='./a_gestione.php'>Pannello iniziale</a>
	<a href='./a_configura.php'>Configurazione</a>
	<a href='./a_torneo.php'>Gestione tornei</a>
	<a href='./a_aggUtente.php'>Aggiungi utenti</a>
	<a href='./a_appUtente.php'>Approvazione utenti</a>
	<a href='./a_verifiche.php'>Verifiche TODO</a>
	<a href='./logout.php'>Disconnessione</a>
	</div>
	<div class='testa1' style='padding:3px; margin: 1px'>V O T I</div>
	<div class='menu_s' style='text-align:left; background-color: $sfondo_tab3; color: $carattere_colore_chiaro'>
	<a href='./a_upload.php'>Upload voti</a>
	<a href='./a_invia_voti.php'>Invia formazioni</a>
	<a href='./a_invia_risultati.php'>Invia risultati</a>
	</div>
	<div class='testa1' style='padding:3px; margin: 1px'>C O N T E N U T I</div>
	<div class='menu_s' style='text-align:left; background-color: $sfondo_tab3; color: $carattere_colore_chiaro'>
	<a href='./a_sito.php'>Gestione CMS</a>
	<a href='./a_testi.php'>Gestione testi</a>
	<a href='./messaggi.php'>Gestione messaggi</a>
	<a href='./a_nlUtente.php'>Newsletter a utenti</a>
	<a href='./a_crea_sondaggio.php'>Sondaggi e votazioni</a>
	<a href='javascript:void(0)' onclick='window.open(\"chat.php?utente=".$_SESSION['utente']."\",\"CHAT\",\"width=526,height=380,left=150,top=150,status=no,toolbar=no,menubar=no,location=no\");'>Chat</a> 
	</div>
	<div class='testa1' style='padding:3px; margin: 1px'>O F F I C I N A</div>
	<div class='menu_s' style='text-align:left; background-color: $sfondo_tab3; color: $carattere_colore_chiaro'>
	<a href='./a_fm.php'>File manager</a>
	<a href='./a_backup.php'>Backup dati</a>
	<a href='./a_b2mail.php'>Backup per mail</a>
	<a href='./a_edita_file.php?mod_file=$percorso_cartella_dati/cms.conf.php'>Config CMS</a>
	</div>
	</td><td valign='top' width='80%' align='center'>";
}
