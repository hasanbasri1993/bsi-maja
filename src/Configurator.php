<?php
	
	namespace BSIMAJA;
	
	use GuzzleHttp\Client as GuzzleClient;
	
	class Configurator
	{
		
		private static Configurator $defaultConfiguration;
		protected string $urlRefreshToken = '';
		protected string $baseUrlMaja = '';
		protected string $clientId = '';
		protected string $clientSecret = '';
		protected string $username = '';
		protected string $password = '';
		protected GuzzleClient $client;
		
		public function __construct()
		{
			$this->client = new GuzzleClient();
		}
		
		
		/**
		 * Gets the default configuration instance
		 *
		 */
		public static function getDefaultConfiguration(): Configurator
		{
			self::$defaultConfiguration = new Configurator();
			return self::$defaultConfiguration;
		}
		
		public function getUrlRefreshToken(): string
		{
			return $this->urlRefreshToken;
		}
		
		public function setUrlRefreshToken(string $url): Configurator
		{
			$this->urlRefreshToken = $url;
			return $this;
		}
		
		public function setUrlMaja(string $url): Configurator
		{
			$this->baseUrlMaja = $url;
			return $this;
		}
		
		public function getUrlMaja(): string
		{
			return $this->baseUrlMaja;
		}
		
		public function getClientId(): string
		{
			return $this->clientId;
		}
		
		public function setClientId(string $clientId): Configurator
		{
			$this->clientId = $clientId;
			return $this;
		}
		
		public function getClientSecret(): string
		{
			return $this->clientSecret;
		}
		
		public function setClientSecret(string $clientSecret): Configurator
		{
			$this->clientSecret = $clientSecret;
			return $this;
		}
		
		public function getUsername(): string
		{
			return $this->username;
		}
		
		public function setUsername(string $username): Configurator
		{
			$this->username = $username;
			return $this;
		}
		
		public function getPassword(): string
		{
			return $this->password;
		}
		
		public function setPassword(string $password): Configurator
		{
			$this->password = $password;
			return $this;
		}
		
	}