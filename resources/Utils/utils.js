export function cambiarFormatoFecha(fecha) {
    var nuevaFecha = "";
    if (fecha != null) {
        var fechaOriginal = new Date(fecha);
        fechaOriginal.setUTCHours(0, 0, 0, 0);

        var dia = fechaOriginal.getUTCDate();
        var mes = fechaOriginal.toLocaleString("default", { month: "long" });
        var año = fechaOriginal.getUTCFullYear();

        nuevaFecha = `${dia} ${mes} ${año}`;
    }
    return nuevaFecha;
}