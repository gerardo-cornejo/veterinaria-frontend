function is_empty(vars = []) {
    return vars.some(element => !element || element.length === 0);
}

function reset_inputs(ids = []) {
    ids.forEach(id => $(id).val(""));
}

function toLowerFirstLetter(str) {
    if (typeof str !== 'string') return '';
    return str.split(" ").map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()).join(" ");
}
function checkColor(input) {
    if (input.value.length == 0) {
        $(input).addClass("border-danger");
    } else {
        $(input).removeClass("border-danger");
    }
}

function isMobile() {
    return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
}