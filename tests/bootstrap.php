<?php

require __DIR__.'/../bootstrap/autoload.php';

passthru("./artisan --quiet migrate:reset");
passthru("./artisan --quiet migrate");
