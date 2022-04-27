<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Libraries\StringConvert;

// https://www.codeigniter.com/user_guide/outgoing/api_responses.html?highlight=respond#respond
class Apitest extends ResourceController
{
    protected $format = 'json';

    public function getContent()
    {
		helper('common');

		// reset
		$url = $this->request->getVar('url');
		$filterType = $this->request->getVar('filterType');
		$spliceNums = $this->request->getVar('spliceNums');

		if(!isset($filterType)) {
			$filterType = '0';
		}

		if(!isset($spliceNums)) {
			$spliceNums = 3;
		}

//echo $this->request->getPost();exit;
		$StringConvert = new StringConvert();

		// 컨텐츠 로드
		$client = \Config\Services::curlrequest();
		$response = $client->request('GET', $url);
		
		if($response->getStatusCode() != 200) {
			return $this->failNotFound('Content Not Found!');
		}

		$html = $response->getBody();

		// Proc
		$html = getBody($html, $filterType);

		$alphaNums = $StringConvert->extractAlphaNums($html);

		foreach($alphaNums as $k => $v) {
			$alphaNums[$k] = $StringConvert->textSort($v);
		}

		$mixText = $StringConvert->strNumMix($alphaNums['text'], $alphaNums['nums']);
		$result = $StringConvert->spliceText($mixText, $spliceNums);



		
        return $this->respond($result);
    }

    // ...
}