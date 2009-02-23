#!/bin/bash
# IPTABLES script pentru baikonur si containere!

# IF-ul extern
IFNET="eth0"
# IP-ul extern
IPNET="193.226.6.232"
# Port-urile deschise
SERVICII="http https smtp 8000 8001 8002 8003"

if [ "$1" = "start" ]; then
	echo "Pornesc iptables"
	
	# Blocare tot
	iptables -P INPUT DROP
	# Permitem trafic prin orice IF mai putin cel extern
	iptables -A INPUT -i ! ${IFNET} -j ACCEPT
	# Permite pachetele din conexiunile deja stabilite
	iptables -A INPUT -m state --state ESTABLISHED,RELATED -j ACCEPT
	# Permite icmp (ping request/reply)
	iptables -A INPUT -p icmp -j ACCEPT
	iptables -A OUTPUT -p icmp -j ACCEPT

	# Accepta conexiuni noi pe porturile specificate
	for i in ${SERVICII}; do
		iptables -A INPUT -p tcp --dport ${i} -m state --state NEW -j ACCEPT
	done

	# NAT-are.
	iptables -t nat -A POSTROUTING -s 192.168.0.0/24 -o eth0 -j SNAT --to 193.226.6.232

	# Webserver-ul e pe main. El va face proxy la celelalte instante de pe celelalte masini.
	iptables -t nat -A PREROUTING -p TCP -d $IPNET --dport 80 -j DNAT --to-destination 192.168.0.101:80
	iptables -t nat -A PREROUTING -p TCP -d $IPNET --dport 443 -j DNAT --to-destination 192.168.0.101:443
	# Mail server-ul e pe main.
	iptables -t nat -A PREROUTING -p TCP -d $IPNET --dport 25 -j DNAT --to-destination 192.168.0.101:25
	# Forwarding ssh la main.
	iptables -t nat -A PREROUTING -p TCP -d $IPNET --dport 8001 -j DNAT --to-destination 192.168.0.101:22
	# Forwarding ssh la narro.
	iptables -t nat -A PREROUTING -p TCP -d $IPNET --dport 8002 -j DNAT --to-destination 192.168.0.102:22
	# Forwarding la ubuntu.ro.
	iptables -t nat -A PREROUTING -p TCP -d $IPNET --dport 8003 -j DNAT --to-destination 192.168.0.103:22

	# Log-uri
	iptables -I INPUT 5 -m limit --limit 5/min -j LOG --log-prefix "iptables denied: " --log-level 7

fi # end if start

if [ "$1" = "stop" ]; then
	echo "Opresc iptables"

	iptables -F
	iptables -X
	iptables -t nat -F
	iptables -t nat -X
	iptables -t mangle -F
	iptables -t mangle -X
	iptables -P INPUT ACCEPT
	iptables -P FORWARD ACCEPT
	iptables -P OUTPUT ACCEPT

fi # end if stop
