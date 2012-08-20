# AWK Script for extracting the individual fields of priorities.txt
#
# Created on: 2012-08-02
#
# This script will extract the needed fields and output them as
# AutoGen definitions.
# priorities.txt was simply created by copy and pasting the
# table from the PHP.net manual into a text file.

BEGIN {
	# Definie format for AutoGen definition,
	# ORS adds a newline
	autogen_def = "priorities={id=%s;name=%s;description=\"%s\";};" ORS

	# Output header:
	print "autogen definitions logmorebase;"
}

{
	# Extract constant-name:
	id = $1

	# Create a more readable name:
	split($1, idparts, "_")
	name = idparts[2]
	name = tolower(name)

	# Compile description:
	description = ""
	for (i = 2; i<= NF; i++) {
		# Add whitespace between words:
		if (description) {
			description = description " "
		}

		# Add word:
		description = description $i
	}

	# Output AutoGen definition:
	printf(autogen_def, id, name, description)
}
