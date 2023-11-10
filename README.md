# ARBHUNTER.IO

-   [Developed by Guevara Web Graphics Studio](https://guevarawebgraphics.com)

## Setup Online Betting

Run php artisan migrate:fresh --seed
Run `php artisan oddsjam_game_event_api:cron`

## Additional Dependencies

1. composer require livewire/livewire:^2.0

2. Laravel Queue & Websockets - create separate terminals and execute these commands separately

-   php artisan queue:work
-   php artisan queue:work --queue=sync_games
-   php artisan queue:work --queue=sync_odds
-   php artisan queue:work --queue=push_stream_odds
-   php artisan websockets:serve

-   php artisan queue:clear database sync_games
-   php artisan queue:clear database push_stream_odds

## Recompile:

## If uploading changes into staging environment (with SSL Enabled)

1. npx webpack --mode=production
2. npm run dev
3. Activate HTACCESS force SSL

## If local only

1. npx webpack --mode=development
2. npm run dev
3. Deactivate HTACCESS force SSL

## Cron Job for retrieving latest games

Staging or Production

0 0 \* \* \* /user/bin/php /var/www/html/artisan oddsjam_game_event_api:cron

## Local

php artisan oddsjam_game_event_api:cron

## Push Stream

http://127.0.0.1/api/odds-push-streams

https://staging.arbhunter.io/api/odds-push-streams

## Server

![image](https://github.com/guevarawebgraphics/oddsjam/assets/42199746/00859447-cc17-466f-b4a6-d8b69bf1bb85)
