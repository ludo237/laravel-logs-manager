# Laravel Logs Manager

Set of Artisan commands to handle the logs folder

## Why

Laravel is a great framework but it lacks on some specific tools
like this kind of commands, since it's possible to extend Laravel itself
I've took the plunge.

## How to use

Piece of cake. Grab a copy from composer `composer require ludo237/laravel-logs-manager`
and it's done if you run `php artisan` you will see a new set of commands

### Single Command Explanation (SCE)

```
php artisan log:archive [options] [--] [<name>]
```

The first command is all about reducing the space used by logs by archiving them in a
fancy `.zip` file. You can pass an optional name for the archive, by default the name will be `logs_archive_{date}` with
date taken directly from Carbon using `now()->toDateString()`.

**Remember: The `{date}` attribute is based on your date settings**

The command also accepts a `--remove` options which means that it will try to delete the archive with the
given name.

```
php artisan log:clear [options]
```

The clear command will try to flush your logs directory by removing all the logs file inside it. It will ask for
confirmation, the action is **irreversible**.

If you pass the `--force` option to the command it won't ask for confirmation.

```
php artisan log:dummy [options] [--] [<name>]
```

This command is really useful when testing stuff and you need to populate the logs folder for any reason.
It accepts a `name` as an argument and by default every log will be called `laravel_dummy_log_{n}` with `{n}` 
and incremental number. It also has an `--quantity` options which determines the number of dummy log that
the command will create for you, by default is set to one.

## How to contribute

Please see [the contribute file](CONTRIBUTING.md) file for more information