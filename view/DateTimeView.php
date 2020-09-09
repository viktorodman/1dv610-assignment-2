<?php

class DateTimeView {


	public function show() {
		date_default_timezone_set('Europe/Stockholm');
		$dateTime = new DateTime('now');

		$dayText = date('l');
		$dayNumber = date('jS');
		$monthAndYear = date('F Y');
		$timeHoursMinutesSeconds = date('H:i:s');

		$timeString = "{$dayText}, The {$dayNumber} of {$monthAndYear}, The time is {$timeHoursMinutesSeconds}";

		return "<p>{$timeString}</p>";
	}
}