<?php
namespace Omnipay\PayPalv2\Request;
use Omnipay\Common\Item;
use Omnipay\PayPalv2\Response\RestAuthorizeResponse;

class RestAuthorizeRequest extends AbstractRestRequest
{
    public function getData()
    {
        $data = array(
            'intent' => 'CAPTURE',
        );
        $items = $this->getItems();
        if ($items) {
            /** @var Item $item  */
            foreach ($items as $n => $item) {
                $item = [
                    //"reference_id" => "test_ref_id1",
                    "amount" => [
                        "value" => $item->getPrice(),
                        "currency_code" => "USD"
                    ]
                ];
                $data['purchase_units'][0] = $item;
            }
        }
        $data['application_context'] = array(
            'return_url' => $this->getReturnUrl(),
            'cancel_url' => $this->getCancelUrl(),
        );
        return $data;
    }


    /**
     * Get transaction endpoint.
     *
     * Authorization of payments is done using the /payment resource.
     *
     * @return string
     */
    protected function getEndpoint()
    {
        return parent::getEndpoint() . '/checkout/orders';
    }

    protected function createResponse($data, $statusCode)
    {
        return $this->response = new RestAuthorizeResponse($this, $data, $statusCode);
    }
}
