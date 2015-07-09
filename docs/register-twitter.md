# Authorizing the application in Twitter

:warning: Authorizing the app on Twitter requires your phone number to be activated in your Twitter account. :weary:

:information_source: Twitter authorize your app on a single URL. Exemple provided here for http://haphpy-birthday.dev/

If you plan to work on http://haphpy-birthday.dev/app_dev.php, just adapt the information provided.

---

1. Log in to your [Twitter](https://twitter.com/) account.
2. Go to [Applications Registering page](https://apps.twitter.com/app/new).
3. Fill the form as follows:
![twitter-app](https://cloud.githubusercontent.com/assets/5421942/8600755/ed6013e8-2667-11e5-97f1-0a4bd47a9f8c.png)

4. Validating the form will show you the `Consumer Key (API Key)` you need for __twitter_client_id__ and  the `Consumer Secret (API Secret)` for __twitter_secret__.
6. Running `composer install` for the first time, provide the tokens when asked.

> If your `app/config/parameters.yml` has already been generated, just replace the `twitter_client_id` and `twitter_secret` values in it.

---

Copy/paste helper :wink: :

Twitter field | Value
--------------|------
Application name | __HaPHPy Birthday__
Homepage URL | __http://haphpy-birthday.dev__
Application description | __A commemorative and collaborative movie for the 20th anniversary of the PHP language.__
Authorization callback URL | __http://haphpy-birthday.dev/login/check-twitter__
