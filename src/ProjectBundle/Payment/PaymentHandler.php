<?php

namespace ProjectBundle\Payment;

use Symfony\Component\HttpFoundation\Request;
use ProjectBundle\Payment\SuccesHandler;

class PaymentHandler
{
	const TRANSACTION_OK = 'OK';
	const TRANSACTION_ERROR = 'ERROR';
	const TRANSACTION_STATUS_OK = 2;
	
	protected $id;
	protected $pin;
	protected $orderRepository;
	protected $successHandler;
	
	public function __construct(
		$id,
		$pin,
		$orderRepository = null,
		$successHandler = null
	) {
		$this->id = $id;
		$this->pin = $pin;
	}
	
	public function handleRequest($request)
	{
		$hash = $this->calculateHash($request);
		
		if ($this->isTransactionValid(
			$hash,
			$request->request->get('md5'),
			$request->request->get('control'),
			$request->request->get('t_status')
		)) {
			// miejsce na wykonanie success handler;
			
			return succesMethod('4');
		} else {
			return self::TRANSACTION_ERROR;
		}
	}
	
	protected function calculateHash($request)
	{
		$hash = sprintf(
			'%s:%s:%s:%s:%s:%s:%s:%s:%s:%s:%s',
			$this->pin,
			$this->id,
			$request->request->get('control'),
			$request->request->get('t_id'),
			$request->request->get('amount'),
			$request->request->get('email'),
			$request->request->get('service'),
			$request->request->get('code'),
			$request->request->get('username'),
			$request->request->get('password'),
			$request->request->get('t_status')
		);
		
		return md5($hash);
	}
	
	protected function isTransactionValid(
		$hash,
		$md5,
		$control,
		$status
	) {
		if ($hash != $md5) {
			return false;
		}
		
		if ($status != self::TRANSACTION_STATUS_OK) {
			return false;
		}
		
		if (!$this->orderRepository->findOneBy([
				'number' => $control
			]
		)) {
			return false;
		}
		
		return true;
	}
}