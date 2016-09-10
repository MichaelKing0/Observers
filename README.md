[![Build Status](https://travis-ci.org/MichaelKing0/Observers.svg?branch=master)](https://travis-ci.org/MichaelKing0/Observers)
[![Code Climate](https://codeclimate.com/github/MichaelKing0/Observers/badges/gpa.svg)](https://codeclimate.com/github/MichaelKing0/Observers)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/e03b96d3-5eab-4e12-ad44-e88dbcda2107/mini.png)](https://insight.sensiolabs.com/projects/e03b96d3-5eab-4e12-ad44-e88dbcda2107)

# Basic PHP observer pattern implementation
## Usage
### Installation
```
composer require michaelking0/observers
```
### Making a class Observable (the subject)
In your subject class, implement the `MichaelKing0\Observers\Interfaces\ObservableInterface` interface. Also, use the trait `MichaelKing0\Observers\Traits\ObservableTrait`.
```php
<?php

namespace ACME;

use MichaelKing0\Observers\Interfaces\ObservableInterface;
use MichaelKing0\Observers\Traits\ObservableTrait;

class MySubject implements ObservableInterface
{
    use ObservableTrait;
}
```
Then just add a function that uses the `notify` method
```php
<?php

namespace ACME;

use MichaelKing0\Observers\Interfaces\ObservableInterface;
use MichaelKing0\Observers\Traits\ObservableTrait;

class MySubject implements ObservableInterface
{
    use ObservableTrait;

    public function save()
    {
        $this->notify('SubjectSaved');
    }
}
```
This will notify an observers of the event, and pass the event name and current instance as an argument

### Creating an Observer
To create an observer, implement the `MichaelKing0\Observers\Interfaces\ObservableInterface` interface.

```php
<?php

namespace ACME;

use MichaelKing0\Observers\Interfaces\ObservableInterface;
use MichaelKing0\Observers\Interfaces\ObserverInterface;

class MyObserver implements ObserverInterface
{
    public function update($event, ObservableInterface $observable)
    {
        echo 'It works!';
    }
}
```

### Attaching an observer
You can attach an observer to a subject by calling the `attach` method with the event name, and observer instance i.e.
```php
$subject = new MySubject();
$subject->attach('SubjectSaved', new MyObserver());
```
