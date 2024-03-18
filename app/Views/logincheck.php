<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <script>
        let checkVars = ["token", "empresa", "nombre"];
        let haySesion = true;
        for (let i = 0; i < checkVars.length; i++) {
            const clave = checkVars[i];
            if (localStorage.getItem(clave) == null) {
                haySesion = false;
                break;
            }
        }
        if (haySesion) {
            location.replace("<?= base_url("/panel/home") ?>");
        } else {
            location.replace("<?= base_url("/usuario/login") . "?" . http_build_query(["mensaje" => "Debes iniciar sesión para continuar", "tipo" => "warning"]); ?>");

        }
    </script>
</body>

</html>