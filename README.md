The Framework
=============

This is the minimum code for "the framework" - an ultralight MVC written in PHP, compatible with version 5.6 and above, 
but targeted for PHP 7.1.x.

**The Framework** includes the following base features, among others:

+ A mini, or even micro, Object Relationship Mapper for MySQL. It should be possible to adapt this quickly for other database platforms, but it currently does use a key MySQL-specific feature.
+ A core URL routing system
+ A basic RBAC (roles-based access control system)
+ A batching task scheduler
+ More bugs, ah, we mean, *features*!

A keen observer will note that there are not many files here! As stated above, this is a very light framework, and only the basics are included here.
However, writing views, controllers, "services" and other components is *extremely* rapid in this system.

- Note: 3rd party packages are intended to be managed via Composer.

// TODO: Strip down the composer.json file to eliminate bloated dependencies such as the Google Client API that are not needed for general use.

// TODO: Create tutorial so people can actually get started using this thing.

## Authors:
- Prince Oduro
- Bryan Donald White

Bryan in Bielefeld, 26.02.2018# poqa_payroll
