<?php
class Same_Place_Code
{
	public function exec()
	{
		if (!isset($_GET['place'])) {$context = array(); return $context;}
		$Circumstances = new Circumstances;
		$Circumstances->place = $_GET['place'];
		$context['place'] = $_GET['place'];
		$same_place_code = $Circumstances->get_same_place_code();
		$i = 0;
		if (isset($same_place_code))
		{
			$code_set = array();
			foreach ($same_place_code as $value)
			{
				$code_set[$i][$value['item_type']]['imgdat'] = $value['imgdat'];
				$code_set[$i][$value['item_type']]['mime'] = $value['mime'];
				$code_set[$i]['tops']['date'] = $value['date'];
				$code_set[$i]['tops']['weather'] = $this->weather_to_japanese($value['weather']);
				if ($value['item_type'] === 'shoes') { $i++; }
			}
			$context['code_set'] = $code_set;
		}
		return $context;
	}

	private function weather_to_japanese($weather)
	{
		if($weather === 'Clear')
		{
			$weather = '晴れ';
		}
		else if($weather === 'Clouds')
		{
			$weather = '曇り';
		}
		else if($weather === 'Rain')
		{
			$weather = '雨';
		}
		else
		{
			$weather = '不明';
		}

		return $weather;
	}
}