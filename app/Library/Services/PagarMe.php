<?php
// app/Library/Services/DemoTwo.php
namespace App\Library\Services;

use PagarMe\Client;

class PagarMe
{
    
    /**
	 * Pagarme constructor.
	 */
	public function __construct() {
		$this->pagarme = new Client(
			env('PAGARME_API_KEY',""),
			[
                'headers' => ['Authorization' => 'Basic '.base64_encode(env('PAGARME_API_KEY',"").":"),],
                'base_uri' => "https://api.pagar.me/core/v5/"
            ]
		);
	}


    public function getCustomers()
    {

        $customers = $this->pagarme->customers()->getList();
        return $customers;
    }
}