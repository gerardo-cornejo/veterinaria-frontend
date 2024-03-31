
function mostrarError(error) {
    console.log(error);


    if (error.text) {
        Swal.fire({
            icon: "error",
            title: "Ocurrieron los siguientes errores",
            html: "-" + error.text
        });
        return;
    }

    let errors = error.responseJSON ? Object.values(error.responseJSON.mensajes) : [];
    let expired = false;

    $.each(errors, function (index, errorMessage) {
        console.log(errorMessage);
        if (errorMessage.indexOf("Expired token") >= 0 && error.status == 401) {
            expired = true;
            redirectToLogin("Su sesión expiró. Inicie sesión nuevamente.", "warning");
            return false; // Break the loop
        }
    });

    if (!expired) {
        let errorMessage = errors.length > 1 ? errors.join("<br>-") : errors.join("");
        Swal.fire({
            icon: "error",
            title: "Ocurrieron los siguientes errores",
            html: "-" + errorMessage
        });
    }

}

function mostrarCargando(realoadTable = false) {

    if (typeof table !== 'undefined' && !realoadTable) {
        table.clear().draw();
        table.responsive.rebuild();
        table.responsive.recalc();
        $(".dt-type-numeric").removeClass("dt-type-numeric");
    }

    Swal.fire({
        title: "Cargando información...",
        text: "Por favor, espere."
    });
    Swal.showLoading();
}