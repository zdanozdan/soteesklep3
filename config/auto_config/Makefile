light:
	@cp nccp_config.inc.php.light  nccp_config.inc.php
	if [ -f .version.expert ]; then rm .version.expert; fi
	@touch .version.light

expert:
	@cp nccp_config.inc.php.expert nccp_config.inc.php
	if [ -f .version.light ]; then rm .version.light; fi
	@touch .version.expert
 
clean_versions:
	if [ -f nccp_config.inc.php.expert ]; then rm nccp_config.inc.php.expert; fi
	if [ -f nccp_config.inc.php.light ]; then rm nccp_config.inc.php.light; fi
