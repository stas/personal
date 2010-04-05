#! /bin/bash 
TARGETDIR="/etc/apache2/sites-available"

function make_vhost
{
cat <<- _EOF_
<Virtualhost *>
	DocumentRoot "/var/www/"
	ServerName $DOMAIN
	ServerAdmin contact@$DOMAIN
	DirectoryIndex index.html index.php
	ProxyRequests Off
	ProxyPreserveHost On
	ProxyVia full

	<proxy>
		Order deny,allow
		Allow from all
	</proxy>

	ProxyPass / http://$IP/
	ProxyPassReverse / http://$IP/
</Virtualhost>
_EOF_
}

if [ -z "$1" ]; then
	echo "Usage: $0 domainname.tld target-domain-ip"
	exit 0
fi
if [ -z "$2" ]; then
	echo "Usage: $0 domainname.tld target-domain-ip"
	exit 0
else
	DOMAIN=$1
	IP=$2
	TARGET=$TARGETDIR/$DOMAIN

	echo "Setting up vhost for $DOMAIN..."

	if [ -f $TARGET ]; then
		echo "Error: vhost already exists in $TARGETDIR! Exiting..."
		exit 0
	else
		make_vhost > $TARGET
	fi

	echo "Enable vhost and reload apache after."
	echo "Done."
fi
exit
