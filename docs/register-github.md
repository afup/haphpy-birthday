# Authorizing the application in GitHub

:information_source: GitHub authorize your app on a single URL. If you plan to work on http://haphpy-birthday.dev/app_dev.php, just adapt the information provided.

---

1. Log in to your [GitHub](https://github.com/) account.
2. Go to [Developer applications settings](https://github.com/settings/developers).
3. Then `Register new application` (upper right corner).
4. Fill the form as follows:
![register-app](https://cloud.githubusercontent.com/assets/5421942/8397187/0a7d600a-1dc3-11e5-95c3-45b77d3c0c91.png)
5. Validating the form will show you the `Client Id` and  `Client secret` tokens.
6. Running `composer install` for the first time, provide the tokens when asked.

> If your `app/config/parameters.yml` has already been generated, just replace the `github_client_id` and `github_secret` values in it.

---

Copy/paste helper :wink: :
* Application name: __HaPHPy Birthday__
* Homepage URL: __http://haphpy-birthday.dev__
* Application description: __A commemorative and collaborative movie for the 20th anniversary of the PHP language.__
* Authorization callback URL: http://haphpy-birthday.dev/login/check-github
