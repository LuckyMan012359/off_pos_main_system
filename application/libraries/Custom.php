<?php 
class Custom{
	function encrypt_decrypt($key, $type){
		# type = encrypt/decrypt
		$str_rand = "XxOx*4e!hQqG5b~9a";
		if( !$key ){ return false; }
		if($type=='decrypt'){
			$en_slash_added = trim(str_replace( array('off_pos'), '/', $key));
			$key_value = $return=openssl_decrypt($en_slash_added,"AES-128-ECB",$str_rand);
			return $key_value;
		}elseif($type=='encrypt'){
			$key_value = openssl_encrypt($key,"AES-128-ECB",$str_rand);
			$en_slash_remove = trim(str_replace(array('/'), 'off_pos', $key_value));
			return $en_slash_remove;
		}
		return FALSE;	# if function is not used properly
	}
}
?>