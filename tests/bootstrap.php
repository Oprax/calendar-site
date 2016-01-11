<?php

passthru("./artisan --quiet migrate:reset");
passthru("./artisan --quiet migrate");

require __DIR__.'/../bootstrap/autoload.php';
