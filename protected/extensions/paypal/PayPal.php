<?php
class PayPal extends CComponent
{
	public $live=false;
	public $clientId;
	public $secret;
	
	protected $_tocken;
	protected $_tockenType;
	
	protected $_httpHeaders=array();
	
	public $currency = 'USD';
	public $defaultDescription = '';
	public $defaultQuantity = '1';
	
	public $cards=array(
				);
				
	public $amounts=array(
				);
	
	public function init()
    {
        if ($this->clientId!==null && $this->secret!==null)
		{
			$this->getTocken();
		}
		else 
			throw new CException("Not params to REST API");
    }
	
	protected function getTocken()
	{
		if ($this->_tocken===null)
		{
			$this->_httpHeaders=array('Accept:application/json','Accept-Language:en_US');
			$options=array(CURLOPT_USERPWD=>$this->clientId.':'.$this->secret);
			$resp=$this->getRespons('v1/oauth2/token','POST',$data=array('grant_type'=>'client_credentials'),$options);
			
			if (isset($resp['access_token']))
			{
				$this->_tocken=$resp['access_token'];
				$this->_tockenType=$resp['token_type'];
			}
			else
				throw new CException("Not Found access tocken");
				
		}
		return $this->_tocken;
	}
	
	protected function getTockenType()
	{
		if ($this->_tockenType===null)
		{
			$this->getTocken();
		}
		return $this->_tockenType;
	}
	
	protected function getHttpHeaders()
	{
		return $this->_httpHeaders;
	}
	
	public function getRespons($url,$method='POST',$data=array(),$options=array())
	{
		if ($this->live===true)
		{
			$url_service='https://api.paypal.com/';
		}
		else
		{
			$url_service='https://api.sandbox.paypal.com/';
		}

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url_service.$url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHttpHeaders());
		
		switch($method) 
		{
			case 'POST':
					curl_setopt($ch, CURLOPT_POST, true);
					if (is_array($data))
					{
						$data=http_build_query($data);
					}
					curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
					break;
		}
		
		if (!empty($options))
		{
			curl_setopt_array($ch, $options);
		}

		curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
		
		$result = curl_exec($ch);
		curl_close($ch);

		if ($result=='')
		{
			throw new CException("Bad request");			
		}
		
		return CJSON::decode($result);
	}
	
	public function paymentCart()
	{
		if (!empty($this->cards) && !empty($this->amounts))
		{
			$this->_httpHeaders=array('Content-Type:application/json','Authorization:'.$this->getTockenType().' '.$this->getTocken());
			$data=array(
				'intent'=>'sale',
				'payer'=>array(
						'payment_method'=>'credit_card',
						'funding_instruments'=>$this->cards,
				),
				'transactions'=>$this->amounts,
			);

			$resp=$this->getRespons('v1/payments/payment',$method='POST',CJSON::encode($data));
			
			if (isset($resp['id']))
			{
				return $resp;
			}
			else
				throw new CException("Error in respons");
		}
		else
			throw new CException("Empty Params");
	}

	public function addAmount($price,$description=null,$currency=null,$details=array('subtotal'=>'0', 'tax'=>'0','shipping'=>'0'))
	{
		if ($description===null)
		{
			$description=$this->defaultDescription;
		}
		if ($currency===null)
		{
			$currency=$this->currency;
		}
		$this->amounts[]=array(
							'amount'=>array(
								        'total'=>$price,
								        'currency'=>$currency,
								        'details'=>$details,
						     ),
			      			'description'=>$description,
						);
		
		return $this;
	}

	public function addCard($number,$type,$expire_month,$expire_year,$cvv2,$first_name,$last_name,$billing_address=array('line1'=>'','city'=>'','state'=>'','postal_code'=>'','country_code'=>''))
	{
		$this->cards[]=array(
							'credit_card'=>array(
								'number'=>$number,
								'type'=>$type,
								'expire_month'=>$expire_month,
								'expire_year'=>$expire_year,
								'cvv2'=>$cvv2,
								'first_name'=>$first_name,
								'last_name'=>$last_name,
								// 'billing_address'=>$billing_address,
							),
						);
		
		return $this;
	}
}
?>