# videx-scraper
A simple web scraper for a Coding Challenge

The scraper makes a http request to `https://videx.comesconnected.com` and crawls the page for package data
It uses the subscriptions class at it's starting point and then obtains the nested packages

## Install Depenencies
The composer dependencies for the project will need to be installed. Please run the following command in the root of the
repository
```
composer install
```

## Usage

To run the command type the following in your terminal, while in the root directory
```
bin/console crawler:videx
```

There is a single unit test on the Scape functionality in the Videx Scraper class. To run this test type the following
```
bin/phpunit
```

## Reflection
I unfortunately ran out of time on this challenge and If I had more time would do the following:
* The application does not handle http errors, timeouts etc at the moment. This would need adding and handling the exceptions
* Add more unit tests, especially for the functions in the Package entity
* Add a feature test that runs the command and checks the output
* Clean up the output of the command, as it just echos out the json at the moment
* If there was a case for using thie code base for other scrapers, I'd create an interface for the Scraper class, to bind
a contract to Scrapers. We could then use arguments on the command to switch out scrapers for other sites
* Add arguments to the command line so that different formats could be outputted.

Thanks for taking the time to review this Test.

