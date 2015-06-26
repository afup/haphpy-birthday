![haphpy-birthday](https://cloud.githubusercontent.com/assets/5421942/8129742/720530c2-110c-11e5-870c-1c293960d87a.png)

HaPHPy Birthday is about creating a community video celebrating 20 years of the PHP language and its users involvement.

It aims at gathering a maximun of videos or pictures from the community in order to express the gratefulness of worldwide users to the PHP community in a short movie.

## Requirements

* Vagrant
* Vagrant plugin landrush or host manager

## Befor you start

* All commands that should be executed **on your machine** are prefixed by `$`
* All commands that should be executed **on the VM** are prefixed by `⇒`

## Install

You need landrush to be installed.

```shell
$ vagrant up
```

Get in the Vagrant VM, in the app folder:
```shell
$ vagrant ssh
⇒ cd /vagrant
```

In your guest machine run the following command:
```shell
⇒ composer install
```

#### Building database structure
```shell
⇒ php app/console doctrine:schema:update --force
```

#### Generating fake contributions for development

Checkout the `dev/generate-contributions` branch in your repository.
```shell
$ git checkout dev/generate-contributions
```

In the guest machine, in the `/vagrant` directory then run the following command
```shell
⇒ php app/console haphpy:contributions:generate <quantity>
```
the optional `quantity` parameter can be set up to 768. It defaults to 100.

> :warning: Currently, the command does not clean either the database or the file system from old contributions.

> Here are the commands to run in your guest machine:
```shell
⇒ rm -rf /var/haphpy/contributions/*/*
```
And for the database
```shell
⇒ mysql -u afup -p -e 'DELETE FROM contribution' haphpy
```
password: __afup__

## Usage

Accessing the web pages

http://haphpy-birthday.dev

## Database

* root password: __afuprocks__
* database: __haphpy__
* user: __afup__
* password: __afup__


## Contributing

Before commiting, be sure to run your tests:

```shell
⇒ bin/phpunit -v -c app/ src
```

and to check your Coding Standards:

```shell
⇒ bin/coke
```

## More documentation
* [Languages & Translations](docs/languages-and-translations.md)
* [Participating as a PHP User Group](docs/php-user-groups.md)
