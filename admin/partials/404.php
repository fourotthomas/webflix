<?php
http_response_code(404);

require_once __DIR__ . '/header.php'; ?>

<div class="container">
    <h1 class="text-center">404 non trouvé</h1>
</div>




<?php
require_once __DIR__ . '/footer.php';
exit; //Permet d'étre sur que le code s'arréte
?>