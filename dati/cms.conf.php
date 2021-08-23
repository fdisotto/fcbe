<?php

$data_mod = time();
$archivio_dati = 'csvfile';                     # opzioni mysql o csvfile
$notizie_file = DATI_DIR . '/notizie_file.csv';
$pagine_file = DATI_DIR . '/pagine_file.csv';
$categorie_file = DATI_DIR . '/categorie_file.csv';
$sottocategorie_file = DATI_DIR . '/sottocategorie_file.csv';
$news_per_pagina = '3';
$n_ultime_notizie = '10';
$mostra_calendario = 'NO';
$mostra_gall_index = 'SI';
$commenti_fb = "NO";
$like_fb = "NO";    # solo se commenti == NO
$dim_comm_fb = "400";
