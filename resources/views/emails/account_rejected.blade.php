<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Compte refusé</title>
</head>
<body>
    <h2>Bonjour {{ $user->name }},</h2>

    <p>Nous sommes désolés de vous informer que votre demande de compte a été refusée.</p>

    <p><strong>Motif :</strong> {{ $reason }}</p>

    <p>Si vous pensez qu’il s’agit d’une erreur ou souhaitez réessayer, n’hésitez pas à nous contacter au +010000000.</p>

    <p>Merci pour votre attente.</p>
</body>
</html>
