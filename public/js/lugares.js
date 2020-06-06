var num_asientos = new Array();

function selectAsiento(asiento){
    
    if(asiento.className == "empty"){
        $(asiento).removeClass('empty').addClass('reserved');
      
        num_asientos.push(asiento.id);

    }else if(asiento.className == "reserved"){
        $(asiento).removeClass('reserved').addClass('empty');

        removeA(num_asientos, asiento.id);
    }
}

function removeA(arr) {
    var what, a = arguments, L = a.length, ax;
    while (L > 1 && arr.length) {
        what = a[--L];
        while ((ax= arr.indexOf(what)) !== -1) {
            arr.splice(ax, 1);
        }
    }
    return arr;
}

function reservarPasaje(){
    var cant_asientos = num_asientos.length;
    var fechaV = gup('fecha');
    var codHorario = gup('codViaje');


    if(!cant_asientos == 0){
        $.post("realizar_reserva.php", {numAsientos : num_asientos, cantAsientos : cant_asientos, fecha : fechaV, cod_horario : codHorario}).done(function(data){
            $("#reservaRealizada").html(data);
        })

        popupReserva.style.display = "initial";
    } 
}

function gup( name, url ) {
    if (!url) url = location.href;
    name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
    var regexS = "[\\?&]"+name+"=([^&#]*)";
    var regex = new RegExp( regexS );
    var results = regex.exec( url );
    return results == null ? null : results[1];
}
