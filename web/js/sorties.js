function rechercheNom() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("nom");
    filter = input.value.toUpperCase();
    table = document.getElementById("tab");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

$('select').change(function (e) {
    var site = $(this).val().trim();
    if (site === 'Tous') {
        $('tr').show();
    } else {
        $('.fbody #sortie').each(function (rowIdx, tr) {
            $(this).hide().find('td').each(function (idx, td) {
                if (idx === 8) {
                    var check = $(this).text().trim();
                    if (check && check.indexOf(site) == 0) {
                        $(tr).show();
                    }
                }
            });

        });
    }
});

$('#organisateur').change(function () {

    if (this.checked) {
        $('#mesSorties').show();
        $('#sorties').hide();
    }

    if ( $('#organisateur').filter(':checked').length === 0 ) {
        $('#mesSorties').hide();
        $('#sorties').show();
    }

});

$('#passees').change(function () {

    if (this.checked) {
        $('#sortiesPassees').show();
        $('#sorties').hide();
    }

    if ( $('#passees').filter(':checked').length === 0 ) {
        $('#sortiesPassees').hide();
        $('#sorties').show();
    }

});

$('#inscrit').change(function () {

    if (this.checked) {
        $('#sortiesInscrit').show();
        $('#sorties').hide();
    }

    if ( $('#inscrit').filter(':checked').length === 0 ) {
        $('#sortiesInscrit').hide();
        $('#sorties').show();
    }

});

$('#nonInscrit').change(function () {

    if (this.checked) {
        $('#sortiesnonInscrit').show();
        $('#sorties').hide();
    }

    if ( $('#nonInscrit').filter(':checked').length === 0 ) {
        $('#sortiesnonInscrit').hide();
        $('#sorties').show();
    }

});

$(document).ready(function () {

    var tableDateDebutCellIndex = 1;
    var tableDateFinCellIndex = 2;

    $('#dateFin').on('change', function (evt) {

        var startDate = parseDate($('#dateDebut').val());
        var endDate = parseDate($('#dateFin').val());

        if ($("#dateFin").empty()) {
            $("tr").show();
        }

        var rows = $(".fbody").find("tr");

        $.each(rows, function (index, row) {
            var rowDateDebut = parseDate($($(row).find("td")[tableDateDebutCellIndex]).text());
            var rowDateFin = parseDate($($(row).find("td")[tableDateFinCellIndex]).text());

            if (rowDateDebut < startDate || rowDateFin > endDate) {
                // could take an action other than hiding the row with the date outside of the specified range
                $(row).hide();
            }

        });

        return false;

    });

    // parse a date in yyyy-mm-dd format
    function parseDate(input) {
        var parts = input.split('/');
        // new Date(year, month [, day [, hours[, minutes[, seconds[, ms]]]]])
        return new Date(parts[2], parts[1] - 1, parts[0]);
    }
});