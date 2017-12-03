<?php 

function TestBlockHTML ($replStr) {
echo "<html>
    <body><h1>{$replStr}</h1>
    </body>
    </html>";
}

$ExampleInput="Test me out";
TestBlockHTML ($ExampleInput);

?>
