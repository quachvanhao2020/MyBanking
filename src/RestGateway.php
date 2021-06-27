<?php
namespace Omnipay\PayPalv2;
use Omnipay\PayPal\RestGateway as PayPalRestGateway;

class RestGateway extends PayPalRestGateway{

    public function getName()
    {
        return 'PayPal RESTv2';
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\PayPalv2\Request\RestPurchaseRequest', $parameters);
    }

    public function listPlan(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\PayPalv2\Request\RestListPlanRequest', $parameters);
    }

    public function listProduct(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\PayPalv2\Request\RestListProductRequest', $parameters);
    }

    public function createPlan(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\PayPalv2\Request\RestCreatePlanRequest', $parameters);
    }

    public function createOrder(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\PayPalv2\Request\RestCreateOrderRequest', $parameters);
    }

    public function createProduct(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\PayPalv2\Request\RestCreateProductRequest', $parameters);
    }

    public function createSubscription(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\PayPalv2\Request\RestCreateSubscriptionRequest', $parameters);
    }
}

