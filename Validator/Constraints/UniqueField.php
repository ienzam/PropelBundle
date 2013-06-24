<?php

/**
 * This file is part of the PropelBundle package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */
namespace Propel\PropelBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Constraint for the Unique field validator
 *
 * @author Md. Enzam Hossain <meenzam@gmail.com>
 */
class UniqueField extends Constraint
{
    const CLASSNAME = __CLASS__;

    /**
     * @var string
     */
    public $message = 'A {{ object_class }} object already exists with {{ field }}';

}
