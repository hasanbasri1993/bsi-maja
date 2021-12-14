<?php
	
	namespace BSIMAJA;
	
	use GuzzleHttp\Client as GuzzleClient;
	use GuzzleHttp\Exception\GuzzleException;
	
	class Client
	{
		protected string $getUrlMaja = '';
		protected string $urlRefreshToken = '';
		protected string $clientId = '';
		protected string $clientSecret = '';
		protected string $username = '';
		protected string $password = '';
		protected string $getAccessToken = '';
		/**
		 * @var \GuzzleHttp\Client
		 */
		private GuzzleClient $client;
		
		/**
		 * @param \BSIMAJA\Configurator $config
		 */
		public function __construct(Configurator $config)
		{
			$this->client = new GuzzleClient();
			$this->getUrlMaja = $config->getUrlMaja();
			$this->urlRefreshToken = $config->getUrlRefreshToken();
			$this->clientId = $config->getClientId();
			$this->clientSecret = $config->getClientSecret();
			$this->username = $config->getUsername();
			$this->password = $config->getPassword();
			$this->getAccessToken = $this->getAccessToken();
		}
		
		public function getAccessToken()
		{
			try {
				$response = $this->client->request('POST', $this->urlRefreshToken, [
					'form_params' => [
						'grant_type' => 'password',
						'client_id' => $this->clientId,
						'client_secret' => $this->clientSecret,
						'username' => $this->username,
						'password' => $this->password
					]
				]);
				if ($response->getBody()) {
					$json = json_decode($response->getBody(), true);
					if (isset($json['access_token']))
						return json_decode($response->getBody(), true)['access_token'];
					else
						return "error";
				}
			} catch (GuzzleException $e) {
				echo $e->getMessage();
			}
			return $this;
			
		}
		
		
		function createInvoice($body)
		{
			if (isset($body['name']) == false || isset($body['va']) == false || isset($body['amount']) == false || isset($body['items']) == false || isset($body['attributes']) == false)
				return "name:$body[name], va:$body[va], amount:$body[amount], attributes is required";
			try {
				$response = $this->client->request('POST', $this->getUrlMaja . "register", [
					'json' => $body,
					'headers' => [
						'Authorization' => 'Bearer ' . $this->getAccessToken,
						'Content-Type' => 'application/json'
					]
				]);
				if ($response->getBody())
					return json_decode($response->getBody(), true);
			} catch (GuzzleException $e) {
				return $e->getMessage();
			}
			return "error create invoice: ";
		}
		
		function updateInvoice($body)
		{
			if (isset($body['name']) || isset($body['va']) || isset($body['amount']) == false || isset($body['items']) == false || isset($body['attributes']) == false)
				return "name, va, amount, items, attributes is required";
			try {
				$response = $this->client->request('PUT', $this->getUrlMaja . "invoice", [
					'json' => $body,
					'headers' => [
						'Authorization' => 'Bearer ' . $this->getAccessToken
					]
				]);
				if ($response->getBody())
					return json_decode($response->getBody(), true);
			} catch (GuzzleException $e) {
				return $e->getMessage();
			}
			return "error update invoice";
		}
		
		function cancelInvoice($body)
		{
			if (isset($body['invoiceNumber']) == false || isset($body['va']) == false || isset($body['amount']) == false )
				return "va, invoiceNumber, amount is required";
			try {
				$response = $this->client->request('POST', $this->getUrlMaja . "cancel", [
					'json' => $body,
					'headers' => [
						'Authorization' => 'Bearer ' . $this->getAccessToken
					]
				]);
				if ($response->getBody())
					return json_decode($response->getBody(), true);
			} catch (GuzzleException $e) {
				return $e->getMessage();
			}
			return "error cancel invoice";
		}
		
		function inquiryInvoice($body)
		{
			if (isset($body['va']) == false || isset($body['invoiceNumber']) == false || isset($body['amount']) == false)
				return "va, invoiceNumber, amount is required";
			try {
				$response = $this->client->request('POST', $this->getUrlMaja . "inquiry", [
					'json' => $body,
					'headers' => [
						'Authorization' => 'Bearer ' . $this->getAccessToken
					]
				]);
				if ($response->getBody())
					return json_decode($response->getBody(), true);
			} catch (GuzzleException $e) {
				return $e->getMessage();
			}
			return "error inquiry invoice";
		}
	}