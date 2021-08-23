</td></tr></table>

<div id="whiteline"></div>

<div id="links"><?php echo html_entity_decode( $messaggi[ 6 ] ) ?></div>

<div align="center">


</div>

<div id="footer">
    <p align="center">
        <img src="immagini/separator.gif" alt="|"/> FantacalcioBazar Evolution <a href="licenza.php">Licenza GNU/GPL</a>
        <img src="immagini/separator.gif" alt="|"/> Pagina generata in <?php echo number_format( microtime( true ) - $_SERVER[ "REQUEST_TIME_FLOAT" ], 5, '.', '' ); ?> secondi.
        <img src="immagini/separator.gif" alt="|"/> Versione <?php echo file_get_contents( ROOT_DIR . '/version.txt' ) ?>
        <img src="immagini/separator.gif" alt="|"/> <?php if ( isset( $vvm ) )
            echo "<span style=\"color: #EEEEEE; \">$vvm</span>"; ?>
    </p>
</div>
</body>
</html>
