<?php

require_once("./dati/dati_gen.php");
require_once("./inc/funzioni.php");


echo "<div class='articolo_d'>";
if ($usa_cms == "SI") link_pagine_link(); 

	echo"<p align='center'>";
	immagine_casuale(top,0,0); 
	echo "</p></div>";

if ($usa_cms == "SI" AND $vedi_notizie == "2") echo "<div class='articolo_d'>".ultime_notizie('')."</div>"; 

if ($attiva_rss == "SI") {
	echo "<div class='articolo_d'><center><b><u>News Calcio</u></b></center><br/>";
	include_once("./inc/RssReader.class.php");

		if (!trim($url_rss)) $url_rss="http://www.gazzetta.it/rss/Calcio.xml"; //rss url
	
	$rsscontent = new RssReader();
	$rsscontent->cache_time = 1200; //set refresh time in second, 0 = disabilita
	$rsscontent->item_num = 5; //set item
	$rsscontent->Rss_Reader($url_rss);
}
echo "</div>";
?>
