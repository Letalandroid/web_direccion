function soloNumeros(event) {
    var numero = event.keyCode || event.which;
    if ((numero> 0 && numero <33)||(numero >= 48 && numero <= 57) || (numero >= 96 && numero <= 105) || (numero == 8) || (numero == 46) || (numero == 37) || (numero == 39)) {
        return true;
    } else {
        alert('Solo se permiten Números');
        return false;
    }
}

function soloLetras(event) {
    var letras = event.keyCode;
    
    if ((letras > 0 && letras <33)||(letras >64 && letras <91)||(letras <95 && letras >123)||(letras >221 && letras <223)) {
        return true;
    } else {
        alert('Solo se permiten Letras');
        return false;
    }
}