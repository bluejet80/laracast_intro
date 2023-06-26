to install a tailwind plugin while using the CDN

in the script tag where you src tailwind CDN just add `?plugins=forms`

manually submitting the form

curl -X POST http://localhost:1234/notes/create -d 'body=Hello+there'


To move the root directory

php -S localhost:1234 -t public

This changes the document root to the public folder
