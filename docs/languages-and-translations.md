## Languages

The default and fallback language is `en` (english), as this site is intended to gather PHP users from all around the world.

The only page where the locale is not enforced is on the `/` URL. When requested, that URL will try to find the best available language and redirect to `/{locale}/`.

## Translations

In order to widen the visibility of the project internationally, any new language is welcome.

Here are the steps you need to go through in order to add a new supported locale to the project:
* Add an entry to the `accepted_languages` param in your `parameters.yml(.dist)`
* Supply the correct localized file located in `@AppBundle/Resources/translations`
* Complete the `@AppBundle/Resources/config/routing.yml` to provide localized routes.
