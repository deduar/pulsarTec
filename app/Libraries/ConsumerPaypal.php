<?php
namespace App\Libraries;
 
use PayPal\Rest\ApiContext,
    PayPal\Auth\OAuthTokenCredential,
    PayPal\Api\CreditCard,
    PayPal\Exception\PayPalConnectionException,
    PayPal\Api\Amount,
    PayPal\Api\Details,
    PayPal\Api\Item,
    PayPal\Api\ItemList,
    PayPal\Api\CreditCardToken,
    PayPal\Api\Transaction,
    PayPal\Api\Payment,
    PayPal\Api\Payer,
    PayPal\Api\FundingInstrument,
    PayPal\Api\PaymentExecution, 
    PayPal\Api\RedirectUrls,
    PayPal\Api\Capture,
    PayPal\Api\Authorization,
    PayPal\Api\Refund,
    PayPal\Api\RefundRequest;

class ConsumerPaypal {
 
    /**
    *
    * api context
    *
    * @var
    *
    */
    private $_apiContext = null;
    
    /**
    *
    * base url de la app
    *
    * @var
    *
    */
    private $_baseUrl = "http://localhost/~deduar/Projects/PulsarTec_Odoo_SPA/public/";
 
    /**
    *
    * crea la instancia y configura ApiContext
    *
    */
    public function __construct()
    {
        $this->_apiContext = new ApiContext(
            new OAuthTokenCredential(
                'AYsMTZguz6c4kJQVdJUxubtBvw8RcHgq0SeRPIy51i3GzPzEE-olUaUiGRJQL1QrhSctPRPMMI_xKe_F',     // ClientID
                'EL9PBqz2TN84YfR-Oo-p9g4BH2wx--_SjEUJB-KCruBhMx1IuKfcgWY--mrJibLUAh2_8UYZTZFO7Bc0'  // ClientSecret
            )
        );
 
        $this->_apiContext->setConfig(
            array(
                'mode'              => 'sandbox',
                'log.LogEnabled'    => true,
                'log.FileName'      => '../storage/logs/PayPal.log',
                'log.LogLevel'      => 'DEBUG'
            )
        );
    }


	/**
	*
	* genera un pedido sin procesar que devuelve una url para hacer el redirect
	*
	*/
	public function savePaymentWithPaypal($currency, $amt) 
	{
	    $payer = new Payer();
	    $payer->setPaymentMethod("paypal");
	 
	    $item = new Item();
	    $item->setName('Pay PulsarTec Odoo')
	        ->setCurrency($currency)
	        ->setQuantity(1)
	        ->setPrice($amt);
	 
	    $itemList = new ItemList();
	    $itemList->setItems(array($item));
	    $details = new Details();
	    //$details->setShipping(0.01)->setTax(0.02)->setSubtotal($amt);
	    $details->setShipping(0)->setTax(0)->setSubtotal($amt);
	 
	    $amount = new Amount();
	    $amount->setCurrency($currency)->setTotal($amt)->setDetails($details);
	 
	    $transaction = new Transaction();
	    $transaction->setAmount($amount)
	        ->setItemList($itemList)
	        ->setDescription("Renew PulsarTec Odoo")
	        ->setInvoiceNumber(uniqid());
	 
	 
	    $redirectUrls = new RedirectUrls();
	    $redirectUrls->setReturnUrl($this->_baseUrl . "paypal_payment_response/success")
	        ->setCancelUrl($this->_baseUrl . "/home");
	 
	    $payment = new Payment();
	    $payment->setIntent("authorize")
	        ->setPayer($payer)
	        ->setRedirectUrls($redirectUrls)
	        ->setTransactions(array($transaction));
	 
	    try {
	        $payment->create($this->_apiContext);
	        return $payment->getApprovalLink();
	    } catch (PayPalConnectionException $ex) {
	        echo $ex->getData();
	        exit;
	    }
	}

	public function execute_payment($paymentId, $payerId)
	{
	    $payment = Payment::get($paymentId, $this->_apiContext);
	 
	    $execution = new PaymentExecution();
	    $execution->setPayerId($payerId);
	 
	    try {
	        $payment->execute($execution, $this->_apiContext);
	        return $payment;
	    } catch (PayPalConnectionException $ex) {
	        echo $ex->getData();
	        exit;
	    }
	}

	public function getPaymentWithPayPal($transactions_id,$amount,$currency)
	{
		$authorizationId = $transactions_id;
		try {
			$authorization = Authorization::get($authorizationId, $this->_apiContext);

		    $amt = new Amount();
		    $amt->setCurrency($currency)
		        ->setTotal($amount);

		    ### Capture
		    $capture = new Capture();
		    $capture->setAmount($amt);

		    $getCapture = $authorization->capture($capture, $this->_apiContext);
		} catch (Exception $ex) { 
			ResultPrinter::printError("Capture Payment", "Authorization", null, $capture, $ex);
	    	exit(1);
		}
		return $getCapture;
	}

}