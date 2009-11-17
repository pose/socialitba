
document.getElementById('input_field').addEventListener('onkeyup',max); 
document.getElementById('input_field').addEventListener('onkeypress',max); 


max: function(txarea) 
{ 
    total = 100;
    tam = txarea.value.length;
    
    str=""; 
    str=str+tam;
    Digitado = document.getElementById('Digitado');
    Restante = document.getElementById('Restante');
    Digitado.setInnerXHTML = str; 
    Restante.setInnerXHTML = total - str; 

    if (tam > total){ 
        aux = txarea.value; 
        txarea.value = aux.substring(0,total); 
        Digitado.setInnerXHTML = total; 
        Restante.setInnerXHTML = 0; 
    } 
}