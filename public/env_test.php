<?php
echo "getenv('DB_HOST'): "; var_dump(getenv('DB_HOST')); echo "\n";
echo "_SERVER['DB_HOST']: "; var_dump(isset($_SERVER['DB_HOST']) ? $_SERVER['DB_HOST'] : null); echo "\n";
echo "_ENV['DB_HOST']: "; var_dump(isset($_ENV['DB_HOST']) ? $_ENV['DB_HOST'] : null); echo "\n";
