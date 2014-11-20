xtype
=====

Semantic atomic types for PHP

Usage
-----

XType classifies datatypes. They are mainly used to scaffold forms and get centralized string formatting.

Instead of saying:

```php
echo number_format($myObject->price,2,'.');
```

with xtype you can write:

```php

class MyObject{

    public $price;
    
    public function getType(){
        return NamedFieldType::create()
           ->set('price', UnitType::create()->setUnit('$')->setDecimals(2));
    }
}

// Then in you're view:

$myObject = new MyObject();
echo $myObject->getType('price')->valueToString($myObject->price);

```

Where this seems to be very clumsy it offers its powers in big applications
or big data centric applications.
Imagine you have a class customer:

```php

   class Customer{
   
       public $id;
       public $doubts;
       public $lastLogin;
       public $taxes;
       
       public function getType(){
           $type = NamedField::create();
           $type->set('id', NumberType::create()->setNativeType('int'))
           $type->set('doubts', CurrencyType::create()->setCurrency('€'));
           $type->set('lastLogin', TemporalType::create();
           $type->set('taxes', PercentageType::create());
           return $type;
       }
   }
   
   $c = new Customer();
   
   foreach($c->getType() as $key=>$type){
       echo "\n$key=>".$type->valueToString($c->{$key});
   }
```

And in every part of youre application you can just forget any string formatting.
But string formatting isn't the only usage of xtype. (i know about SOLID...)

Its on the other hand extremly useful to describe types. So you can build a database scheme of xtypes.

Another possibility is to scaffold forms with xtype.

Factory
-------
To simply create an XType you can use XType\TemplateFactory::create($native) which creates a AbstractType by a native php variable.

Caution
-------
This lib is in beta quality. The classes don't do much so it's not that dangerous to use em. So no docs or  at this time

