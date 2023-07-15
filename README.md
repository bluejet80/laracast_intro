
# First Stuff

to install a tailwind plugin while using the CDN

in the script tag where you src tailwind CDN just add `?plugins=forms`

# Security concern

this is how you would manually submitting the form

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

2. then instead of these requires we will call a php function `spl_autoload_register()`

This function takes as its first parameter a function to which we will pass a $class and 
immediately we will dd() that $class so that we can see what is happening. 

So basically this function is called only when we need a certain class. So it is doing
exactly what we wanted to do. 

Actually what is happening is PHP doesnt know what the Class is and so its trying to 
track it down by running this function. So this function would be run when you 
instanciate a class and its undefined to php. 

By setting up this function we have 'declared' our implementation for how we should 
auto-load files that arnt immediately available.

Now we must figure out what is the logic? What should we do? Inside this function.

So the first thing to do is what we were doing before. Require the class. 

and that is it. Now everything is working fine. 

This function is something that allows us to determine what happens when a file is 
not immediately available. 

# Name Spacing

First thing we will do is create name spaces for our classes in the Core directory.

we do this by typing `namespace Core` at the top of the file below the php tag

once we do this everything breaks of course because we moved the database class into
a completely different name space. 

to fix this lets go to where the class is being instanciated and add `Core\` in
front of it. That is a backslash not a forward slash.

Another way to do it is to type `use Core\Database` at the top of the file. 
This is how we will do it.

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

to begin with we create a route method in the router class and then 
we will create methods for each one of the request types.

we create a dataset that will be all the routes. So when the app begins it goes
through all the routes and creates this dataset of all the routes and we can 
add attributes to each one of the items in the routes dataset.

then we create a method called route that accepts the current uri and finds the 
necessary info from within the routes dataset.

loop over all of the routes and as we are doing this check to see if that routs uri
matches the current uri and if it does then we `return base_path($route['controller'])`

if none of the routes match the current uri then there is no page for that and we
    call the abort() function.

we need to accept a request type so we know what request type it is. 

to do this we can create a hidden input method that has the value of the request
type that we want.

then we check if that value was recieved from the `$_POST` if it was use it , if
not just use the request method specified in the `$_SERVER` super global

then we pass that request type to our route method.

then when we check for the uri we will also check for the request method.

So to our router initally we pass the uri, and the controller associated with
that uri and we use the appropriate method. GET POST PATCH DELETE

`$router->get('/notes','controller/notes/index.php');`

the last thing we do is create an add method that adds the route to the routes
dataset so that we can clean up each one of the request methods.

so inside each request method it is only;

`$this-add('POST', $uri, $controller);`



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


# Sessions

sessions use the `$_SESSION` super global. but before you can have access to 
that super global, you must start the session.

And this is done with `session_start();`


The sessions on my machine are save in the path: /var/lib/php/sessions


So after the person has logged in then you will start the session.


# Form Flow

Often when you have a form that is being filled out by the user. Several things
happen once the form is submitted. These are:


1. Validate the Form
2. Run a Database Query
3. Respond in a certain way dependent upon the state of the database
4. Append things to the Session or the cache mark the user as logged in
5. Redirect the user to an appropriate page.


# Middleware

So the first thing that we do is attach another method called only() to the 
routes in our router that the status of the user will be checked. Either logged
in or not.

Then we must create the method in the Router class.

And to be able to chain methods we always need to return `$this` return the
instance so that we can keep working with it.

Then we added a property to the routes object that was called middleware and 
we set it initially to null. 

But then if our route passes through a middleware then we will change that
property to whatever the middleware is.

Then when we go to fetch the route we can check for the middleware key and if
it exists then do what is necessary stuff for that particular middleware.

## Middleware classes

So we setup a class for each of the middleware and each class has a `handle()`
method in it.

But we are still haveing to go to the router file and update it each time 
we add a new middleware. 

So right now the  middleware key itself points to the desired middleware class.

How bout setting up a lookup table...

First we begin by making a sortof Parent class for the middlewares, just called
Middleware.

and then inside that class we have a dataset that is a map, call it MAP.

then in the router we will just pass the key to this map and it will return
the desired class and then we can instanciate it and run the handle method.

And every class will have a handle method. 

So now we never have to go back into the router file we can just add a line to 
the MAP and then create the appropriate class for the middleware and put the 
funcitonality within the handle mehtod of that class.



# Talk through the file and try to determine nouns and verbs

This is an important part of refactoring. For readability purposes. 

Right now we are working with the Session Store.php file

And while talking through it we have created some classes and added methods
that help to delegate the funtioning of the file to the verbs, the methods
that should be handling these actions.

Its like good management. You can either do it all yourself in the file and
micro-manage the whole process OR.. 

You can delegate, you can create classes and methods to do the specific
tasks and then within the file delegate those tasks to those methods and
imporove the readability of the file and make things more modular and 
abstract as well. We dont want to hard-code or have to specify all this 
stuff in this file, because there will be other files that will need
to persom similar tasks and if then they can delegate those tasks just
as we have in this file then. There is work that we dont have to do again.

It is also difficult to remember specific things and so it is much easier
to call a method from a class and within that method are all the details but
all you must remember is the name of the method. And intuitively you make 
the name off of the verbs that you come up with when you are speaking out
the file. 

Spoken File:

We run the file
we get the form data
we instanciate(create) and new form and then validate the data on it.
Then if that passes we initialize a new Authenticator and Attempt to 
authenticate the user.
If that passes they are redirected to the home page
If that fails then we add the error to the errors array
and then at the end the last thing which is hit if there is any problems before
as well...
We return the create view and pass through the errors array.

Thinking:

Ok this is good so far but there is a major thing that we are missing and 
that is a programming process that is often used when there is a validation
error and we need to reload the page and pass old form data.

This process is Post, Redirect, Get. Or PRG Pattern for short

# Post Redirect Get

So we use this pattern when we are making a post request, and instead of 
sending raw html back with the errors.

Currently the form validation fails and we are not redirecting to the login
page, there is no 302 status code, instead we are just return some HTML directly
from the POST request. And this is not a good practice. 

If the user goes and tries to refreash the page then it will perform the POST
request again and again. And we dont want this. This is duplicate form submission.

Also if we leave and go to another page and then ty to hit the back button to 
return then we get another error.. Document Expired, this document is no longer
available.

All of this is due to our current implementation where in responce to a POST
request we just return a block of HTML.

The PRG Pattern is a common approach used when hiting controllers and perfoming
form validation.


So what this means is: 

we do a POST request when the form is submitted

Then if there are any validation errors or problems

we will Redirect the user to a new page where we then perform a GET request.


# Implementation

So the first thing that we do is to comment out the return View code and
instead just redirect the user back to the login page.

`return redirect('/sessions');`


That solved some of the problems but now the issue is that we must find
a way to pass through the errors.

One way world be to add the errors[] array to the session.

`$_SESSION['errors'] = $form->errors();`

And then in our contoller, session create.php we can grab that errors
array and pass it through.

That works and we now have the errors displayed.. But if we go to another
page or try to refresh, those errors never go away. 

We need to somehow add the errors to the sesssion and then soon after, or 
when a new page is loaded, flush the session of those errors.

we need a way of expiring that key from the Session

What we need is a way to distinguish from Data that should live in the 
Session indefinitely or untill the user logs out. And Data that should only
be in the Session for a moment and then be deleted. Data that is flashed
to the session fro one page request and then immediately it is removed or
expires.

To do this we will create a custom key in the Session called `['_fash']`,
we use the underscore to make sure that we are not overwritng any other
key that may exist later in the Session.

Now we will put all the data that is meant to be flashed to the session into
this specific key.

After doing this everything still works but now we need to determin WHERE
in the flow of everything should we expire that data?

If we go back into the entry point of the application `public/index.php` we
can see the flow of everything. And from this it seems that the best place
for this to happen would be after we have routed the request. That is after
we have called the `route()` method on the uri.

To do this we would type:

`unset($_SESSION['_flash']);`

And that seemed to work. But it is still not that good. Because whenever,
where ever we want to implement this we will have to remember what actual
key is called. We will have to remember its specific implementation. And
we dont want to have to do that. It would be so much nicer if we could just
run a method in a class to do all of this and then we would only have to
remmeber the method, or the specific API of the class.


With this current implementation the opportunity for things to get out of
sync is pretty high.

Within the core directory we are going to add a new class. This will be a
very simple class. The class will contain Global functions, they will be
static. These will be our helper methods.


# Setting up Custom Exceptions

The next thing we are gonna do is throw a global exception if we have a
problem like failed form validation or user login info is incorrect. 

Then we can have the freedom to do several things when that exception is 
thrown. And again this is all about delegation and getting this logic outside
of this specific file that we've been working in and making this same 
functionality available to other forms that we may have without having to 
rewrite it for every form. 







