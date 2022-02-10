m:
	php bin/migrate.php
cs:
	bin/php-cs-fixer/vendor/bin/php-cs-fixer fix src
cs-dry-run:
	bin/php-cs-fixer/vendor/bin/php-cs-fixer fix --verbose --dry-run