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
        return $this->createRequest('\Omnipay\PayPalv2\RestPurchaseRequest', $parameters);
    }

    public function listPlan(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\PayPalv2\RestListPlanRequest', $parameters);
    }

    public function createPlan(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\PayPalv2\RestCreatePlanRequest', $parameters);
    }

    public function createProduct(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\PayPalv2\RestCreateProductRequest', $parameters);
    }

    public function createSubscription(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\PayPalv2\RestCreateSubscriptionRequest', $parameters);
    }
}

