(function ($) {
    $(document).ready(function () {
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
    })
})(jQuery);
