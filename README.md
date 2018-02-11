# Symfony Form DateTimeImmutable Polyfill Bundle

[![GitHub license](https://img.shields.io/github/license/ruvents/ruwork-polyfill-form-dti-bundle.svg?style=flat-square)](https://github.com/ruvents/ruwork-polyfill-form-dti-bundle/blob/master/LICENSE)
[![Travis branch](https://img.shields.io/travis/ruvents/ruwork-polyfill-form-dti-bundle/master.svg?style=flat-square)](https://travis-ci.org/ruvents/ruwork-polyfill-form-dti-bundle)
[![Codecov branch](https://img.shields.io/codecov/c/github/ruvents/ruwork-polyfill-form-dti-bundle/master.svg?style=flat-square)](https://codecov.io/gh/ruvents/ruwork-polyfill-form-dti-bundle)
[![Packagist](https://img.shields.io/packagist/v/ruwork/polyfill-form-dti-bundle.svg?style=flat-square)](https://packagist.org/packages/ruwork/polyfill-form-dti-bundle)

This package is a polyfill bundle for my [pull request](http://symfony.com/blog/new-in-symfony-4-1-added-support-for-immutable-dates-in-forms) adding `input=datetime_immutable` option to the Symfony date and time form types.

Works with PHP `>=5.5` and Symfony `>=2.8 <4.1`.

Internally this bundle uses the [ruwork/polyfill-form-dti](https://github.com/ruvents/ruwork-polyfill-form-dti) package and plugs its type extensions and guesser into DI with all necessary tags.

## Installation

```shell
composer require ruwork/polyfill-form-dti-bundle
```

Enable the `Ruwork\PolyfillFormDTIBundle\RuworkPolyfillFormDTIBundle` manually in your kernel if you don't use Symfony Flex.

## Usage

```php
<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @Entity
 */
class Survey
{
    /**
     * @ORM\Column(type="date_immutable")
     *
     * @var \DateTimeImmutable
     */
    private $dayOfBirth;

    public function getDayOfBirth()
    {
        return $this->dayOfBirth;
    }

    public function setDayOfBirth(\DateTimeImmutable $dayOfBirth)
    {
        $this->dayOfBirth = $dayOfBirth;
    }
}
```

```php
<?php

namespace App\Controller;

use App\Entity\Survey;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Request;

class FormController extends AbstractController
{
    /**
     * @Route("/form")
     * @Template
     */
    public function __invoke(Request $request)
    {
        $survey = new Survey();

        $form = $this->createFormBuilder($survey)
            ->add('dayOfBirth', DateType::class, [
                'input' => 'datetime_immutable',
            ])
            // or let the form guesser do the job for you
            ->add('dayOfBirth')
            ->getForm()
            ->handleRequest($request);

        return [
            'form' => $form->createView(),
        ];
    }
}
```

Bundle will automatically register the `Ruwork\PolyfillFormDTI\Guesser\DoctrineOrmDTIGuesser` if Doctrine DBAL's version is `>=2.6` and `@doctrine` service is registered in DI.

## Testing

```shell
vendor/bin/simple-phpunit
```
