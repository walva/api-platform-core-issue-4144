# api-platform-core-issue-4144

[Issue #4144 : Comparing with Null Values doesn't work with embeddables](https://github.com/api-platform/core/issues/4144)

## How to run

* setup the project

```sh
git clone https://github.com/walva/api-platform-core-issue-4144.git
composer install
bin/console doctrine:database:create
bin/console doctrine:schema:create
bin/console hautelook:fixtures:load
php -S 127.0.0.1:8000 -t public
```

* edit manually the data: update book#2 in order to set a null value

```curl
curl -X PATCH "http://127.0.0.1:34623/api/books/2" -H  "accept: application/ld+json" -H  "Content-Type: application/merge-patch+json" -d "{\"rankings\":{\"trendy\":null}}"
```

* navigate in the API: http://127.0.0.1:8000/api/books.json?order[rankings.trendy]=DESC

* 🆗 game#2 should appear first thanks to

```php
#[ApiFilter(OrderFilter::class, properties: [
    'rankings.trendy' => [
        'nulls_comparison' => OrderFilter::NULLS_LARGEST,
    ],
])]
```

🛑 Instead, it throws a **Doctrine\ORM\Query\QueryException**

    [Syntax Error] line 0, col 85: Error: Expected Doctrine\ORM\Query\Lexer::T_FROM, got '.'

## Recipe

```
composer create-project symfony/skeleton bug-embeddable-filter
cd bug-embeddable-filter
composer require api
composer require make
composer require --dev profiler
php bin/console make:entity
	> Book
	> yes
	> name
	> string
	> 255
	> yes
php bin/console make:entity
	> Ranking
	> yes
	> trendy
	> integer
	> yes
	> popular
	> integer
	> yes
composer require --dev alice
bin/console doctrine:database:create
bin/console doctrine:schema:create
bin/console hautelook:fixtures:load
php -S 127.0.0.1:8000 -t public
```