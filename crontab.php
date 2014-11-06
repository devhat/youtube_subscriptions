<?php

	$dir = dirname(__FILE__) . "/../../";
	include( "{$dir}/lib/config.php" );
	include( "{$dir}/data/data_instances.php" );

	class YoutubeResponse {

		function __construct( $channel ) {
			$this->channel = $channel;
		}

		function getVideo() {

			$doc = new DOMDocument();
			$url = "https://gdata.youtube.com/feeds/api/users";
			$url .= "/{$this->channel}/uploads?max-results=1";

			@$doc->loadHTMLFile($url);
			$xpath = new DOMXpath($doc);

			foreach ($xpath->query("//id[contains(text(),'videos')]") as $node) {
				$video = preg_replace('/.*\/(.+)$/', '$1', $node->nodeValue);
			}

			return $video;
		}

	}


	$hooks = array_filter($data, function($entry) {
		return ($entry['plugin'] == 'youtube_subscriptions');
	});

	foreach ($hooks as $id => $hook) {

		$youtube = new YoutubeResponse($hook['youtube']);

		if ( !strpos(file_get_contents("{$dir}/data/data_hooks.php"), $youtube->getVideo()) ) {

			$options = array('http' => array('method'  => 'POST',
				'content' => http_build_query(array('video' => $youtube->getVideo() )) ));

			file_get_contents("{$cfg['root_url']}hook.php?id={$id}&token={$hook['token']}",
				false, stream_context_create($options) );
		}

	}

?>