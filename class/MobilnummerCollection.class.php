<?php

require_once('Signer.php');

class MobilnummerCollection {

	public function __construct($api_key, $api_secret) {
		$this->api_key = $api_key;
		$this->signer = new Signer($api_key, $api_secret);

		if(UKM_HOSTNAME == 'ukm.dev') {
			$this->baseFetchURL = 'http://husk.ukm.dev/web/app_dev.php/api/phones/';
		}
	}

	// TODO: Begrens denne til kun UKM Norge
	public function fetchAll() {
		$result = new stdClass();

		$data['time'] = time();
		$data['SIGNED_REQUEST'] = $this->signer->sign($data['time']);
		$data['API_KEY'] = $this->api_key;

		$curl = new UKMCURL();
		$curl->post($data);
		$result = $curl->process($this->baseFetchURL.'all/');

		return $this->handleResult($result);
	}

	public function fetchByPlace($place) {
		$result = new stdClass();

		$data['time'] = time();
		$data['SIGNED_REQUEST'] = $this->signer->sign($data['time']);
		$data['API_KEY'] = $this->api_key;
		$data['k_id'] = $place;

		$curl = new UKMCURL();
		$curl->post($data);
		$result = $curl->process($this->baseFetchURL.'lokal/');

		return $this->handleResult($result);
	}

	public function handleResult($result) {
		if(!is_object($result)) {
			$message = new stdClass();
			$message->success = false;
			$message->level = 'danger';
			$message->body = 'HUSK returnerte en feilstatus! Kontakt support.';
			return $message;
		}
		elseif($result->success == false) {
			$message = new stdClass();
			$message->success = false;
			$message->level = 'danger';
			$message->body = 'HUSK returnerte følgende feil: '.$result->errors[0];
			return $message;
		}
		else {
			return $result;
		}
	}
}