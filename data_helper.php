<?php
function sanitize_htmltags($data)
{
	$ci = get_instance();
	if (is_array($data)) {
		foreach ($data as $key => $value) {
			if (is_array($value)) {
				$data[$key] = sanitize_htmltags($value); // Rekursif untuk array bersarang
			} else {
				// Hapus semua tag HTML, termasuk atributnya
				$cleaned_value = strip_tags($value);

				// Atur nilai dalam huruf besar
				$data[$key] = strtoupper($ci->db->escape_str($cleaned_value));
			}
		}
	} else {
		// Jika input bukan array, proses sebagai string tunggal
		$cleaned_data = strip_tags($data);

		// Atur nilai dalam huruf besar
		$data = strtoupper($ci->db->escape_str($cleaned_data));
	}

	return $data;
}
