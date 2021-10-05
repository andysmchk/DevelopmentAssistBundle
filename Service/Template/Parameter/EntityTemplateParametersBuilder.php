<?php

namespace Rewsam\DevelopmentAssist\Service\Template\Parameter;

use Rewsam\DevelopmentAssist\Service\Helper\StringCaseConversion;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;

class EntityTemplateParametersBuilder implements TemplateParametersBuilder
{
    public const  PARAMETER_ENTITY_CLASS_NAME          = 'entityClassName';
    private const ENTITY_PROPERTY_MARKER               = '@Property';
    private const ENTITY_PRIMARY_FIELD_PROPERTY_MARKER = '@Property(primary=true)';

    /**
     * @var TemplateParametersBuilder
     */
    private $templateParametersBuilder;

    public function __construct(TemplateParametersBuilder $templateParametersBuilder)
    {
        $this->templateParametersBuilder = $templateParametersBuilder;
    }

    /**
     * @param InputParameter[] $inputParameters
     * @return array
     */
    public function buildParams(array $inputParameters): array
    {
        $params = $this->templateParametersBuilder->buildParams($inputParameters);
        $entityClassName = $this->getEntityClassName($inputParameters);
        $entityMeta = new \ReflectionClass($entityClassName);
        $entityName = $entityMeta->getShortName();

        $params['entityName'] = $entityName;
        $params['entityDescription'] = StringCaseConversion::camelToWords($entityName);
        $params['endpointNamespace'] = StringCaseConversion::camelToDash($entityName);
        $params['entityPrimaryKey'] = '';
        $params['entityPrimaryProtoType'] = 'string';
        $params['fields'] = [];

        $reflectionClass = new \ReflectionClass($entityClassName);
        $phpDocTypeExtractor = new PhpDocExtractor();

        foreach ($reflectionClass->getProperties(\ReflectionProperty::IS_PUBLIC) as $index => $property) {
            if (!$this->hasMarker($property, self::ENTITY_PROPERTY_MARKER)) {
                continue;
            }
            $name = $property->getName();

            $field = new EntityFieldParameterDTO();
            $field->name = $name;
            $field->type = 'mixed';
            $field->isPrimary = false;
            $field->isReadOnly = false;
            $field->nullable = true;
            $field->protoName = StringCaseConversion::underscoreToCamel($name);
            $field->protoIndex = $index + 1;

            if ($type = $phpDocTypeExtractor->getTypes($entityClassName, $name)[0] ?? null) {
                $field->type = $type->getBuiltinType();
                $field->nullable = $type->isNullable();
            }

            if (in_array($name, ['created_at', 'updated_at'])) {
                $field->isReadOnly = true;
                $field->nullable = true;
            }
            $field->protoType = $this->typeToProtoType($field->type);

            if ($this->hasMarker($property, self::ENTITY_PRIMARY_FIELD_PROPERTY_MARKER)) {
                $field->isReadOnly = true;
                $field->isPrimary = true;
                $field->protoName = 'id';
                $params['entityPrimaryKey'] = $name;
                $params['entityPrimaryProtoType'] = $field->protoType;
            }
            $field->protoSetter = 'set' . ucfirst($field->protoName);
            $field->protoGetter = 'get' . ucfirst($field->protoName);
            $field->protoNullable = $field->nullable ? 'optional' : 'required';

            $params['fields'][] = $field;
        }

        return $params;
    }

    /**
     * @param InputParameter[] $inputParameters
     */
    private function getEntityClassName(array $inputParameters): string
    {
        foreach ($inputParameters as $inputParameter) {
            if ($inputParameter->getKey() === self::PARAMETER_ENTITY_CLASS_NAME) {
                return $inputParameter->getValue();
            }
        }

        throw new \InvalidArgumentException('Missing require input parameter');
    }

    private function typeToProtoType(string $type): string
    {
        switch ($type) {
            case 'int':
                return 'int64';
            case 'bool':
                return 'bool';
            default:
                return 'string';
        }
    }

    private function hasMarker(\ReflectionProperty $property, string $marker): bool
    {
        return strpos($property->getDocComment(), $marker) !== false;
    }
}