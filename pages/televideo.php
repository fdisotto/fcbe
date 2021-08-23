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

require_once "./dati/dati_gen.php";
require_once "./inc/funzioni.php";
require_once "./header.php";

if ( ! isset( $_GET[ 'telev' ] ) || ! $_GET[ 'telev' ] )
    $telev = "200"; else $telev = $_GET[ 'telev' ];
if ( ! isset( $_GET[ 'sottop' ] ) || ! $_GET[ 'sottop' ] )
    $sottop = "";
if ( isset( $_POST[ 'invio' ] ) && $_POST[ 'invio' ] == "Precedente" )
    $telev = $telev - 1;
if ( isset( $_POST[ 'invio' ] ) && $_POST[ 'invio' ] == "Successiva" )
    $telev = $telev + 1;

if ( $sottop == "" )
    $lnkimage = "https://www.televideo.rai.it/televideo/pub/tt4web/Nazionale/page-" . $telev . ".png"; else
    $lnkimage = "https://www.televideo.rai.it/televideo/pub/tt4web/Nazionale/page-" . $telev . "." . $sottop . ".png";

if ( ! @fopen( $lnkimage, "r" ) ) {
    $errore = "URL: $lnkimage non trovata";
    if ( $sottop == "" ) {
        $lnkimage = "https://www.televideo.rai.it/televideo/pub/tt4web/Nazionale/page-" . $telev . ".png";
        $sottop = "";
    } elseif ( $sottop != "" ) {
        $sottop = "2";
        $lnkimage = "https://www.televideo.rai.it/televideo/pub/tt4web/Nazionale/page-" . $telev . "." . $sottop . ".png";
    } else
        $lnkimage = "https://www.televideo.rai.it/televideo/pub/tt4web/Nazionale/page-100.png";
}

$tp = $telev - 1;
$ts = $telev + 1;

echo "<table align='center' cellpadding='5' cellspacing='10' width='100%'>
<tr><td bgcolor='black' align='center' valign='middle'>
<img SRC='$lnkimage' hspace='5' vspace='5' alt='Televideo RAI' /></td>
<td align='center' valign='middle'>
<a href='televideo.php?telev=230'>Atalanta</a> <br />
<a href='televideo.php?telev=231'>Bologna</a><br />
<a href='televideo.php?telev=232'>Cagliari</a> <br />
<a href='televideo.php?telev=233'>Empoli</a> <br />
<a href='televideo.php?telev=234'>Fiorentina</a> <br />
<a href='televideo.php?telev=235'>Genoa</a> <br />
<a href='televideo.php?telev=236'>H. Verona</a> <br />
<a href='televideo.php?telev=237'>Inter</a> <br />
<a href='televideo.php?telev=238'>Juventus</a> <br />
<a href='televideo.php?telev=239'>Lazio</a> <br />
<a href='televideo.php?telev=240'>Milan</a> <br />
<a href='televideo.php?telev=241'>Napoli</a> <br />
<a href='televideo.php?telev=242'>Roma</a> <br />
<a href='televideo.php?telev=243'>Salernitana</a> <br />
<a href='televideo.php?telev=244'>Samp</a> <br />
<a href='televideo.php?telev=245'>Sassuolo</a> <br />
<a href='televideo.php?telev=246'>Spezia</a> <br />
<a href='televideo.php?telev=247'>Torino</a> <br />
<a href='televideo.php?telev=248'>Udinese</a> <br />
<a href='televideo.php?telev=249'>Venezia</a> <br /> <br />
<br/>
<a href='televideo.php?telev=229'>Brevi calcio</a> <br />
<br/>
<a href='televideo.php?telev=200'>Indice</a> <br />
</td></tr></table></form>";

require_once "./footer.php";
