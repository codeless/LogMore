# Central file for compiling logmore
#
# Created on: 2012-08-02

AWK = /usr/bin/awk
CAT = /bin/cat
MV = /bin/mv
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
	$(CAT) $(base) $(more) > logmore.php
	@echo "Move to final destination..."
	$(MV) logmore.php src/LogMore.php

base: 	$(priorities) $(extract) $(template)
	@echo "Extracting priorities..."
	$(AWK) -f $(extract) $(priorities) > $(logbasedef)
	@echo "Generating logbase.php file..."
	$(AUTOGEN) -T $(template) $(logbasedef)

doc: 	src/logmore.php README.txt
	@echo "Make doc-directory..."
	$(MKDIR) doc
	$(NATURALDOCS) -i . -o HTML doc/ -p .

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
	rm -fr logmorebase.php tests/ $(logbasedef) Data/ doc/ Languages.txt Menu.txt Topics.txt
