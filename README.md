# Symfony / Foundry / PHPUnit issue

This repository aims to reproduce an issue that I have with Zenstruck Foundry and PHPUnit when testing a Symfony application.

To setup the project, you need to install Docker, then:

```console
make install
```

Start the project:

```console
make docker-start
```

The application simply lists pages (title + content + slug) stored in database and allows to show them.
See [`PageController`](/src/Controller/PagesController.php).

The issue happens when I run the tests:

```console
make test
```

There are two tests: one to test the `index` controller, and one to test the `show` controller.
See [`PageControllerTest`](/tests/Controller/PagesControllerTest.php).

It returns:

```console
PHPUnit 9.6.19 by Sebastian Bergmann and contributors.

Testing
..                                                                  2 / 2 (100%)

Time: 00:00.913, Memory: 38.50 MB

OK (2 tests, 6 assertions)

THE ERROR HANDLER HAS CHANGED!
```

Note the error on the final line.
While the command doesn't fail, it actually breaks the report of deprecations notices.

When I comment out the lines of the Foundry `restorePhpUnitErrorHandler()` function (see the file `vendor/zenstruck/foundry/src/phpunit_helper.php`), I get this:

```console
PHPUnit 9.6.19 by Sebastian Bergmann and contributors.

Testing
..                                                                  2 / 2 (100%)

Time: 00:01.055, Memory: 40.50 MB

OK (2 tests, 6 assertions)

Remaining indirect deprecation notices (13)

[List of the 13 deprecation notices]
```

I don't know the role of this code, but it actually seems to have an unexpected behaviour.
