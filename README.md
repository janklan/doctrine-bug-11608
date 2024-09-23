# Association indexing bug reproducer

## What's happening

1. The `Plan::$subscription` collection uses custom `indexBy` to allow fetching a `Subscription` using a Customer ID when known.
1. The value of `indexBy` is deceiving because it matches the name of the property but not the name of the DB column
1. As a result, Doctrine fails to set the collection index, falling back to numeric indexes as if the `indexBy` wasn't used.

## Consequence

1. Hard-to-debug errors when using Collection methods working with the keys

## What's wrong

1. I expected `bin/console doctrine:schema:validate` to pick up on this misconfiguration

## How to run this

1. `composer install`
1. `docker compose start`
1. `bin/console doctrine:database:create --env=test`
1. `bin/console do:sch:up --force --env=test`
1. `bin/phpunit`

## Related issues

I reckon this one is quite relevant https://github.com/doctrine/orm/issues/4203
