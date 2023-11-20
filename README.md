# ARBHUNTER.IO

-   [Developed by Guevara Web Graphics Studio](https://guevarawebgraphics.com)

## Setup Online Betting

Run the following command on separate terminals

-   php artisan optimize
-   php artisan queue:work --tries=3
-   php artisan queue:work --queue=sync_games --tries=3
-   php artisan queue:work --queue=sync_odds --tries=3
-   php artisan queue:work --queue=push_stream_odds --tries=3
-   php artisan websockets:serve

and

`php artisan migrate:fresh --seed`

`php artisan oddsjam_game_event_api:cron`

## Additional Dependencies

1. composer require livewire/livewire:^2.0

2. Laravel Queue & Websockets

## Recompile:

## If uploading changes into staging environment (with SSL Enabled)

1. npx webpack --mode=production
2. npm run dev
3. Activate HTACCESS force SSL
   s

## If local only

1. npx webpack --mode=development
2. npm run dev
3. Deactivate HTACCESS force SSL

## Cron Job for retrieving latest games

Staging or Production

`0 0 \* \* \* /user/bin/php /var/www/html/artisan oddsjam_game_event_api:cron`

## Local

`php artisan oddsjam_game_event_api:cron`

## Push Stream

`http://127.0.0.1/api/odds-push-streams`

`https://staging.arbhunter.io/api/odds-push-streams`

## Server

![image](https://github.com/guevarawebgraphics/oddsjam/assets/42199746/00859447-cc17-466f-b4a6-d8b69bf1bb85)

## Local Setup

1. php artisan migrate:fresh --seed
2. Execute these commands on separate bash terminals.

    - php artisan optimize
    - php artisan queue:work --tries=3
    - php artisan queue:work --queue=sync_games --tries=3
    - php artisan queue:work --queue=sync_odds --tries=3
    - php artisan queue:work --queue=push_stream_odds --tries=3
    - php artisan websockets:serve

3. Execute this command to retrieve games and odds per game

-   php artisan oddsjam_game_event_api:cron

4. If you want to receive real time response. Execute this curl command on your bash terminal (Optional)

-   curl http://127.0.0.1/api/odds-push-streams

## AWS SERVER SETUP

![image](https://github.com/guevarawebgraphics/oddsjam/assets/42199746/3f624b11-8510-4be5-b1b0-4edcf26900cf)

![image](https://github.com/guevarawebgraphics/oddsjam/assets/42199746/20bfe292-7537-41ec-aa1d-25684794ae52)

php artisan queue:work --tries=3

php artisan queue:work --queue=sync_games --tries=3

php artisan queue:work --queue=sync_odds --tries=3

php artisan queue:work --queue=sync_push_stream_odds --tries=3

php artisan websockets:serve

php artisan queue:clear

php artisan queue:clear --queue=sync_games

php artisan queue:clear --queue=sync_odds

php artisan queue:clear --queue=sync_push_stream_odds

### Configuration file for Websockets and Queue /etc/supervisor.d/queue.conf

[program:queue]
command=/usr/bin/php /var/www/html/artisan queue:work

numprocs=1

autostart=true

autorestart=true

user=ec2-user

[program:queue_sync_games]
command=/usr/bin/php /var/www/html/artisan queue:work --queue=sync_games

numprocs=1

autostart=true

autorestart=true

user=ec2-user

[program:queue_sync_odds]
command=/usr/bin/php /var/www/html/artisan queue:work --queue=sync_odds

numprocs=1

autostart=true

autorestart=true

user=ec2-user

[program:queue_sync_push_stream_odds]
command=/usr/bin/php /var/www/html/artisan queue:work --queue=sync_push_stream_odds

numprocs=1

autostart=true

autorestart=true

user=ec2-user

[program:websockets]
command=/usr/bin/php /var/www/html/artisan websockets:serve

numprocs=1

autostart=true

autorestart=true

user=ec2-user

### Supervisor Commands

## How to stop QUEUE & Websocket

`sudo supervisorctl stop queue`

`sudo supervisorctl stop queue_sync_games`

`sudo supervisorctl stop queue_sync_odds`

`sudo supervisorctl stop queue_sync_push_stream_odds`

`sudo supervisorctl stop websockets`

## How to start QUEUE & Websocket

`sudo supervisorctl start queue`

`sudo supervisorctl start queue_sync_games`

`sudo supervisorctl start queue_sync_odds`

`sudo supervisorctl start queue_sync_push_stream_odds`

`sudo supervisorctl start websockets`

## How to restart QUEUE & Websocket

`sudo supervisorctl restart queue`

`sudo supervisorctl restart queue_sync_games`

`sudo supervisorctl restart queue_sync_odds`

`sudo supervisorctl restart queue_sync_push_stream_odds`

`sudo supervisorctl restart websockets

### NoHup for Push Stream API

This file `stream.sh` is located on our root directory.

![image](https://github.com/guevarawebgraphics/oddsjam/assets/42199746/d74062bc-68c4-4306-99fd-28b34b8b096e)

This will run the push stream api so that we can receive real time updates from OddsJam into Arbhunter.IO

![image](https://github.com/guevarawebgraphics/oddsjam/assets/42199746/d851930e-6936-4c74-8dcd-618599449112)
