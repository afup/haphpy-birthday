![haphpy-birthday](https://cloud.githubusercontent.com/assets/5421942/8129742/720530c2-110c-11e5-870c-1c293960d87a.png)

HaPHPy Birthday is about creating a community video celebrating 20 years of the PHP language and its users involvement.

It aims at gathering a maximun of videos or pictures from the community in order to express the gratefulness of worldwide users to the PHP community in a short movie.

## Requirements

* Vagrant
* Vagrant plugin landrush or host manager

## Install

You need landrush to be installed

```
vagrant up
```

In your guest machine run the following command
```
composer install
```

## Usage

Accessing the web app

http://haphpy-birthday.dev

## Database

* root password: __afuprocks__
* database: __haphpy__
* user: __afup__
* password: __afup__


## Language

The only page where the locale is not enforced is on the `/` URL. When requested, that URL will try to find the best language available and redirect to `/{locale}/`.

The fallback locale is `en` (english), as this site is intended to gather PHP users from all around the world.

To add a supported locale:
* change the `accepted_languages` value in your `parameters.yml(.dist)`
* supply the correct localized files for entries located in `@AppBundle/Resources/translations`

## Contributing

Before commiting, be sure to run your tests:

```
bin/phpunit -v -c app/ src
```

and to check your Coding Standards:

```
bin/coke
```
