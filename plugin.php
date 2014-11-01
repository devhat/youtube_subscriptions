<?php

	class youtube_subscriptions extends SlackServicePlugin {

		public $name = "YouTube Subscriptions";
		public $desc = "My Subscriptions updates.";

		public $cfg = array(
			'has_token'	=> true,
		);

		function onInit(){

			$channels = $this->getChannelsList();
			foreach ($channels as $k => $v){
				if ($v == '#general'){
					$this->icfg['channel'] = $k;
					$this->icfg['channel_name'] = $v;
					break;
				}
			}

			$this->icfg['botname']	= 'youtube';

		}

		function onView(){

			return $this->smarty->fetch('view.txt');
		}

		function onEdit(){

			$channels = $this->getChannelsList();

			if ($_GET['save']){

				$this->icfg['channel'] = $_POST['channel'];
				$this->icfg['channel_name'] = $channels[$_POST['channel']];
				$this->icfg['youtube'] = $_POST['youtube'];
				$this->icfg['botname'] = $_POST['botname'];
				$this->saveConfig();

				header("location: {$this->getViewUrl()}&saved=1");
				exit;
			}

			$this->smarty->assign('channels', $channels);

			return $this->smarty->fetch('edit.txt');
		}

		function onHook($req){

			if (!$this->icfg['channel']){
				return array(
					'ok'	=> false,
					'error'	=> "No channel configured",
				);
			}

			// ...

		}

		function getLabel(){
			return "New video posted to {$this->icfg['channel_name']} as {$this->icfg['youtube']}";
		}

	}
