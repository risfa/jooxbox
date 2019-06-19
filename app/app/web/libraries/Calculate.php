<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Calculate{
    public function distance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6378137) {
		$latFrom = deg2rad((double)$latitudeFrom);
		$lonFrom = deg2rad((double)$longitudeFrom);
		$latTo = deg2rad((double)$latitudeTo);
		$lonTo = deg2rad((double)$longitudeTo);

		$lonDelta = $lonTo - $lonFrom;
		$a = pow(cos($latTo) * sin($lonDelta), 2) + pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
		$b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

		$angle = atan2(sqrt($a), $b);
		return $angle * $earthRadius;
	}
}