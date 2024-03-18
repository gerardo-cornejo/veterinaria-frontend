function is_empty(vars = []) {

    let validadoOk = false;

    vars.forEach(element => {
        if (element == null || element.length == 0) {
            validadoOk = true;
        }
    });

    return validadoOk;

}

function reset_inputs(ids = []) {
    ids.forEach(id => {
        $(id).text("");
        $(id).val("");
    });
}