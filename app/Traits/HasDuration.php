<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasDuration
{
	public function convertDurationToString(): string
	{
		if ($this->duration == 0) {
			return '0min';
		}
		$totalSeconds = (int)$this->duration;
		$hours = floor($totalSeconds / 3600);
		$minutes = floor(($totalSeconds % 3600) / 60);

		$result = '';
		if ($hours > 0) {
			$result .= $hours . 'hr';
		}
		if ($minutes !== 0) {
			if ($result !== '') {
				$result .= ' ';
			}
			$result .= $minutes . Str::plural('min', $minutes);
		}
		return $result ?: '0min';
	}

	public function convertDurationToTime(): string
	{
		if ($this->duration === 0) {
			return '00:00';
		}

		$totalSeconds = (int)$this->duration;
		$minutes = floor(($totalSeconds % 3600) / 60);
		$seconds = $totalSeconds % 60;


		return sprintf('%02d:%02d', $minutes, $seconds);
	}
}
