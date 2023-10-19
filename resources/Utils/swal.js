import * as mensajes from "./message.js";

export function setSwal(value) {
    switch (value) {
        case 1:
            Swal.fire({
                icon: "success",
                title: mensajes.MENSAJE_REGISTRADO,
                text: mensajes.MENSAJE_EXITO,
            });
            break;
        case 2:
            Swal.fire({
                icon: "success",
                title: mensajes.MENSAJE_ACTUALIZADO,
                text: mensajes.MENSAJE_EXITO,
            });
            break;
        case 3:
            Swal.fire({
                icon: "success",
                title: mensajes.MENSAJE_ELIMINADO,
                text: mensajes.MENSAJE_EXITO,
            });
            break;
        case 4:
            Swal.fire({
                icon: "warning",
                title: mensajes.MENSAJE_ERROR,
                text: mensajes.MENSAJE_NO_AUTORIZADO,
                didClose: () => {
                    const nuevaUrl = window.location.origin;
                    window.location.href = nuevaUrl;
                },
            });
            break;
        case 5:
            Swal.fire({
                icon: "success",
                title: mensajes.MENSAJE_CAMBIO_STATUS,
                text: mensajes.MENSAJE_EXITO,
            });
            break;

        default:
            console.log("no message");
            break;
    }
}
