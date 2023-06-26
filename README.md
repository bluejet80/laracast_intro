
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


