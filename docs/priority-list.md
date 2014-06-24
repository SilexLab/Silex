Priority list
=============
				+ Dependencies
				  -			None
				  ?			unknown
				  ?<class>	maybe
				  +<class>	not at the initialization

- database		+ -
- config		+ database
- session		+ config, database
  - login		+ ?
- language (o)	+ config, ?database
- url			+ config
- navigation	+ language, +page
- page			+ config
- style			+ config, ?database, ?user
- template		+ -
