
# First Stuff

to install a tailwind plugin while using the CDN

in the script tag where you src tailwind CDN just add `?plugins=forms`

manually submitting the form

curl -X POST http://localhost:1234/notes/create -d 'body=Hello+there'

# Move Root Directory

To move the root directory

php -S localhost:1234 -t public

This changes the document root to the public folder

# Lazily Load Files 

lazily and automatically load classes when you need them
Meaning we want to require these classes only when we instantiate them or need them.
only when we create an instance of them.

1. remove the Database and Response requires in the index.php

2. then intead of these requires we will call a php function `spl_autoload_register()`

This function takes as its first parameter a function to which we will pass a $class and 
immediately we will dd() that $class so that we can see what is happening. 

So basically this function is called only when we need a certain class. So it is doing
exactly what we wanted to do. 

Actually what is happening is PHP doesnt know what the Class is and so its trying to 
track it down by running this function. So this function would be run when you 
instanciate a class and its undefined to php. 

By setting up this functio we have 'declared' oyur implementation for how we should 
auto-load files that arnt immediately available.

Now we must figure out what is the logic? What should we do? 

So the first thing to do is what we were doing before. Require the class. 

and that is it. Now everything is working fine. 

This function is something that allows us to determine what happens when a file is 
not immediately available. 

# Name Spacing

First thing we will do is create name spaces for our classes in the Core directory.

we do this by typing `namespace Core` at the top of the file below the php tag

once we do this everything breaks of course because we moved the database class into
a completely different name space. 

to fix this lests go to where the class is being instanciated and add `Core\` in
front of it. That is a backslash not a forward slash.

Another way to do it is to type `use Core\Database` at the top of the file. 

Then you can leave the other entry as it was.

Now this has also broken our Lazy Loader Function so we will have to refactor it.

So now in order to fix our lazy loader we have to turn `Core\Database` into `Core/Database`

and we do that using the `str_replace()` php function. Its arguments in order are
The pattern to match, the string we want to replace the pattern with, and the original string

`str_replace($search, $replace, $subject)`

## Problem with the PDO Class

Now since we are calling the PDO class inside the Database file which we put 
`namespace Core` at the top of, now all class declarations in this file are 
going to default to the Core namespace. The PDO class is part of the Global
Namespace. So to fix this we will put a `\` backslash infront of the PDO 
declarations and then it will know to look in the global namespace. 

OR... 

We can type `use PDO` at the top of the file and that fixes the problem as well.
And seeing this is kinda like documentation telling you that this class is used in this 
file. 

So now we will be seeing these `use Class` statements at the beginning of files
often,

# Request Types

A question that you must ask yourself when thinking about request types, is the 
request idempotent? If something is idempotent that  means when you make a request 
to it, does it actually change anything. Like a GET request to view a page, this is 
idempotent. But a request to create a note, or delete a note, or update a note...
All of these things are not idempotent. So you should use something other than a 
GET request for these. 

Of course we already know about all the request types POST, DELETE, PUT, PATCH that 
can be used.


## Updating the Router to handle Request Types




# Service Containers






