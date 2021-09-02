(function ($) {
    $(document).ready(function () {
        $.datetimepicker.setLocale('it');

        let voti_table = $("#voti-datatable");
        if (voti_table.length) {
            voti_table.DataTable({
                language: {
                    url: './assets/js/datatables.italian.json'
                },
            });
        }


        $(document).on("click", "#navbar-toggler", function () {
            $("#sidebar-wrapper").toggleClass("d-none");
            $("body").toggleClass("sidebar-collapsed");
        });

        let chiusura_giornata_input = $('#chiusura_giornata_date');
        if (chiusura_giornata_input.length) {
            chiusura_giornata_input.datetimepicker({
                inline: true,
                format: 'd-m-Y H:i',
                onChangeDateTime: function (dp, $input) {
                    chiusura_giornata_input.val($input.val());
                }
            });
        }

        let torneo_mercato_libero_input = $("#N_otmercato_libero");
        if (torneo_mercato_libero_input.length && $("#torneo_mercato_libero_div").length) {
            $(document).on("change", "#N_otmercato_libero", function () {
                if ($(this).val() === "SI") {
                    $("#torneo_mercato_libero_div").show();
                    $("#torneo_asta_iniziale_div").hide();
                } else {
                    $("#torneo_mercato_libero_div").hide();
                    $("#torneo_asta_iniziale_div").show();
                }
            });
            torneo_mercato_libero_input.trigger("change");
        }

        let torneo_tipo_calcolo_input = $("#N_ottipo_calcolo");
        if (torneo_tipo_calcolo_input.length && $("#torneo_tipo_cacolo_div").length) {
            $(document).on("change", "#N_ottipo_calcolo", function () {
                if ($(this).val() === "P" || $(this).val() === "S") {
                    $("#torneo_tipo_cacolo_div").show();
                } else {
                    $("#torneo_tipo_cacolo_div").hide();
                }
            });
            torneo_tipo_calcolo_input.trigger("change");
        }
    })
})(jQuery);
