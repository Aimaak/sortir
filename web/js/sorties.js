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

$('select').change(function () {
    var site = $(this).val().trim();
    if (site === 'Tous') {
        $('tr').show();
    } else {
        $('.fbody #sortie').each(function (rowIdx, tr) {
            $(this).hide().find('td').each(function (idx) {
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

$('#organisateur').click(function () {

    if (this.checked) {
        $('#mesSorties').show();
        $('#sorties').hide();
    }

    if ( $('#organisateur').filter(':checked').length === 0 ) {
        $('#mesSorties').hide();
        $('#sorties').show();
    }

});

$('#passees').click(function () {

    if (this.checked) {
        $('#sortiesPassees').show();
        $('#sorties').hide();
    }

    if ( $('#passees').filter(':checked').length === 0 ) {
        $('#sortiesPassees').hide();
        $('#sorties').show();
    }

});

$('#inscrit').click(function () {

    if (this.checked) {
        $('#sortiesInscrit').show();
        $('#sorties').hide();
    }

    if ( $('#inscrit').filter(':checked').length === 0 ) {
        $('#sortiesInscrit').hide();
        $('#sorties').show();
    }

});

$('#nonInscrit').click(function () {

    if (this.checked) {
        $('#sortiesnonInscrit').show();
        $('#sorties').hide();
    }

    if ( $('#nonInscrit').filter(':checked').length === 0 ) {
        $('#sortiesnonInscrit').hide();
        $('#sorties').show();
    }

});