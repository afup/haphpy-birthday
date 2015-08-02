# Authorizing the application in Facebook

:warning: Authorizing the app on Facebook requires you turn your account in a developer one.

:information_source: Facebook authorize your app on a single URL. Exemple provided here for http://haphpy-birthday.dev/

If you plan to work on http://haphpy-birthday.dev/app_dev.php, just adapt the information provided.

---

1. Log in to your [Facebook](https://facebook.com/) account.
2. Go to [Applications Registering page](https://developers.facebook.com/quickstarts/).
3. Choose Website.
4. Fill up the name __HaPHPy Birthday [Dev]__ and click `Create new Facebook App Id`.
5. Choose the category (I chose `video` but whatever…) and validate by clicking `Create App ID`<div class=""></div>
6. Fill the field `Site URL` with __http://haphpy-birthday.net__.
7. Then click `next` and `Skip to developer dashboard` at the bottom of the page.
8. At this point, the dashboard should show you the __App ID__ and the __App Secret__ (obfuscated).
9. Running `composer install` for the first time, provide the APP ID for the __facebook_client_id__ and the App Secret for the __facebook_client_secret__.

> If your `app/config/parameters.yml` has already been generated, just replace the `facebook_client_id` and `facebook_secret` values in it.
