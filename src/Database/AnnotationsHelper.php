<?php

namespace Andrew45105\SFC\Database;

/**
 * Contains methods for work with annotations
 *
 * Class AnnotationsHelper
 * @package Andrew45105\SFC\Database
 */
class AnnotationsHelper
{

    /**
     * @param \ReflectionProperty $property
     *
     * @return boolean
     */
    public function isPrimaryKey(\ReflectionProperty $property)
    {
        $comment = $property->getDocComment();
        return (boolean)preg_match('#@DBPrimaryKey#', $comment);
    }

}