<?php
http_response_code(403);

require_once __DIR__ . '/header.php'; ?>

<div class="container">
    <h1 class="text-center">403 Interdit</h1>
</div>




<?php
require_once __DIR__ . '/footer.php';
exit; //Permet d'étre sur que le code s'arréte
?>