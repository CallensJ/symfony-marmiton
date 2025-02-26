<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class BanWord extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */

     public function __construct(
        public string $message = 'The value "{{ banWord }}" is not valid.',
        public array $badWords = ['spam', 'sexe'],
        ?array $groups = null,
        mixed $payload = null
     )
     {
        parent::__construct(null,$groups, $payload);
     }
     
}
