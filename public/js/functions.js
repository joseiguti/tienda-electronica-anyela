
function multiplicar(){
    m1 = document.getElementById("valor").value;
    m2 = document.getElementById("utilidad").value;
    m3 = document.getElementById("iva").value;
    r = (m1*m2)/100;
    document.getElementById("resultado").value = r;
    r1 = (m1*m3)/100;

    n1= parseInt(m1);
    n2= parseInt(m2);
    n3= parseInt(m3);
    n4= parseInt(r1);

    r3 = parseInt(r1)+r;
    r4 = parseInt(m1)+r3;
    document.getElementById("resultado2").value = r4;
}

function colores(){

    m1 = document.getElementById("color1").value;
    m2 = document.getElementById("color2").value;
    m3 = document.getElementById("color3").value;
    r4=m1+m2;
    r5=r4*m3;
    document.getElementById("resultado3").value = r5;

}