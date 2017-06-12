<?php

namespace AppBundle\Serializer\Handler;

use JMS\Serializer\Context;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonDeserializationVisitor;
use JMS\Serializer\XmlDeserializationVisitor;
use JMS\Serializer\VisitorInterface;
use JMS\Serializer\GraphNavigator;
use Ramsey\Uuid\UuidFactory;
use Ramsey\Uuid\UuidFactoryInterface;
use Ramsey\Uuid\UuidInterface;

class UuidHandler implements SubscribingHandlerInterface
{
    /**
     * @var UuidFactoryInterface
     */
    protected $uuidFactory;

    public static function getSubscribingMethods()
    {
        $methods = array();
        $types = array('Uuid');

        foreach (array('json', 'xml', 'yml') as $format) {
            $methods[] = array(
                'type' => 'Uuid',
                'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                'format' => $format,
            );

            foreach ($types as $type) {
                $methods[] = array(
                    'type' => $type,
                    'format' => $format,
                    'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                    'method' => 'serialize'.$type,
                );
            }
        }

        return $methods;
    }

    public function __construct(UuidFactoryInterface $uuidFactory = null)
    {
        $this->uuidFactory = $uuidFactory ?: new UuidFactory();
    }

    public function serializeUuid(VisitorInterface $visitor, UuidInterface $uuid, array $type, Context $context)
    {
        return $visitor->visitString($uuid->toString(), $type, $context);
    }


    public function deserializeUuidFromXml(XmlDeserializationVisitor $visitor, $data, array $type)
    {
        if (null === $data) {
            return null;
        }

        return $this->parseUuid($data);
    }

    /**
     * @param JsonDeserializationVisitor $visitor
     * @param $data
     * @param array $type
     * @return null|UuidInterface
     */
    public function deserializeUuidFromJson(JsonDeserializationVisitor $visitor, $data, array $type)
    {
        if (null === $data) {
            return null;
        }

        return $this->parseUuid($data);
    }

    /**
     * @param $data
     * @return UuidInterface
     */
    private function parseUuid($data)
    {
        return $this->uuidFactory->fromString($data);
    }
}
