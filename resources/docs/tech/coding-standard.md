# Coding Standard #

## English ##
English is our main development language. That means that everything in the code
should be written in English: Classes, entities, functions, methods, etc. If there
is a new object needed, think about the best english term to use and check it with some mate.

It does not matter if Business handles terms in Spanish, we should be capable of understanding
and translating it into English and vice versa.

## Coding Standard ##
The official Coding Standard for Webflix is [PSR-2](http://www.php-fig.org/psr/psr-2/).

## CS git hooks ##
In order to guarantee that we follow our CS, we have created a pre-commit hook for github that will perform
some related tasks. Here are the instructions to follow to set it up.

### 1. Set-up (only for linux) ###
    cd <videostrore-kata_folder>
    rm -rf .git/hooks
    ln -s ../resources/git/hooks .git/hooks

As you may see, hooks are in our repository control system, so we can keep control of changes. Right now, hooks tasks are:
* Checks PHP lint (php -l) to all *.php and *.ini files committed in the whole project
* Checks php-cs-fixer --dry-run to *.php files committed in the whole project
* Checks PHP Code Sniffer to all *.php files committed in /src
* Runs the Unit Tests for /src

### 2. Skipping hooks pre-commit ###
If for some exceptional reason, you need to commit skipping hook execution, you can use:

    git commit -n ... (-n is used to skip hooks execution)

