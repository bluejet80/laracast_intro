to install a tailwind plugin while using the CDN

in the script tag where you src tailwind CDN just add `?plugins=forms`

manually submitting the form

curl -X POST http://localhost:1234/notes/create -d 'body=Hello+there'
