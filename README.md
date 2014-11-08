YouTube Subscriptions for Slack
=========

YouTube Subscription is a Slack Integration to follow and notify about channel posts.


## Requirements

This plugin requires a webserver running a recent version of PHP and the Hammock API.  
For integrations that require polling, this case, `cron` is also required.


## Installation

* Make a clone of the Hammock git repository onto your web server
* Configure the Hammock as described in https://github.com/tinyspeck/hammock
* Clone the `YouTube Subscription for Slack` inside the *plugins* folder
* Visit `index.php` in your browser and start configuring the integration


At the end of configuration you'll need to append a call on your system crontab:

    30 * * * * curl -s http://localhost/hammock/plugins/youtube_subscriptions/crontab.php


## Screenshots