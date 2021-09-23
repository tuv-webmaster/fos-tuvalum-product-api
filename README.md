## TOC

# tuvalum-product-api

Access to Tuvalum product catalog and their product descriptions.

## Requisites

 * Docker
 * Docker Compose
 * make (Optional)


## Installation

### With Make

```bash
make install
```

### Without Make

```bash
docker-compose build
docker-compose up -d
docker-compose exec php-fpm composer install --prefer-dist && bin/phpunit install
docker-compose exec php-fpm bin/console doctrine:migrations:migrate --no-interaction
docker-compose exec php-fpm /bin/sh

# Make is available in the container
/usr/bin/make jwt-rsa
```

## Dependencies

 * **php 7.4**
 * ext-ctype
 * ext-iconv
 * ext-intl
 * composer/package-versions-deprecated
 * crell/api-problem
 * doctrine/doctrine-bundle
 * doctrine/doctrine-migrations-bundle
 * doctrine/orm
 * jms/serializer-bundle
 * lexik/jwt-authentication-bundle
 * mark-gerarts/automapper-plus-bundle
 * nelmio/api-doc-bundle
 * nelmio/cors-bundle
 * ramsey/uuid-doctrine
 * symfony/asset
 * symfony/console
 * symfony/dotenv
 * symfony/flex
 * symfony/framework-bundle
 * symfony/intl
 * symfony/messenger
 * symfony/monolog-bundle
 * symfony/phpunit-bridge
 * symfony/property-info
 * symfony/proxy-manager-bridge
 * symfony/translation
 * symfony/twig-bundle
 * symfony/validator
 * symfony/yaml
 * twig/extra-bundle
 * twig/twig
 * willdurand/hateoas-bundle

### Doctrine
ORM to access main application database, datamapper library compatible with almost all major SQL distributions, and, some Document databases as Mongo.

[https://www.doctrine-project.org/](https://www.doctrine-project.org/)

### lexik/jwt-authentication-bundle

Symfony based library to perform API authentication using standard JWT tokens.

[https://github.com/lexik/LexikJWTAuthenticationBundle](https://github.com/lexik/LexikJWTAuthenticationBundle)

### nelmio/api-doc-bundle

Symfony based library to create [Swagger](https://swagger.io/specification/) compliant documentation, based on annotations or configuration. It also provides a web interface to access the docs and test the endpoints. This library is compatible with doctrine and fos-rest-bundle.

### willdurand/hateoas-bundle

Library to configure Dtos HATEOAS information. It will render relationships data into Json arrays, and it will provide the component used to create data pagination objects.

[https://github.com/willdurand/Hateoas](https://github.com/willdurand/Hateoas)


### jms/serializer-bundle

Serializer to transform Json messages into PHP objects and viceversa. It will transform requests data into Dtos.

[https://jmsyst.com/libs/serializer](https://jmsyst.com/libs/serializer)

### symfomy/validator

This component will help to validate all requests data before passing it to the Domain layer.

[https://symfony.com/doc/4.4/validation.html](https://symfony.com/doc/4.4/validation.html)

### nelmio/cors-bundle
Configures [cross origin resource sharing](https://en.wikipedia.org/wiki/Cross-origin_resource_sharing) for the API.

[https://github.com/nelmio/NelmioCorsBundle](https://github.com/nelmio/NelmioCorsBundle)

### ramsey/uuid-doctrine

It provides a custom GUID object and prepares doctrine for using this objects as internal table attributes. It has factories to create different kinds of standard GUID's

GUID's will be used as unique keys for the exposed resources, to keep the database indexes protected and simple enough to guarantee the performance. They will be stored as Binary data and read as Ramsey GUID objects

[https://github.com/ramsey/uuid](https://github.com/ramsey/uuid)


### symfony/messenger
Symfony component to create a software communications Bus to allow responsibility segregation. It's compatible with all mainstream Message Buses on market.

[https://symfony.com/doc/4.4/messenger.html](https://symfony.com/doc/4.4/messenger.html)

## Configuration

## Usage

In order to access the product API it can be accessed using port 8081, http://localhost:8081

### Swagger
A swagger documentation page is available on http://localhost:8081/api/doc .

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License

Copyright (c) 2021 Tuvalum  -  All  Rights  Reserved

Unauthorized  copying, reproduction, distribution, broadcasting or disclosure
of this file, via any mean  is strictly prohibited.
The herein material is proprietary and confidential, and is subject to the current
legal notice in its containing repository  and  at https://tuvalum.com .

For  further  information  please  email: webmaster@tuvalum.com


