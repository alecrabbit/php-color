include ${_APP_DIR}/app.init.Makefile
include ${_APP_DIR}/phpinsights.Makefile
include ${_APP_DIR}/tests.Makefile
include ${_APP_DIR}/phploc.Makefile

##
## —— Application 📦 ———————————————————————————————————————————————————————————

a_tools_run: test_full a_phploc_run a_php_cs_fixer_run a_deptrac_run_full a_psalm_run a_utils_run ## Run all tools
	@${_NO_OP};
