<?php

require_once "./controlla_pass.php";
require_once "./inc/funzioni.php";
require_once "./header.php";
?>


    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php
                const FM_EMBED = true;
                define( 'FM_SELF_URL', $_SERVER[ 'PHP_SELF' ] );
                include "./filemanager/fm.php";
                ?>
            </div>
        </div>
    </div>

<?php
require_once "./footer.php";
