# pvcCore

pvcCore is the core library under the pvc umbrella of code.  For details on installation, usage, etc., see the wiki page.

The core consists of the following major areas:

Errors and Exceptions.  These are 'branded' inside the pvc namespace so that it is possible to catch pvc exceptions specifically instead of all exceptions.

Messages.  There are ErrorException messages and User messages.

Parsers.  Parsers take a string as input and try to convert the string into a native php data type or perhaps an object.  
More generally, they convert strings into things that can be type hinted.  Typically used in the Controller area of an MVC framework, they take input and prepare it for loading
into the Model.

Validators.  These are context-free validators, typically used within the Model before the substance of a model's method responds.

Formatters.  Essentially the reverse of parsers, these objects take php data types and objects and convert them back into strings.

Sanitizers. These objects take strings and further transform them as necessary in order to be safely used within some output environment.  The obvious 
and most typical case is to sanitize a string for use within an html context.
