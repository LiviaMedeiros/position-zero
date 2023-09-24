<?php declare(strict_types=1);
[
	'WAKARIMASU_INIT_URL' => $INIT_URL,
	'WAKARIMASU_VERSION' => $VERSION,
] = getenv();

function fetch(string $base, string $type, array $data): bool {
	$cachefile = $type . '.yaml';
	$cache = yaml_parse_file($cachefile);
	foreach ($data as [$a, $b, $c, $d, $size]) {
		$part = $a . '_0_' . $b . '_' . $c . '_' . $d;
		if (isset($cache[$part])) continue;
		$filename = $part . '.zip';
		$file = file_get_contents($base . '/' . $filename);
		$filesize = strlen($file);
		file_put_contents($filename, $file);
		if ($size !== $filesize) {
			echo "size mismatch! $size !== $filesize\n";
			continue;
		}
		$cache[$part] = $size;
	}
	return yaml_emit_file($cachefile, $cache);
}

[
	'patch_main' => $main,
	'patch_extra' => $extra,
	'patch_extra_localize' => $extra_localize,
	'patch_server_url' => $base,
] = json_decode(file_get_contents($INIT_URL . '?' . http_build_query([
	'patch_main_localize_ver' => 'a',
	'terms_of_service_ver' => '2',
	'privacy_policy_ver' => '5',
	'package_type' => '3',
	'patch_extra_localize_id' => '1',
	'app_ver' => $VERSION,
	'patch_extra_localize_ver' => 'a',
	'maintenance_check' => '1',
	'patch_extra_id' => '1',
	'patch_main_id' => '1',
	'patch_extra_ver' => 'a',
	'lang_id' => '2',
	'patch_main_ver' => 'a',
	'player_id'=> '0',
	'patch_main_localize_id' => '1',
])), true);

if (!$base) exit(1);

$main && fetch($base, 'main', $main);
$extra && fetch($base, 'extra', $extra);
//$extra_localize && fetch($base, 'extra_localize', $extra_localize);