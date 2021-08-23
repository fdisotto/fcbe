#!/bin/bash

set -xe

/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
