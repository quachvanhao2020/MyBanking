<?php
namespace Omnipay\PayPalv2;

class RestCreatePlanRequest extends AbstractRestRequest
{
    const API_VERSION = 'v1';

    /**
     * Get the plan name
     *
     * @return string
     */
    public function getName()
    {
        return $this->getParameter('name');
    }

    /**
     * Set the plan name
     *
     * @param string $value
     * @return RestCreatePlanRequest provides a fluent interface.
     */
    public function setData($value)
    {
        $this->data = $value;
        return $this;
    }

    public function getData()
    {
        $data = array(
            'name'                  => $this->getName(),
            'description'           => $this->getDescription(),
        );
        return $this->data;
    }

    /**
     * Get transaction endpoint.
     *
     * Billing plans are created using the /billing-plans resource.
     *
     * @return string
     */
    protected function getEndpoint()
    {
        return parent::getEndpoint() . '/billing/plans';
    }
}
