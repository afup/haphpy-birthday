# Authorizing the application in GitHub

1. Log in to your [GitHub](https://github.com/) account.
2. Go to [Developer applications settings](https://github.com/settings/developers).
3. Then `Register new application` (upper right corner).
4. Fill the form as follows:
![register-application](https://cloud.githubusercontent.com/assets/5421942/8394001/d5ef7798-1d26-11e5-911a-962391e4ee1b.png)


5. Validating the form will show you the `Client Id` and  `Client secret` tokens.
6. Running `composer install` for the first time, provide the tokens when asked.

> If your `app/config/parameters.yml` has already been generated, just replace the `github_client_id` and `github_secret` values in it.