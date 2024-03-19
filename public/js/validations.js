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

function toLowerFirstLetter(str) {
    let words = str.split(" ");
    for (let i = 0; i < words.length; i++) {
        words[i] = words[i].toLowerCase();
        words[i] = words[i][0].toUpperCase() + words[i].slice(1);
    }
    return words.join(" ");
}