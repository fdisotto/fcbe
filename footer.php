<?php
# Rimuovere i crediti &egrave; considerata dalla comunit� open-source un delitto contro la comunit� stessa.
$start_clock = explode(" ", $clock[0]);
$start_time = $start_clock[1] + $start_clock[2];
$total_time = 0;
$clock[] = "Fine " . microtime();
foreach ($clock as $single_clock) {
    $single_clock_arr = explode(" ", $single_clock);
    $single_time = $single_clock_arr[1] + $single_clock_arr[2] - $start_time;
    $start_time = $start_time + $single_time;
    $total_time = $total_time + $single_time;
    $total_time = round($total_time, 3);
}
?>
</td></tr></table>

<div id="whiteline"></div>

<div id="links"><?php echo html_entity_decode($messaggi[6]) ?></div>

<div align="center">


</div>

<div id="footer">
    <p align="center">
        <img src="immagini/separator.gif" alt="|"/> FantacalcioBazar Evolution <a href="licenza.php">Licenza GNU/GPL</a>
        <img src="immagini/separator.gif" alt="|"/> Pagina generata in <?php echo $total_time ?> secondi.
        <img src="immagini/separator.gif" alt="|"/> Versione <?php echo file_get_contents('version.txt') ?>.
        <img src="immagini/separator.gif" alt="|"/> <?php if (isset($vvm)) echo "<font color ='#EEEEEE'>$vvm</font>"; ?>
    </p>
</div>
</body>
</html>