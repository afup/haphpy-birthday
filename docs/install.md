# Development Environment

## Requirements

* Vagrant
* Vagrant plugin landrush or host manager
* You need to activate OAuth for any of the following social network you want to use:
  * [Enabling Github OAuth (step by step)](register-github.md)
  * [Enabling Twitter OAuth (step by step)](register-twitter.md)
  * [Enabling Facebook OAuth (step by step)](register-facebook.md)


## Before you start

* All commands that should be executed **on your machine** are prefixed by `$`
* All commands that should be executed **on the VM** are prefixed by `⇒`

---

## Install

```shell
$ vagrant up
```

Get in the Vagrant VM, in the app folder:
```shell
$ vagrant ssh
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
⇒ mysql -u afup -p -e 'DELETE FROM contribution' haphpy;
```
password: __afup__

---

## Accessing dev pages

Accessing the web pages

* prod like: [http://haphpy-birthday.dev](http://haphpy-birthday.dev)
* dev (debug): [http://haphpy-birthday.dev/app_dev.php](http://haphpy-birthday.dev/app_dev.php)

---

## Database

* root password: __afuprocks__
* database: __haphpy__
* user: __afup__
* password: __afup__

---

## Workflow

Before committing, be sure to run the tests:

```shell
⇒ bin/phpunit -v -c app/ src
```

and to check the Coding Standards:

```shell
⇒ bin/coke
```
