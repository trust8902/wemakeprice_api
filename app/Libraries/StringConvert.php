<?php
namespace App\Libraries;

class StringConvert {
	public function extractAlphaNums($text) {
		// reset
		$result = array('text' => '', 'nums' => '');

		if(!$text) {
			return '';
		}

		// 영어/숫자 추출
		foreach(array(
			'text' => 'A-Za-z',
			'nums' => '0-9'
		) as $varName => $regex) {
			preg_match_all('/['.$regex.']+/', $text, $buff);

			if(sizeof($buff[0]) > 0) {
				$result[$varName] = implode('', $buff[0]);
			}
		}

		return $result;
	}

	public function textSort($text) {
		// reset
		$result = '';
		$buff   = array();

		if(!$text) {
			return '';
		}

		// 문자열을 배열화
		while(true) {
			$word = substr($text, 0, 1);
			$text = substr($text, 1);

			$buff[strtolower($word)][] = $word;

			if(!$text) {
				break;
			}
		}

		// 정렬
		ksort($buff);

		foreach($buff as $k => $v) {
			sort($v);
			$result .= implode('', $v);
		}

		return $result;
	}

	public function strNumMix($text, $nums) {
		// reset
		$mixText = '';
		$restKey = 'text'; // ex) text|15
		$restVal = 0;

		if(!$text && !$nums) {
			return '';
		}
		
		$totalLen = strlen($text) + strlen($nums);

		// 텍스트 길이가 긴 변수 체크
		if(strlen($nums) != strlen($text)) {
			if(strlen($nums) > strlen($text)) {
				$restKey = 'nums';
			}

			if($restKey == 'text') {
				$restVal = (strlen($nums) * 2) + 1;
			} else {
				$restVal = (strlen($text) * 2) + 1;
			}
		} else {
			$restKey = '';
		}

		for($n=0; $n <= $totalLen; $n++) {
			// 영어
			if(($restKey == 'text' && $n >= $restVal) || ($text && ($n % 2 === 0))) {
				$mixText .= substr($text, 0, 1);
				$text    = substr($text, 1);
			}

			// 숫자
			if(($restKey == 'nums' && $n >= $restVal) || ($nums && ($n % 2 === 1))) {
				$mixText .= substr($nums, 0, 1);
				$nums    = substr($nums, 1);
			}
		}

		return $mixText;
	}

	public function spliceText($text, $spliceNums) {
		// reset
		$result = array(
			'portion' => array(), 
			'other'   => array()
		);

		if(!$text || !$spliceNums) {
			return '';
		}

		while(true) {
			$word = substr($text, 0, $spliceNums);

			if(strlen($word) == $spliceNums) {
				$result['portion'][] = $word;
			} else {
				$result['other']   = $word;
			}

			$text = substr($text, $spliceNums);

			if(!$text) {
				break;
			}
		}

		return $result;
	}
}