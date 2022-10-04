<?php

$subjects = [
    'info' => 'Information générale',
    'hello' => 'Me dire bonjour',
    'job' => 'Me proposer une offre d\'emploi',
    'troll' => 'M\'insulter',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nettoyage

    // foreach($_POST as $key => $value) {
    //     $contact[$key] = trim($value);
    // }

    $contact = array_map('trim', $_POST);
    echo htmlentities($contact['firstname']);

    // Validation, gestion des erreurs
    $errors = [];

    if (empty($contact['firstname'])) {
        $errors[] = 'Le prénom est obligatoire';
    }

    $maxFirstnameLength = 80;
    if (strlen($contact['firstname']) > $maxFirstnameLength) {
        $errors[] = 'Le prénom doit faire moins de ' . $maxFirstnameLength . ' caractères';
    }

    if (empty($contact['email'])) {
        $errors[] = 'L\'email est obligatoire';
    }

    if (!filter_var($contact['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Le format d\'email est incorrect';
    }

    $maxEmailLength = 255;
    if (strlen($contact['firstname']) > $maxEmailLength) {
        $errors[] = 'L\'email doit faire moins de ' . $maxEmailLength . ' caractères';
    }

    if (empty($contact['message'])) {
        $errors[] = 'Le message est obligatoire';
    }

    if(!key_exists($contact['subject'], $subjects)) {
        $errors[] = 'Le sujet est incorrect';
    }

    if (empty($errors)) {
        // traitement de mon form
        // par ex: envoi d'un email
        // ou insertion en BDD

        // une fois le traitement terminé, redirection en GET
        header('Location: index.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <h1>Me contacter</h1>
    <form action="" method="POST" novalidate>
        <?php if (!empty($errors)) : ?>
            <ul class="error">
                <?php foreach ($errors as $error) : ?>
                    <li><?= $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <label for="my-firstname">Prénom</label>
        <input type="text" id="my-firstname" name="firstname" required value="<?= $contact['firstname'] ?? '' ?>">

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required value="<?= $contact['email'] ?? '' ?>">

        <label for="subject">Sujet</label>
        <select id="subject" name="subject">
            <?php foreach ($subjects as $subject => $subjectMessage) : ?>
                <option 
                    value="<?= $subject ?>"
                    <?php if(isset($contact['subject']) && $contact['subject'] === $subject) : ?>
                        selected
                    <?php endif; ?>                    
                >
                <?= $subjectMessage ?>
                </option>
            <?php endforeach; ?>
        </select>
        <label for="message">Message</label>
        <textarea name="message" id="message" cols="30" rows="10" required><?= $contact['message'] ?? '' ?></textarea>
        <button>Envoyer</button>
    </form>
</body>

</html>