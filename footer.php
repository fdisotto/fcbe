<?php
global $messaggi;
?>

</div>
<!-- /#wrapper -->

<footer class="footer bg-dark">
    <?php if ( ! empty( trim( $messaggi[ 7 ] ) ) ): ?>
        <div class="row mb-4">
            <div class="col-12 text-center text-white">
                <?php echo html_entity_decode( $messaggi[ 7 ] ) ?>
            </div>
        </div>
    <?php endif ?>

    <div class="row">
        <div class="col-12 text-center">
            <ul class="list-group list-group-horizontal-md justify-content-center">
                <li class="list-group-item">
                    FantacalcioBazar Evolution <a href="licenza.php">Licenza GNU/GPL</a>
                </li>
                <li class="list-group-item">
                    Pagina generata in <?php echo number_format( microtime( true ) - $_SERVER[ "REQUEST_TIME_FLOAT" ], 5, '.', '' ); ?> secondi.
                </li>
                <li class="list-group-item">
                    Versione <?php echo file_get_contents( 'version.txt' ) ?>
                </li>
            </ul>
        </div>
    </div>
</footer>

<script src="./assets/vendor/jquery/jquery.min.js"></script>
<script src="./assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script src="./assets/vendor/datatables/datatables.min.js"></script>
<script src="./assets/vendor/datatables/DataTables-1.11.0/js/dataTables.bootstrap5.min.js"></script>
<script src="./assets/js/main.js"></script>
</body>
</html>
