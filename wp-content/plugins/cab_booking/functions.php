<?php
function EncHashPassword()
{
	return "Zxasqw#$&*976776#$^&";
}
function CabEncrypt($text)
{
	$password=EncHashPassword();
	return openssl_encrypt($text,"AES-128-ECB",$password);
}
function CabDecrypt()
{
	$password=EncHashPassword();
	return openssl_decrypt($text,"AES-128-ECB",$password);
}