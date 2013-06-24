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
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;

/**
 * Unique Field Validator checks if the field contains unique value.
 *
 * @author Md. Enzam Hossain <meenzam@gmail.com>
 */
class UniqueFieldValidator extends ConstraintValidator
{
    const CLASSNAME = __CLASS__;

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        $class = $this->context->getClassName();
        $field = $this->context->getPropertyName();
        $peerClass = $class::PEER;
        $object = $this->context->getRoot()->getData();

        $classFields = $peerClass::getFieldNames(\BasePeer::TYPE_FIELDNAME);

        if (false === array_search($field, $classFields)) {
            throw new ConstraintDefinitionException('The field "' . $field . '" doesn\'t exist in the "' . $class . '" class.');
        }

        $fieldPhpName = $peerClass::translateFieldName($field, \BasePeer::TYPE_FIELDNAME, \BasePeer::TYPE_PHPNAME);

        $models = \PropelQuery::from($class)->filterBy($fieldPhpName, $value)->limit(2)->find();
        $count = count($models);

        if ($count > 1 || ($count === 1 && $object !== $models[0])) {
            $this->context->addViolation($constraint->message,
                array(
                '{{ object_class }}' => $class,
                '{{ field }}' => $field,
            ));
        }
    }

}
