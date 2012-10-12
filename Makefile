# Central file for compiling logmore
#
# Created on: 2012-08-02

AWK = /usr/bin/awk
CAT = /bin/cat
ECHO = /bin/echo
MV = /bin/mv
CURL = /usr/bin/curl
MKDIR = /bin/mkdir
TMPDIR = /tmp
AUTOGEN = /usr/bin/autogen
NATURALDOCS = /usr/bin/naturaldocs
BUILDDIR = buildsrc
extract = $(BUILDDIR)/extract.awk
priorities = $(BUILDDIR)/priorities.txt
template = $(BUILDDIR)/logmorebase.tpl
testtemplate = $(BUILDDIR)/test.tpl
more = $(BUILDDIR)/logmore.php
logbasedef = $(BUILDDIR)/logmorebase.def
base = logmorebase.php

main: 	base testfiles $(base) $(more)
	@echo "Joining PHP files..."
	$(ECHO) "<?php" > logmore.php
	$(CAT) $(base) $(more) >> logmore.php
	@echo "Move to final destination..."
	$(MV) logmore.php src/LogMore.php

install:
	$(CURL) https://raw.github.com/codeless/nd2md/master/nd2md.sh > nd2md.sh
	chmod ugo+x nd2md.sh

base: 	$(priorities) $(extract) $(template)
	@echo "Extracting priorities..."
	$(AWK) -f $(extract) $(priorities) > $(logbasedef)
	@echo "Generating logbase.php file..."
	$(AUTOGEN) -T $(template) $(logbasedef)

doc: 	src/LogMore.php README.txt install mddoc
	@echo "Make doc-directory..."
	$(MKDIR) doc
	$(NATURALDOCS) -i . -o HTML doc/ -p .

mddoc: 	HISTORY.txt README.txt
	@echo "Generate markdown doc..."
	./nd2md.sh README.txt > README.md
	./nd2md.sh HISTORY.txt > HISTORY.md

testfiles:
	@echo "Creating test-directory if not present..."
	$(MKDIR) -p tests
	@echo "Compiling test-script..."
	$(AUTOGEN) -T $(testtemplate) -b LogMoreTest $(logbasedef) 
	@echo "Moving test-script to test-directory..."
	$(MV) LogMoreTest.php tests/

test:
	phpunit

clean:
	@echo "Cleaning up..."
	rm -fr logmorebase.php tests/ $(logbasedef) Data/ doc/ Languages.txt Menu.txt Topics.txt nd2md.sh
