<?php

namespace MessageBird\Resources;

use InvalidArgumentException;
use MessageBird\Common;
use MessageBird\Objects;

/**
 * Class Contacts
 *
 * @package MessageBird\Resources
 */
class Contacts extends Base
{

    /**
     * @param Common\HttpClient $HttpClient
     */
    public function __construct(Common\HttpClient $HttpClient)
    {
        $this->setObject(new Objects\Contact());
        $this->setResourceName('contacts');

        parent::__construct($HttpClient);
    }

    /**
     * @param $object
     * @param $id
     *
     * @return $this ->Object
     *
     * @internal param array $parameters
     */
    public function update($object, $id)
    {
        $objVars = get_object_vars($object);
        $body = [];
        foreach ($objVars as $key => $value) {
            if ($value !== null) {
                $body[$key] = $value;
            }
        }

        $ResourceName = $this->resourceName . ($id ? '/' . $id : null);
        $body = json_encode($body);

        list(, , $body) = $this->HttpClient->performHttpRequest(Common\HttpClient::REQUEST_PATCH, $ResourceName, false,
            $body);
        return $this->processRequest($body);
    }

    /**
     * @param $id
     * @param array|null $parameters
     * @return $this ->Object
     */
    public function getMessages($id, $parameters = [])
    {
        if ($id === null) {
            throw new InvalidArgumentException('No contact id provided.');
        }

        $this->setObject(new Objects\Message());
        $this->setResourceName($this->resourceName . '/' . $id . '/messages');
        return $this->getList($parameters);
    }

    /**
     * @param $id
     * @param array|null $parameters
     * @return $this ->Object
     */
    public function getGroups($id, $parameters = [])
    {
        if ($id === null) {
            throw new InvalidArgumentException('No contact id provided.');
        }

        $this->setObject(new Objects\Group());
        $this->setResourceName($this->resourceName . '/' . $id . '/groups');
        return $this->getList($parameters);
    }
}
