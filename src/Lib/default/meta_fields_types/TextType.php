<?php
namespace MetaFieldsTypes;

use Cake\Database\Expression\QueryExpression;
use Cake\ORM\TableRegistry;

class TextType
{
    public const OPERATORS = ['=', '!='];
    public const TYPE = 'text';

    public function __construct()
    {
        $this->MetaFields = TableRegistry::getTableLocator()->get('MetaFields');
        $this->MetaTemplateFields = TableRegistry::getTableLocator()->get('MetaTemplateFields');
    }

    public function validate(string $value): bool
    {
        return is_string($value);
    }

    public function setQueryExpression(QueryExpression $exp, string $searchValue, \App\Model\Entity\MetaTemplateField $metaTemplateField): QueryExpression
    {
        $field = 'MetaFields.value';
        if (substr($searchValue, 0, 1) == '!') {
            $searchValue = substr($searchValue, 1);
            $exp->notEq($field, $searchValue);
        } else if (strpos($searchValue, '%') !== false) {
            $exp->like($field, $searchValue);
        } else {
            $exp->eq($field, $searchValue);
        }
        return $exp;
    }
}
