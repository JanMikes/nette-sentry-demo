Easy and fast integration of Sentry into Nette 3 project
=================

Check files, where the magic happens:
- `app/config/common.neon`
- `app/Logging/SentryDecoratedTracyLogger.php`

Do not forget to set DSN in your `app/config/local.neon`:
```yaml
parameters:
    sentry:
        dsn: 'https://xyz@sentry.io/xyz'
```
