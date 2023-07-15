<?php

use Core\Authenticator;
//log the user out


(new Authenticator)->logout();

redirect('/');

