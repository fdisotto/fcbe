<?php
##################################################################################
#    FANTACALCIOBAZAR EVOLUTION
#    Copyright (C) 2003-2006 by Antonello Onida (fantacalciobazar@sassarionline.net)
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
use FCBE\Enum\StatoMercato;
use FCBE\Enum\TipoCalcolo;
use FCBE\Util\Tornei;

$hide_left_menu = true;

require_once "./dati/dati_gen.php";
require_once "./inc/funzioni.php";
require_once "./header.php";

$tornei = Tornei::getTornei();
?>

    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-title text-center mb-0 py-2">
                                <div class="fs-4">Tornei in corso</div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php foreach ( $tornei as $torneo ): ?>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-title text-center mb-0 py-2 border-bottom">
                                    <div class="fs-5 text-uppercase"><?php echo $torneo->nome ?></div>
                                </div>
                                <div class="card-body">
                                    <?php if ( $torneo->stato_mercato != StatoMercato::TORNEO_NON_ATTIVO ): ?>
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <table class="table">
                                                    <tbody>
                                                    <tr>
                                                        <th class="text-uppercase align-bottom text-start">Numero partecipanti:</th>
                                                        <td class="text-start"><?php echo $torneo->partecipanti <= 0 ? 'Nessun limite' : $torneo->partecipanti ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-uppercase align-bottom text-start">Giocatori attualmente iscritti:</th>
                                                        <td class="text-start"><?php echo $torneo->giocatori_registrati ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-uppercase align-bottom text-start">Mercato libero:</th>
                                                        <td class="text-start"><?php echo $torneo->mercato_libero ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-uppercase align-bottom text-start">Tipo calcolo:</th>
                                                        <td class="text-start"><?php echo TipoCalcolo::TIPO_EXT[ $torneo->tipo_calcolo ] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-uppercase align-bottom text-start">Giornate totali:</th>
                                                        <td class="text-start"><?php echo $torneo->giornate_totali ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-uppercase align-bottom text-start">Ritardo inizio:</th>
                                                        <td class="text-start"><?php echo $torneo->ritardo_torneo ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-uppercase align-bottom text-start">Crediti iniziali:</th>
                                                        <td class="text-start"><?php echo $torneo->crediti_iniziali ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-uppercase align-bottom text-start">Composizione rosa:</th>
                                                        <td class="text-start"><?php echo $torneo->numero_calciatori ?> (<?php echo $torneo->composizione_squadra ?>)</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-uppercase align-bottom text-start">Stato mercato:</th>
                                                        <td class="text-start"><?php echo StatoMercato::STATO_EXT[ $torneo->stato_mercato ] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-uppercase align-bottom text-start">Modificatore difesa:</th>
                                                        <td class="text-start"><?php echo $torneo->modificatore_difesa ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-uppercase align-middle text-start">Schemi applicabili:</th>
                                                        <td class="text-start text-wrap"><?php echo $torneo->schemi ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-uppercase align-middle text-start">Giocatori in panchina:</th>
                                                        <td class="text-start"><?php echo $torneo->max_in_panchina ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-uppercase align-middle text-start">Panchina fissa:</th>
                                                        <td class="text-start"><?php echo $torneo->panchina_fissa ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-uppercase align-middle text-start">Max sostituzioni:</th>
                                                        <td class="text-start"><?php echo $torneo->max_entrate_dalla_panchina ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-uppercase align-middle text-start">Sostituzioni per ruolo:</th>
                                                        <td class="text-start"><?php echo $torneo->sostituisci_per_ruolo ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-uppercase align-middle text-start">Sostituzioni per schema:</th>
                                                        <td class="text-start"><?php echo $torneo->sostituisci_per_schema ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-uppercase align-middle text-start">Fantasisti per centrocampisti:</th>
                                                        <td class="text-start"><?php echo $torneo->sostituisci_fantasisti_come_centrocampisti ?></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <?php if ( $torneo->mercato_libero == "SI" ): ?>
                                                    <table class="table">
                                                        <tbody>
                                                        <tr>
                                                            <th>
                                                                Mercato libero: giocatori condivisi e cambi stile magiccampionato.
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-uppercase align-bottom text-start">Numero massimo di cambi:</th>
                                                            <td class="text-start"><?php echo $torneo->numero_cambi_max ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-uppercase align-bottom text-start">Cambi in riparazione:</th>
                                                            <td class="text-start"><?php echo $torneo->rip_cambi_numero ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-uppercase align-bottom text-start">Giornate di riparazione:</th>
                                                            <td class="text-start"><?php echo $torneo->rip_cambi_giornate ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-uppercase align-bottom text-start">Durata riparazione:</th>
                                                            <td class="text-start"><?php echo $torneo->rip_cambi_durata ?></td>
                                                        </tr>

                                                        <tr>
                                                            <th colspan="2">
                                                                Dati utili per gli scontri diretti
                                                            </th>
                                                        </tr>

                                                        <tr>
                                                            <th class="text-uppercase align-bottom text-start">Soglia voti primo gol:</th>
                                                            <td class="text-start"><?php echo $torneo->soglia_voti_primo_gol ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-uppercase align-bottom text-start">Incremento voti gol successivo:</th>
                                                            <td class="text-start"><?php echo $torneo->incremento_voti_gol_successivi ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-uppercase align-bottom text-start">Bonus in casa:</th>
                                                            <td class="text-start"><?php echo $torneo->voti_bonus_in_casa ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-uppercase align-bottom text-start">Punti partita vinta:</th>
                                                            <td class="text-start"><?php echo $torneo->punti_partita_vinta ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-uppercase align-bottom text-start">Punti partita pareggiata:</th>
                                                            <td class="text-start"><?php echo $torneo->punti_partita_pareggiata ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-uppercase align-bottom text-start">Punti partita persa:</th>
                                                            <td class="text-start"><?php echo $torneo->punti_partita_persa ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-uppercase align-bottom text-start">Differenza punti a parita gol:</th>
                                                            <td class="text-start"><?php echo $torneo->differenza_punti_a_parita_gol ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-uppercase align-bottom text-start">Differenza punti zero a zero:</th>
                                                            <td class="text-start"><?php echo $torneo->differenza_punti_zero_a_zero ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-uppercase align-bottom text-start">Titolari minimi a referto:</th>
                                                            <td class="text-start"><?php echo $torneo->min_num_titolari_in_formazione ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th colspan="2">
                                                                Dati per i campionati a punti per posizione di giornata.
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-uppercase align-bottom text-start">Punti pareggio:</th>
                                                            <td class="text-start"><?php echo $torneo->punti_pareggio ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-uppercase align-bottom text-start">Punti per posizione:</th>
                                                            <td class="text-start"><?php echo $torneo->punti_pos ?></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                <?php else: ?>
                                                    <table class="table">
                                                        <tbody>
                                                        <tr>
                                                            <th colspan="2">
                                                                Asta iniziale, e scambio, acquisti e vendite secondo il classico modo di gioco
                                                            </th>
                                                        </tr>

                                                        <tr>
                                                            <th class="text-uppercase align-bottom text-start">Tempo attesta asta:</th>
                                                            <td class="text-start">giorni <?php echo $torneo->aspetta_giorni ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-uppercase align-bottom text-start">Tempo attesta asta:</th>
                                                            <td class="text-start">ore <?php echo $torneo->aspetta_ore ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-uppercase align-bottom text-start">Tempo attesta asta:</th>
                                                            <td class="text-start">minuti <?php echo $torneo->aspetta_minuti ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-uppercase align-bottom text-start">Max scambi:</th>
                                                            <td class="text-start"><?php echo $torneo->num_calciatori_scambiabili ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-uppercase align-bottom text-start">Scambi con crediti:</th>
                                                            <td class="text-start"><?php echo $torneo->num_calciatori_scambiabili ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-uppercase align-bottom text-start">Vendita al costo:</th>
                                                            <td class="text-start"><?php echo $torneo->vendi_costo ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-uppercase align-bottom text-start">Percentuale di vendita:</th>
                                                            <td class="text-start"><?php echo $torneo->percentuale_vendita ?></td>
                                                        </tr>

                                                        <tr>
                                                            <th colspan="2">
                                                                Dati utili per gli scontri diretti
                                                            </th>
                                                        </tr>

                                                        <tr>
                                                            <th class="text-uppercase align-bottom text-start">Soglia voti primo gol:</th>
                                                            <td class="text-start"><?php echo $torneo->soglia_voti_primo_gol ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-uppercase align-bottom text-start">Incremento voti gol successivo:</th>
                                                            <td class="text-start"><?php echo $torneo->incremento_voti_gol_successivi ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-uppercase align-bottom text-start">Bonus in casa:</th>
                                                            <td class="text-start"><?php echo $torneo->voti_bonus_in_casa ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-uppercase align-bottom text-start">Punti partita vinta:</th>
                                                            <td class="text-start"><?php echo $torneo->punti_partita_vinta ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-uppercase align-bottom text-start">Punti partita pareggiata:</th>
                                                            <td class="text-start"><?php echo $torneo->punti_partita_pareggiata ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-uppercase align-bottom text-start">Punti partita persa:</th>
                                                            <td class="text-start"><?php echo $torneo->punti_partita_persa ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-uppercase align-bottom text-start">Differenza punti a parita gol:</th>
                                                            <td class="text-start"><?php echo $torneo->differenza_punti_a_parita_gol ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-uppercase align-bottom text-start">Differenza punti zero a zero:</th>
                                                            <td class="text-start"><?php echo $torneo->differenza_punti_zero_a_zero ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-uppercase align-bottom text-start">Titolari minimi a referto:</th>
                                                            <td class="text-start"><?php echo $torneo->min_num_titolari_in_formazione ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th colspan="2">
                                                                Dati per i campionati a punti per posizione di giornata.
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-uppercase align-bottom text-start">Punti pareggio:</th>
                                                            <td class="text-start"><?php echo $torneo->punti_pareggio ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-uppercase align-bottom text-start">Punti per posizione:</th>
                                                            <td class="text-start"><?php echo $torneo->punti_pos ?></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-info text-center">
                                            <p class="fs-4">Torneo non ancora definito</p>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>

            <div class="col-12 col-md-4">
                <?php require_once "./menu_i.php"; ?>
            </div>
        </div>
    </div>


<?php
require_once "./footer.php";
