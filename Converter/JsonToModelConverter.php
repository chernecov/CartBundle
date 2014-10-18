<?php
/*
 * This file is part of the Sergey Chernecov software.
 *
 * (c) 2014
 *
 * Do not care about any copyright or license.
 */

namespace Chernecov\Bundle\CartBundle\Converter;

use Doctrine\Common\Inflector\Inflector;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter,
    Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;

use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\Validator\Validator\RecursiveValidator;

/**
 * Simple json param converter
 *
 * @author Sergey Chernecov <sergey.chernecov@intexsys.lv>
 */
class JsonToModelConverter implements ParamConverterInterface
{
    public function __construct(RecursiveValidator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $name = $configuration->getName();
        $class = $configuration->getClass();;
        $options = $configuration->getOptions();
        $assoc = true;
        if (isset($options['assoc']) && is_bool($options['assoc'])) {
            $assoc = $options['assoc'];
        }
        $data = json_decode($request->getContent(), $assoc);

        $object = new $class;
        foreach ($data as $property => $value) {
            $method = Inflector::camelize('set_' . $property);
            if (method_exists($object, $method)) {
                $object->$method($value);
            }
        }

        $violations = $this->validator->validate($object);

        $request->attributes->set('violations', $violations);
        $request->attributes->set($name, $object);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(ParamConverter $configuration)
    {
        return true;
    }
}