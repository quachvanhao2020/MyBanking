<?php
namespace Omnipay\PayPalv2;
use Omnipay\PayPal\RestGateway as PayPalRestGateway;

class RestGateway extends PayPalRestGateway{

    public function getName()
    {
        return 'PayPal RESTv2';
    }

    /**
     * @return mixed
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\PayPalv2\Request\RestPurchaseRequest', $parameters);
    }

    /**
     * @return mixed
     */
    public function listPlan(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\PayPalv2\Request\RestListPlanRequest', $parameters);
    }

    /**
     * @return mixed
     */
    public function listProduct(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\PayPalv2\Request\RestListProductRequest', $parameters);
    }

    /**
     * @return mixed
     */
    public function createPlan(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\PayPalv2\Request\RestCreatePlanRequest', $parameters);
    }

    /**
     * @return mixed
     */
    public function createOrder(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\PayPalv2\Request\RestCreateOrderRequest', $parameters);
    }

    /**
     * @return mixed
     */
    public function createProduct(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\PayPalv2\Request\RestCreateProductRequest', $parameters);
    }

    /**
     * @return mixed
     */
    public function createSubscription(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\PayPalv2\Request\RestCreateSubscriptionRequest', $parameters);
    }
}

