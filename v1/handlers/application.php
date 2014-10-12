<?php
class Application {
	public static function validateKey($key) {}

	private function generateKey() {
		return md5(uniqid(rand(), true));
	}
}