var cantAsientosDisponibles = document.getElementsByClassName("asientosDisponibles");
for(var i=0;i < cantAsientosDisponibles.length; i++ ){
    var asientosAdvertencia = cantAsientosDisponibles[i].innerText;
    if(asientosAdvertencia <= 5){
        cantAsientosDisponibles[i].classList.add("red");
    }else if(asientosAdvertencia >= 15){
        cantAsientosDisponibles[i].classList.add("green");
    }else{
        cantAsientosDisponibles[i].classList.add("yellow");  
    }
}

var seleccionar_viaje = document.getElementById('seleccionar_viaje');

seleccionar_viaje.onclick = function(){
    var codigoViaje = $("input[name='elegirViaje']:checked").val();
    var fechaViaje = fechaSpan.innerText;
    
    if(typeof codigoViaje !== "undefined"){
        seleccionar_viaje.href = "lugares.php?"+"fecha="+ fechaViaje + "&codViaje=" + codigoViaje;
    }else{
        seleccionar_viaje.href = "#";
    }
}   