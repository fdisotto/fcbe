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

        let input = $('#chiusura_giornata_date');
        if (input.length) {
            input.datetimepicker({
                inline: true,
                format: 'd-m-Y H:i',
                onChangeDateTime: function (dp, $input) {
                    input.val($input.val());
                }
            });
        }
    })
})(jQuery);
