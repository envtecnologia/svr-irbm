<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinição de Senha</title>
</head>
<body>
    <h1>Olá, {{ $user->name }}</h1>
    <p>Você solicitou a redefinição de sua senha.</p>
    <p>Clique no link abaixo para redefinir sua senha:</p>
    <a href="{{ $url }}">Redefinir Senha</a>
    <p>Se você não solicitou essa alteração, ignore este e-mail.</p>
</body>
</html>
