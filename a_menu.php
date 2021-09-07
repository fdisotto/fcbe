<?php

?>

<?php

use FCBE\Util\Utenti;

$current_url = basename( $_SERVER[ "SCRIPT_FILENAME" ], '.php' );
?>

<?php if ( Utenti::isAdminLogged() ): ?>

    <nav id="sidebar-wrapper" class="bg-dark p-4 d-md-block d-none">

        <ul class="sidebar-nav nav-pills nav-stacked" id="menu">
            <li class="nav-item border-bottom">
                <span class="fs-4 text-uppercase menu-title text-white d-flex justify-content-end">gestione</span>
            </li>

            <li class="nav-item">
                <a href="./a_gestione.php" class="nav-link text-white <?php echo $current_url == "a_gestione" ? "active" : "" ?>">Pannello iniziale</a>
            </li>
            <li class="nav-item">
                <a href="./a_configura.php" class="nav-link text-white <?php echo $current_url == "a_configura" ? "active" : "" ?>">Configurazione</a>
            </li>
            <li class="nav-item">
                <a href="./a_torneo.php" class="nav-link text-white <?php echo $current_url == "a_torneo" ? "active" : "" ?>">Gestione tornei</a>
            </li>
            <li class="nav-item">
                <a href="./a_aggUtente.php" class="nav-link text-white <?php echo $current_url == "a_aggUtente" ? "active" : "" ?>">Aggiungi utenti</a>
            </li>
            <li class="nav-item">
                <a href="./a_appUtente.php" class="nav-link text-white <?php echo $current_url == "a_appUtente" ? "active" : "" ?>">Approvazione utenti</a>
            </li>

            <li class="nav-item border-bottom mt-3">
                <span class="fs-4 text-uppercase text-center menu-title text-white d-flex justify-content-end">voti</span>
            </li>

            <li class="nav-item">
                <a href="./a_upload.php" class="nav-link text-white">Upload voti</a>
            </li>
            <!--<li class="nav-item">
                <a href="./a_invia_voti.php" class="nav-link text-white">Invia formazioni</a>
            </li>
            <li class="nav-item">
                <a href="./a_invia_risultati.php" class="nav-link text-white">Invia risultati</a>
            </li>-->

            <li class="nav-item border-bottom mt-3">
                <span class="fs-4 text-uppercase text-center menu-title text-white d-flex justify-content-end">contenuti</span>
            </li>

            <li class="nav-item">
                <a href="./a_sito.php" class="nav-link text-white">Gestione CMS</a>
            </li>
            <li class="nav-item">
                <a href="./a_testi.php" class="nav-link text-white">Gestione testi</a>
            </li>
            <li class="nav-item">
                <a href="./messaggi.php" class="nav-link text-white">Gestione messaggi</a>
            </li>
            <li class="nav-item">
                <a href="./a_nlUtente.php" class="nav-link text-white">Newsletter a utenti</a>
            </li>
            <li class="nav-item">
                <a href="./a_crea_sondaggio.php" class="nav-link text-white">Sondaggi e votazioni</a>
            </li>

            <li class="nav-item border-bottom mt-3">
                <span class="fs-4 text-uppercase text-center menu-title text-white d-flex justify-content-end">officina</span>
            </li>

            <li class="nav-item">
                <a href="./a_fm.php" class="nav-link text-white">File manager</a>
            </li>
            <li class="nav-item">
                <a href="./a_backup.php" class="nav-link text-white">Backup dati</a>
            </li>
            <li class="nav-item">
                <a href="./a_b2mail.php" class="nav-link text-white">Backup per mail</a>
            </li>
        </ul>
    </nav>
<?php endif ?>
