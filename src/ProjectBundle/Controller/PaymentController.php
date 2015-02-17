<?php

namespace ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends Controller
{
    public function PayAction($id, $value, $name, $surname, $email)
    {
        $data = [
			'id' => 72890,
			'kwota' => $value,
			'waluta' => 'PLN',
			'opis' => 'Płatność za wypożyczenie filmow. Zamówienie nr '.$id,
			'control' => $id,
			'URLC' => 'http://malina-piotr.no-ip.org/payment/handle',
			'firstname' => $name,
			'nazwisko' => $surname,
			'email' => $email,
		];
		
		$params = http_build_query($data);
		
		$url = sprintf(
			'%s?%s',
			'https://ssl.dotpay.pl/',
			$params
		);
		
		return new RedirectResponse($url);
		
    }
	
	public function receivePaymentAction(Request $request){
	
		$logger = $this->get('monolog.logger.dotpay');
		$logger->info('================= NEW URLC NOTIFICATION =================');
		$logger->info(var_export($request->request, true));

		
		
		$response = $this->get('payment.handler')
							->handleRequest($request->request->all())
		;
		
		return new Response($response);
	}
}
