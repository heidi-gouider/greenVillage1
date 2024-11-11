<?php

require 'vendor/autoload.php';

use App\Form\ProfilFormType;

if (class_exists(ProfilFormType::class)) {
    echo "La classe ProfilFormType a été trouvée et chargée correctement.";
} else {
    echo "La classe ProfilFormType n'a pas été trouvée.";
}
