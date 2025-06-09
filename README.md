## Setup instructions
### System Requirements
1. PHP v.8.4.5
2. Node.js v.18+
3. NPM v.11.2.0
4. MySQL Server v.8.0
5. Composer v.2.0+

#### Laravel
- `composer install --optimize-autoloader --no-dev`
- `cp .env.example .env`
- modify **.env**
    1. Set **APP_URL** to current URL
    2. Set **DB_***
- `php artisan migrate`
- `php artisan key:generate`

#### Deployment Options
For local:
- `php artisan serve` or docker-compose up -d or **nginx** setup 

For production:
1. **nginx** setup
2. cron: `* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1`

#### Vue
- `npm install`
