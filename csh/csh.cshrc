# $FreeBSD: src/etc/csh.cshrc,v 1.3 1999/08/27 23:23:40 peter Exp $
#
# System-wide .cshrc file for csh(1).
if ($?prompt) then
    set prompt = "%B[%n@%m]%b:%~%# "
    set autolist
endif

