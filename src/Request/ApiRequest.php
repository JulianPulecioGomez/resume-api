<?php

namespace App\Request;

use App\Util\RequestDTOInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Validator\Constraints as Assert;

class ApiRequest implements RequestDTOInterface
{
    public function __construct(Request $request)
    {
        $reflectionExtractor = new ReflectionExtractor();
        $propertyInfo = new PropertyInfoExtractor([$reflectionExtractor]);
        $entity = $request->attributes->get('data');
        $properties = $propertyInfo->getProperties(get_class($entity));

        foreach ($properties as $property){
            $setMethod = 'set'.$property;
            $getMethod = 'get'.$property;

            if (is_callable([$this, $setMethod]) && is_callable([$entity, $getMethod]) ){
                $this->$setMethod($entity->$getMethod() ?? null);
            }
        }
    }
}

