
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

In this lesson we basically re-made Express in PHP




# Service Containers

First of all, the purpose of this service container is to prevent from having to
create an instance of the database everytime we need to use it. To prevent us
from having this code at the top of each file that get information from the
database. 

```

    $config = require base_path("config.php");

    $db = new Database($config['database'], $config['auth']['user'],$config['auth']['password']);



```

So we dont want to have to instantiate our database calss just to execute some 
SQL query. 

So basically what we want is to instantiate it once and then throw it into a
container and then pull it out whenever we need it. 


## playground

In order to test this new container it would be nice to have a file to do so in.

So lets make a file `bootstrap.php` and then import it into our index.php file.

Right beneith the `spl_autoload_register()` function.


## Bind

The bind method in the container does something, it binds or adds something to
the container. 

But after it is setup we want to be able to use the bind method by giving it
two things to bind together.

So what we could do is bind the path to our Database instance `Core\Database`
to a function that instanciates it. 

So its like a key value pair, the key is the path and the value is the function.

So this helper function will just contain that which we have been doing at the
top of the file each time. 

So now we have a string which is an identifier or a key to this binding, then 
we have a function that is responsible for building up the object. Some would 
call this a Factory Function. 

Next... 

When we bind something into the container we need to save it somewhere, we need
to cache it. Therefore we will create an array called `$bindings`.

Then when the bind method is called we will push to that $bindings array. Which
is an associative array.

Next...
With our resolve function we wanna do the opposite we wanna take it out of the
container. And how do we do that? Well we would probably call the builder function
and then return the results.

Well first check to see if the key exists in our `$bindings` array and then if
it doesnt, throw an Exception. But otherwise carry on..

## Next Problem

So all of that seems to be working well but unfortunately we have a new problem.

Now if I go into one of my containers, how do I grab that instance? Will i be
forced to type all of the code that is in the bootstrap.php file each time?

Of course not, that would defeat the whole purpose. But this does show that we 
need a place to buildup our container and have access to it from anywhere in our
application. 

So in order to do this we need to make an App Class.

## App Class

The starting of the container will be delegated to the app class.


Right away within this App Class we will create a static method `setContainer()`.

Static Methods in PHP are ones that can be called without having to instanciate
the class first. Very Handy.

You could run it by saying: `App::setContainer();`

Then to get the container you just type: `App::container();`

This class is an example of a Singleton Design Pattern.


So now we have replaced this:

```
    $config = require base_path("config.php");

    $db = new Database($config['database'], $config['auth']['user'],$config['auth']['password']);

```

With this: `$db = App::container()->resolve('Core\Database');`

Much Better.


But it would be even better if we would only have to write:
`$db = App::resolve(Database::class)`

To do this we will just need to create another static method inside or App Class.

The resolve method is presently only available in our Container Class. But we can
create a resolve method is the App class that just delegates the work to the 
resolve method in the container class.

Then we can do the exact same thing to the bind method as well. So now all we
need to worry about is the App class. It then deals with the container class.


# Edit and update note functinality

Lets duplicate the create view since it looks just like what we want..

Then from there it is good to start at the route level.




