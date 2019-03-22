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

$('select').change( function(e) {
    var site = $(this).val().trim();
    if (site === 'Tous') {
        $ ('tr').show ();
    }
    else {
        $('#sortieData #sortie').each( function(rowIdx,tr) {
            $(this).hide().find('td').each( function(idx, td) {
                if( idx === 8) {
                    var check = $(this).text().trim();
                    if (check && check.indexOf(site) == 0) {
                        $(tr).show();
                    }
                }
            });

        });
    }
});

$(document).ready(function () {

    var tableDateDebutCellIndex = 1;
    var tableDateFinCellIndex = 2;

    $('.submitSearch').on('click', function (evt) {

        var startDate = parseDate($('#dateDebut').val());
        var endDate = parseDate($('#dateFin').val());

        if (isNaN(startDate.getDate()) || isNaN(endDate.getDate())) {
            alert("Please fill the correct start and end date");
        } else {

            var rows = $("#sortieData").find("tr");

            $.each(rows, function (index, row) {
                var rowDateDebut = parseDate($($(row).find("td")[tableDateDebutCellIndex]).text());
                var rowDateFin = parseDate($($(row).find("td")[tableDateFinCellIndex]).text());

                if (rowDateDebut < startDate || rowDateFin > endDate) {
                    // could take an action other than hiding the row with the date outside of the specified range
                    $(row).hide();
                }

            });

        }

        return false;

    });

    // parse a date in yyyy-mm-dd format
    function parseDate(input) {
        var parts = input.split('/');
        // new Date(year, month [, day [, hours[, minutes[, seconds[, ms]]]]])
        return new Date(parts[2], parts[1] - 1, parts[0]);
    }


});

// $(".searchInput").on("input", function() {
//     var from = stringToDate($("#dateDebut").val());
//     var to = stringToDate($("#dateFin").val());
//
//     $(".fbody tr").each(function() {
//         var row = $(this);
//         var date = stringToDate(row.find("td").eq(2).text());
//
//         //show all rows by default
//         var show = true;
//
//         //if from date is valid and row date is less than from date, hide the row
//         if (from && date < from)
//             show = false;
//
//         //if to date is valid and row date is greater than to date, hide the row
//         if (to && date > to)
//             show = false;
//
//         if (show)
//             row.show();
//         else
//             row.hide();
//     });
// });
//
// //parse entered date. return NaN if invalid
// function stringToDate(s) {
//     var ret = NaN;
//     var parts = s.split("/");
//     date = new Date(parts[2], parts[0], parts[1]);
//     if (!isNaN(date.getTime())) {
//         ret = date;
//     }
//     return ret;
// }