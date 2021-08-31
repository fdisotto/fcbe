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
use FCBE\Util\Configurazione;
use FCBE\Util\Flash;
use FCBE\Util\Utenti;

require_once "./controlla_pass.php";
require_once "./inc/funzioni.php";
require_once "./header.php";

global $titolo_sito, $admin_nome, $email_mittente, $admin_user, $admin_pass, $iscrizione_online, $iscrizione_immediata_utenti, $mostra_voti_in_login, $mostra_giornate_in_login, $mostra_giornate_in_mercato, $vedi_notizie, $trasferiti_ok, $cartella_remota;

if ( ! Utenti::isAdminLogged() ) {
    header( "location: logout.php?logout=2" );
}

if ( isset( $_POST[ 'salva_configurazione' ] ) ) {
    $configurazione = [
        "titolo_sito"                 => $_POST[ "N_titolo_sito" ],
        "admin_nome"                  => $_POST[ "N_admin_nome" ],
        "admin_user"                  => $_POST[ "N_admin_user" ],
        "admin_pass"                  => $_POST[ "N_admin_pass" ],
        "iscrizione_online"           => $_POST[ "N_iscrizione_online" ],
        "iscrizione_immediata_utenti" => $_POST[ "N_iscrizione_immediata_utenti" ],
        "mostra_voti_in_login"        => $_POST[ "N_mostra_voti_in_login" ],
        "mostra_giornate_in_login"    => $_POST[ "N_mostra_giornate_in_login" ],
        "mostra_giornate_in_mercato"  => $_POST[ "N_mostra_giornate_in_mercato" ],
        "vedi_notizie"                => $_POST[ "N_vedi_notizie" ],
        "trasferiti_ok"               => $_POST[ "N_trasferiti_ok" ],
        "cartella_remota"             => $_POST[ "N_cartella_remota" ],
        "email_mittente"              => $_POST[ "N_email_mittente" ],
    ];

    if ( Configurazione::saveConfigurazione( $configurazione ) ) {
        Flash::add( "messaggio", "Configurazione salvata con successo", Flash::FLASH_SUCCESS );
    } else {
        Flash::add( "messaggio", "Erorre durante il salvataggio della configurazione", Flash::FLASH_ERROR );
    }

    echo "<meta http-equiv='refresh' content='0; url=a_gestione.php'>";
    exit;
}
?>

    <div class="container">
        <form action="./a_configura.php" method="post">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-title text-center my-3 border-bottom">
                            <div class="fs-5">Configurazione amministratore</div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <label for="N_titolo_sito" class="col-md-4 col-form-label">Titolo sito</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="N_titolo_sito" name="N_titolo_sito" aria-describedby="N_titolo_sito_desc" value="<?php echo $titolo_sito ?>">
                                    <div id="N_titolo_sito_desc" class="form-text"></div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="N_admin_nome" class="col-md-4 col-form-label">Nome amministratore</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="N_admin_nome" name="N_admin_nome" aria-describedby="N_admin_nome_desc" value="<?php echo $admin_nome ?>">
                                    <div id="N_admin_nome_desc" class="form-text">
                                        Nome del Presidente che sarà visualizzato nei vari messaggi.
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="N_admin_user" class="col-md-4 col-form-label">Login amministratore</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="N_admin_user" name="N_admin_user" aria-describedby="N_admin_user_desc" value="<?php echo $admin_user ?>">
                                    <div id="N_admin_user_desc" class="form-text">
                                        Nome dell'amministratore per accedere al pannello di controllo (max 15 caratteri).
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="N_admin_pass" class="col-md-4 col-form-label">Password amministratore</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="N_admin_pass" name="N_admin_pass" aria-describedby="N_admin_pass_desc" value="<?php echo $admin_pass ?>">
                                    <div id="N_admin_pass_desc" class="form-text">
                                        Password dell'amministratore per accedere al pannello di controllo (max 15 caratteri).
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-title text-center my-3 border-bottom">
                            <div class="fs-5">Configurazione iscrizione</div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <label for="N_iscrizione_online" class="col-md-4 col-form-label">Iscrizione online</label>
                                <div class="col-md-8">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="N_iscrizione_online" id="N_iscrizione_online1" value="SI" <?php echo $iscrizione_online === "SI" ? "checked" : "" ?>>
                                        <label class="form-check-label" for="N_iscrizione_online1">SI</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="N_iscrizione_online" id="N_iscrizione_online2" value="NO" <?php echo $iscrizione_online === "NO" ? "checked" : "" ?>>
                                        <label class="form-check-label" for="N_iscrizione_online2">NO</label>
                                    </div>

                                    <div id="N_iscrizione_online_desc" class="form-text">
                                        <strong>SI</strong> consente l'iscrizione all'utente online - <strong>NO</strong> sarà l'amministratore ad effettuare le iscrizioni manualmente.
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="N_iscrizione_immediata_utenti" class="col-md-4 col-form-label">Iscrizione immediata utenti</label>
                                <div class="col-md-8">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="N_iscrizione_immediata_utenti" id="N_iscrizione_immediata_utenti1" value="SI" <?php echo $iscrizione_immediata_utenti === "SI" ? "checked" : "" ?>>
                                        <label class="form-check-label" for="N_iscrizione_immediata_utenti1">SI</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="N_iscrizione_immediata_utenti" id="N_iscrizione_immediata_utenti2" value="NO" <?php echo $iscrizione_immediata_utenti === "NO" ? "checked" : "" ?>>
                                        <label class="form-check-label" for="N_iscrizione_immediata_utenti2">NO</label>
                                    </div>

                                    <div id="N_iscrizione_immediata_utenti_desc" class="form-text">
                                        <strong>NO</strong> imposta a -1 il flag permessi in gestione utenti; dovrà essere attivato dalla gestione utenti.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row mt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-title text-center my-3 border-bottom">
                            <div class="fs-5">Configurazioni grafiche</div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <label for="N_mostra_voti_in_login" class="col-md-4 col-form-label">Voti in prima pagina</label>
                                <div class="col-md-8">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="N_mostra_voti_in_login" id="N_mostra_voti_in_login1" value="SI" <?php echo $mostra_voti_in_login === "SI" ? "checked" : "" ?>>
                                        <label class="form-check-label" for="N_mostra_voti_in_login1">SI</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="N_mostra_voti_in_login" id="N_mostra_voti_in_login2" value="NO" <?php echo $mostra_voti_in_login === "NO" ? "checked" : "" ?>>
                                        <label class="form-check-label" for="N_mostra_voti_in_login2">NO</label>
                                    </div>

                                    <div id="N_mostra_voti_in_login_desc" class="form-text">
                                        Consente di visualizzare i voti senza loggarsi in prima pagina.
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="N_mostra_giornate_in_login" class="col-md-4 col-form-label">Giornate in prima pagina</label>
                                <div class="col-md-8">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="N_mostra_giornate_in_login" id="N_mostra_giornate_in_login1" value="SI" <?php echo $mostra_giornate_in_login === "SI" ? "checked" : "" ?>>
                                        <label class="form-check-label" for="N_mostra_giornate_in_login1">SI</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="N_mostra_giornate_in_login" id="N_mostra_giornate_in_login2" value="NO" <?php echo $mostra_giornate_in_login === "NO" ? "checked" : "" ?>>
                                        <label class="form-check-label" for="N_mostra_giornate_in_login2">NO</label>
                                    </div>

                                    <div id="N_mostra_giornate_in_login_desc" class="form-text">
                                        Consente di visualizzare le giornate senza loggarsi in prima pagina.
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="N_mostra_giornate_in_mercato" class="col-md-4 col-form-label">Giornate in mercato</label>
                                <div class="col-md-8">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="N_mostra_giornate_in_mercato" id="N_mostra_giornate_in_mercato1" value="SI" <?php echo $mostra_giornate_in_mercato === "SI" ? "checked" : "" ?>>
                                        <label class="form-check-label" for="N_mostra_giornate_in_mercato1">SI</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="N_mostra_giornate_in_mercato" id="N_mostra_giornate_in_mercato2" value="NO" <?php echo $mostra_giornate_in_mercato === "NO" ? "checked" : "" ?>>
                                        <label class="form-check-label" for="N_mostra_giornate_in_mercato2">NO</label>
                                    </div>

                                    <div id="N_mostra_giornate_in_mercato_desc" class="form-text">
                                        Consente di visualizzare le giornate in mercato.
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="N_vedi_notizie" class="col-md-4 col-form-label">Notizie in index</label>
                                <div class="col-md-8">
                                    <select class="form-select" id="N_vedi_notizie" name="N_vedi_notizie" aria-describedby="N_vedi_notizie_desc">
                                        <option value="0" <?php echo $vedi_notizie == 0 ? "selected" : "" ?>>Disabilitato</option>
                                        <option value="1" <?php echo $vedi_notizie == 1 ? "selected" : "" ?>>Blocco in index</option>
                                        <option value="2" <?php echo $vedi_notizie == 2 ? "selected" : "" ?>>Blocco in index e blocco laterale</option>
                                    </select>

                                    <div id="N_vedi_notizie_desc" class="form-text">
                                        0 - disabilitato 1 - blocco in index - 2 - blocco in index e blocco laterale in menu.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-title text-center my-3 border-bottom">
                            <div class="fs-5">Configurazione voti</div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <label for="N_trasferiti_ok" class="col-md-4 col-form-label">Cambia trasferiti</label>
                                <div class="col-md-8">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="N_trasferiti_ok" id="N_trasferiti_ok1" value="SI" <?php echo $trasferiti_ok === "SI" ? "checked" : "" ?>>
                                        <label class="form-check-label" for="N_trasferiti_ok1">SI</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="N_trasferiti_ok" id="N_trasferiti_ok2" value="NO" <?php echo $trasferiti_ok === "NO" ? "checked" : "" ?>>
                                        <label class="form-check-label" for="N_trasferiti_ok2">NO</label>
                                    </div>

                                    <div id="N_trasferiti_ok_desc" class="form-text">
                                        Consente di abilitare la procedura per il cambio dei trasferiti, senza che questi vengano conteggiati nel totale dei cambi.
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="N_cartella_remota" class="col-md-4 col-form-label">Stagione</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="N_cartella_remota" name="N_cartella_remota" aria-describedby="N_cartella_remota_desc" maxlength="4" size="4" value="<?php echo $cartella_remota ?>">
                                    <div id="N_cartella_remota_desc" class="form-text">
                                        Solitamente si utilizza l'anno di inizio del campionato. Es: 2021
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-title text-center my-3 border-bottom">
                            <div class="fs-5">Configurazione SMTP (TODO)</div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <label for="N_email_mittente" class="col-md-4 col-form-label">Email mittente</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="N_email_mittente" name="N_email_mittente" aria-describedby="N_email_mittente_desc" value="<?php echo $email_mittente ?>">
                                    <div id="N_email_mittente_desc" class="form-text">
                                        Indirizzo email mittente
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <button type="submit" class="btn btn-primary btn-lg" name="salva_configurazione">Salva configurazione</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

<?php
require_once "./footer.php";
