<?php

// register all the event listeners

// test purpose
Event::listen('testing', 'EventsController@onTesting');

// users
Event::listen('user.registration', 'EventsController@onUserRegister');