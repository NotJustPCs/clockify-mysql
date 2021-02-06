# Copy Clockify data into MySQL db

Does what it says on the tin, but also uses webhooks to trigger smaller data loads.

Written by @i1yaz
Comissioned by @foshdafosh

## Installation:
* Run composer update
* Edit config.ini as appropriate
* Add webhooks to Clockify
### Webhook examples
* Time started me = http://clockify-mysql.com/my-timer-started
* Time started anyone = http://clockify-mysql.com/timer-started
* Time stopped me = http://clockify-mysql.com/my-timer-stopped
* Time stopped anyone = http://clockify-mysql.com/timer-stopped
* Time entry created manually me = http://clockify-mysql.com/my-time-entry-created-manually
* Time entry created manually anyone = http://clockify-mysql.com/time-entry-created-manually
* Time entry updated manually me = http://clockify-mysql.com/my-time-entry-updated
* Time entry updated manually anyone = http://clockify-mysql.com/time-entry-updated
* Time entry updated deleted me = http://clockify-mysql.com/my-time-entry-deleted
* Time entry updated deleted anyone = http://clockify-mysql.com/time-entry-deleted
* Client created = http://clockify-mysql.com/client-created
* Project created = http://clockify-mysql.com/project-created
* Task created = http://clockify-mysql.com/task-created
* Tag created = http://clockify-mysql.com/tag-created
* Fetch all data = http://clockify-mysql.com/
