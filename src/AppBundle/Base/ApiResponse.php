<?php
/**
 * Created by PhpStorm.
 * User: lluis
 * Date: 7/31/15
 * Time: 11:55 AM
 */

namespace AppBundle\Base;

use JMS\Serializer\Annotation\XmlKeyValuePairs;

class ApiResponse {

    /** @XmlKeyValuePairs */
    public $data;

    public $status;

    public $message;

    /**
     * ApiResponse constructor.
     * @param $data
     * @param $status
     * @param $message
     */
    public function __construct($data, $status, $message)
    {
        $this->data = $data;
        $this->status = $status;
        $this->message = $message;
    }

}
