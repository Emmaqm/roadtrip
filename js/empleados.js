function showPagoR(){
    hide();
    pagoPasajeReserva.style.display = "block";
    pagarR.style.backgroundColor = "#103f6ee3";
    pagarR.style.color = "white";
}

function showAgregar(){
    hide();
    agregarViaje.style.display = "block";
    agregar.style.backgroundColor = "#103f6ee3";
    agregar.style.color = "white";
}

function showModificar(){
    hide();
    modificarViaje.style.display = "block";
    modificar.style.backgroundColor = "#103f6ee3";
    modificar.style.color = "white";
}

function showCancelar(){
    hide();
    cancelarViaje.style.display = "block";
    cancelar.style.backgroundColor = "#103f6ee3";
    cancelar.style.color = "white";
}

function hide(){
    pagoPasajeReserva.style.display = "none";
    agregarViaje.style.display = "none";
    modificarViaje.style.display = "none";
    cancelarViaje.style.display = "none";

    pagarR.style.backgroundColor = "#eaf2ff";
    agregar.style.backgroundColor = "#eaf2ff";
    modificar.style.backgroundColor = "#eaf2ff";
    cancelar.style.backgroundColor = "#eaf2ff";
    
    pagarR.style.color = "#5b5b5b";
    agregar.style.color = "#5b5b5b";
    modificar.style.color = "#5b5b5b";
    cancelar.style.color = "#5b5b5b";
}

var num_asientos = new Array();

function venderAsiento(asiento){
    
    if(asiento.className == "empty"){
        $(asiento).removeClass('empty').addClass('buyed');
      
        num_asientos.push(asiento.id);

    }else if(asiento.className == "buyed"){
        $(asiento).removeClass('buyed').addClass('empty');

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

function venderPasaje(){
    var cant_asientos = num_asientos.length;
    var fechaV = gup('fecha');
    var codHorario = gup('codViaje');
    
    var ciInput = document.getElementById('ciInput').value;
    var ciInput2 = document.getElementById('ciInput');



    if(!cant_asientos == 0 && ciInput != ""){
        $.post("realizar_reserva.php", {numAsientos : num_asientos, cantAsientos : cant_asientos, fecha : fechaV, cod_horario : codHorario, ci: ciInput}).done(function(data){
            $("#reservaRealizada").html(data);
        })

        popupReserva.style.display = "initial";

    }else if(ciInput == ""){
        ciInput2.style.borderColor = "red";
        label.style.color = "red";
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

function cargarReservas(){
   var ciInput = document.getElementById('ciInput').value;

   $.post("cargar_reservas.php", {cedula : ciInput}).done(function(data){
    $("#listaReservas").html(data);
})
}

function selectReserva(){
    var comboValue = $("input[name='elegirViaje']:checked").val();

    if(comboValue != ""){
        var fields = comboValue.split('/');

        var ci = fields[0];
        var codHorario = fields[1];
        var fecha = fields[2];
    
    
        $.post("confirmar_pago.php", {ci_usuario : ci, cod_horario : codHorario, fecha_viaje : fecha}).done(function(data){
            $("#listaReservas").html(data);
        })
    }
}

function agregar_viaje(){
    var origen = textOrigen.innerText;
    var destino = textDestino.innerText;
    var day = dayCombo.value;
    var salidaH = salida.value;
    var llegadaH = llegada.value;
    var precioH = precio.value;

    $.post("agregar_viaje.php", {origen : origen, destino : destino, day : day, salida : salidaH, llegada : llegadaH, precio : precioH}).done(function(data){
        $("#aviso").html(data);
    })

}

function cargar_horarios(){
    var dia = dayComboM.value;

    $.post("cargar_horarios_m.php", {dia : dia}).done(function(data){
        $("#modificarHorario").html(data);
    })
}

function cargar_horarios2(){
    var dia = dayComboMV.value;

    $.post("cargar_horarios_c.php", {dia : dia}).done(function(data){
        $("#modificarHorario2").html(data);
    })
}

function cancelar_viaje(){

    var cod_horario = $("input[name='elegirHorario']:checked").val();
    var fecha = fechaI.value;

    $.post("cancelar_viaje.php", {cod_horario : cod_horario, fecha : fecha}).done(function(data){
        $("#avisoC").html(data);
    })

}

function modificar_viaje(){

    var codigo = $("input[name='elegirHorario2']:checked").val();
    var salida = salidaM.value;
    var llegada = llegadaM.value;
    

    $.post("modificar_viaje.php", {codigo : codigo, salida : salida, llegada : llegada}).done(function(data){
        $("#avisoM").html(data);
    })

}