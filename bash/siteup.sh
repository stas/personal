#! /bin/bash 
# Script-ul creaza fisiere vhost pentru apache!
TARGETDIR="/etc/apache2/sites-available"
LOGSDIR="/var/log/apache2"
DOCROOT="/var/www"

function make_index
{
cat <<- _EOF_
	<html>
	<head><title>$DOMAIN</title></head>
	<body>Welcome to $DOMAIN</body> 
	</html>
_EOF_
} 

function make_vhost
{
cat <<- _EOF_
	<VirtualHost *>
	        ServerAdmin contact@$DOMAIN
	        ServerName $DOMAIN
	        ServerAlias *.$DOMAIN www.$DOMAIN

	        DirectoryIndex index.html index.htm index.php
	        DocumentRoot $DOCROOT/$DOMAIN/

	        ScriptAlias /cgi-bin/ $DOCROOT/$DOMAIN/cgi-bin/
	        <Location /cgi-bin>
	                Options +ExecCGI
	        </Location>

	        <Directory $DOCROOT/$DOMAIN/>
	                Options Indexes FollowSymLinks MultiViews
	                AllowOverride All
	                Order allow,deny
	                Allow from all
	        </Directory>

	        ErrorLog $LOGSDIR/$DOMAIN/error.log
	        CustomLog $LOGSDIR/$DOMAIN/access.log combined
	</VirtualHost>
_EOF_
}

if [ -z "$1" ]; then
	echo "Usage: siteup.sh domainname.tld"
	exit 0
else
	echo "-== Setting up vhost ==-"

	DOMAIN=$1
	TARGET=$TARGETDIR/vhost_for-$DOMAIN
	LOGS=$LOGSDIR/$DOMAIN

	echo "Setting up files for $DOMAIN"
	
	if [ -f $LOGS ]; then
		echo "Error: logs already exists in $TARGETDIR! Exiting..."
		exit 0
	fi

	if [ -f $TARGET ]; then
		echo "Error: vhost already exists in $TARGETDIR! Exiting..."
		exit 0
	else
		mkdir -vp $DOCROOT/$DOMAIN
		mkdir -vp $DOCROOT/$DOMAIN/cgi-bin
		mkdir -vp $LOGSDIR/$DOMAIN
		touch $LOGSDIR/$DOMAIN/access.log 
		echo "Created $LOGSDIR/$DOMAIN/access.log"
		touch $LOGSDIR/$DOMAIN/error.log 
		echo "Created $LOGSDIR/$DOMAIN/error.log"

		make_index > $DOCROOT/$DOMAIN/index.html
		echo "created $DOCROOT/$DOMAIN/index.html"

		make_vhost > $TARGET
		echo "Created $TARGET/$DOMAIN"
	fi

	echo "	$TARGETDIR/vhost_for-$DOMAIN"
	echo "	Enable vhost, then reload apache after all!"
	echo "	Finished setting up files for $DOMAIN."
	echo "-== Done! ==-"
fi
exit
