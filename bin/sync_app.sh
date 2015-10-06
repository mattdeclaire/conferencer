WEEBLY_SITE_ID=`php -r 'include "config.php"; echo WEEBLY_SITE_ID;'`
WEEBLY_TOKEN=`php -r 'include "config.php"; echo WEEBLY_TOKEN;'`
export WEEBLY_SITE_ID=$WEEBLY_SITE_ID
export WEEBLY_TOKEN=$WEEBLY_TOKEN
weeblybundle app app