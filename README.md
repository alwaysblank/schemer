# Schemer 🦹

Help with [schema.org](https://schema.org/) markup generation.

[![Build Status](https://travis-ci.org/alwaysblank/schemer.svg?branch=master)](https://travis-ci.org/alwaysblank/schemer)

## Usage

> **Note:** Currently, Schemer generates only the "microdata" format.

Schemer is designed to be pretty simple to use: Just pass a structured array to the `::build()` static method on the Scheme you want:

```php
echo AlwaysBlank\Schemer\Scheme\PostalAddress::build([
    ['street', '123 Oak St'],
    ['state', 'OR'],
    ['city', 'Portland'],
    ['zip', '97123'],
    ['pobox', 'P.O. 1234'],
    ['country', 'USA'],
]);

// <span itemscope itemprop="http://schema.org/PostalAddress"><span itemprop="streetAddress">123 Oak St</span><span itemprop="addressRegion">OR</span><span itemprop="addressLocality">Portland</span><span itemprop="postalCode">97123</span><span itemprop="postOfficeBoxNumber">P.O. 1234</span><span itemprop="addressCountry">USA</span></span>
```

You can optionally pass a second argument, which is a array of arguments that will override the defaults. This allows you to do things like change the wrapping element tag, add arbitrary attributes, etc.

```php
echo AlwaysBlank\Schemer\Scheme\PostalAddress::build([
    ['street', '123 Oak St'],
    ['state', 'OR'],
    ['city', 'Portland'],
    ['zip', '97123'],
    ['pobox', 'P.O. 1234'],
    ['country', 'USA'],
], [
    'tag' => 'a',
    'attributes' => [
        'href'      => 'https://www.alwaysblank.org',
        'hidden'    => true,
    ],
]);
// <a itemscope itemprop="http://schema.org/PostalAddress" href="https://www.alwaysblank.org' hidden><span itemprop="streetAddress">123 Oak St</span><span itemprop="addressRegion">OR</span><span itemprop="addressLocality">Portland</span><span itemprop="postalCode">97123</span><span itemprop="postOfficeBoxNumber">P.O. 1234</span><span itemprop="addressCountry">USA</span></a>
```

### Schemes

Currently Schemer supports the following Schemes in some fashion. More will be added in the future! Please feel free to file an issue with schemes you'd like to see, or—even better!—a pull request adding them. See "How It Works" below for more information on how to create new Schemes and Properties.

- [`PostalAddress`](https://schema.org/PostalAddress) can understand the following:
    - `street`
    - `state`
    - `city`
    - `zip` (zip code)
    - `pobox` (P.O. box)
    - `country`
- [`LocalBusiness`](https://schema.org/LocalBusiness) can understand the following:
    - `name`
    - `phone` (phone segments will be rendered as links with `tel:`)
    - `url` (url can take a string, or an array with two items keyed `url` and `content`)
    - `address` (this is an array containing keys that will be understood by `PostalAddress`)
    
## How It Works

There are three basic parts to Schemer:

- `Node`
- `Property`
- `Scheme`

### Node

The `Node` is the simplest element, and also the only element that actually behaves like a class (`Property`s and `Scheme`s, though classes, are really just wrappers for static methods). It provides a sort of wrapper for individual segments of a `Propery` or `Scheme`, and is what is used to generate the actual HTML.

In general, you probably won't be interacting with `Node`s very much outside of creating them by passing a set of arguments:

```php
$Node = Node::add([
    'itemscope'     => true,
    'itemtype'      => 'http://schema.org/LocalBusiness',
    'itemprop'      => 'description',
    'tag'           => 'div',
    'content'       => "Always Blank",
    'attributes'    => [
        'href'      => 'https://www.alwaysblank.org',
        'hidden'    => true,
    ]
]);
```

Understanding this syntax is helpful, because it will be necessary for creating new `Property`s, or to modify existing properties or `Scheme`s.

### Property

A `Property`'s one purpose in life is to return a Node with the appropriate arguments for the the schema.org property it represents. It is also implemented as a **Trait** so that it can be composed into a `Scheme` later on.

A `Property` must meet the following requirements:

- It implements a public static method that has the same name as whatever you want to use as the key/name for the field in question—i.e. `address` or `phone`. In general, these names should be *simple* rather than directly matching the schema.org property they represent. For instance, `telephone` is represented here as just `phone`.
- This method takes only one argument.
- This method must return a `Node`.
- The Class and file names of the `Property` must be, essentially, CamelCase versions of the method name. i.e. `pobox` => `POBox`, `name` => `Name`, etc. 

A `Property` can take input of any kind (although most take strings), but you should be aware that there isn't a obvious mechanism (apart from reading the source code) to know what specific format a `Property` might be expecting its argument to be in, so keep user experience in mind when building these things.

### Scheme

A `Scheme` is the top dog; the final thing Schemer exists to do. They are surprisingly simple. A `Scheme` has to do the following:

- `extend` the class `AlwaysBlank\Schemer\Scheme\Scheme`. This actually probably most of the functionality.
- Implement a public static method called `wrap`. It takes two arguments: `content`, which is a string, and `args` which is an optional array. It returns a `Node`. Use this method to set the properties (i.e. `itemprop`) that the element that contains this `Scheme` will need.
- `use` any `Property` Traits that you want this `Scheme` to have access to. This defines the arguments it will accept.

Here's an example `Scheme`:

```php
class Example extends AlwaysBlank\Schemer\Scheme\Scheme
{
    use City;
    use Name;
    
    public static function wrap(string $content, array $args = []): Node
    {
        return Node::add(array_merge([
            'itemscope'     => true,
            'itemtype'      => 'http://schema.org/Example',
            'content'       => $content,
            'tag'           => 'section',
            'attributes'    => [
                'data-section' => 'example',
            ],
        ], $args));
    }
```

This will create a `Scheme` called `Example` that will understand `city` and `name`, and will use a `<section>` with an additional attribute of `data-section="example"`.

### Going Further

If you have more questions about how these things work, I encourage you to dig into the source code. I've made an effort to document the code clearly inline, and keep everything simple and clear.

## Debugging

To debug Schemer, set the PHP constant `ALWAYSBLANK_SCHEMER_DEBUG` to `true`. As with any debug flag, I don't recommend you set this in production.

Currently the debug flag has the following effects (this list may expand with time):

- Stop suppressing exceptions when calling `Property`s with bad arguments.

## Limitations

### Nesting

The output of a `Scheme` is generally pretty "flat" in the sense that it's just a list of elements that aren't nested within on another. (The exception being if the `Scheme` in question includes other `Scheme`s as `Property`s, as `LocalBusiness` does with `Address`.) This is more or less by design: So far as I can tell, building a system that would allow a user to dynamically modify the nesting of arbitrary elements would create an extreme amount of complexity in a library that is supposed to be very simple. In general, `Scheme`-level content isn't usually heavily nested anyway (apart from the aforementioned exceptions).

If you find yourself needing a more complex structure, Schemer is design to be flexible enough that you can build `Scheme`s and `Property`s "on the fly"—or even just use `Property`s directly without the need for a `Scheme`. 

### Options

This library is currently limited in terms of what it "understands". While it can be easily expanded, I have no intention of ever making it comprehensive with respect to the full schema.org specifications. Polite feature requests are always welcome (and good PRs will likely be merged without question), but please keep in mind that the primary purpose of this library is to make a small slice of repetitive tasks less repetitive, not to solve all microdata-related problems.