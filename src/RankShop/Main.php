<?php

declare(strict_type=1);

namespace RankShop;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use jojoe77777\FormAPI;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\utils\Config;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\event\server\ServerCommandEvent;
use pocketmine\Player;
use pocketmine\Server;
use onebone\economyapi\EconomyAPI;
use RankShop\Main;

class Main extends PluginBase implements Listener{
    
    public function onEnable(){
        $this->getLogger()->info("§aStarting RankShopUI plugin...");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->eco = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
		
		@mkdir($this->getDataFolder());
        $this->saveResource("config.yml");
        $this->settings = new Config($this->getDataFolder() . "config.yml", Config::YAML);
    }

    public function checkDepends(){
        $this->formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        if(is_null($this->formapi)){
            $this->getLogger()->error("§4Please install FormAPI Plugin, disabling RankShopUI plugin...");
            $this->getPluginLoader()->disablePlugin($this);
        }
    }

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args):bool{
        if($cmd->getName() == "rankshop"){
        if(!($sender instanceof Player)){
                $sender->sendMessage("§cPlease use this command from In-game!", false);
                return true;
        }
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 0:
                    $sender->sendMessage($this->getConfig()->get("cancelled"));
                        break;
                    case 1:
                    $this->VIP($sender);
                        break;
                    case 2:
                    $this->VIP+($sender);
                        break;
					case 3:
					$this->MVP($sender);
						break;
					case 4:
					$this->MVP+($sender);
						break;
					case 5:
					$this->GOD($sender);
						break;
					case 6:
					$this->DESTROYER($sender);
						break;
					case 7:
					$this->ELITE($sender);
						break;
					case 8:
					$this->KING($sender);
						break;
					case 9:
					$this->QUEEN($sender);
						break;
            }
        });
        $form->setContent("Choose if you want to heal, feed yourself.");
        $form->addButton("§cExit", 0);
        $form->addButton("VIP", 1);
        $form->addButton("VIP+", 2);
		$form->addButton("MVP", 3);
		$form->addButton("MVP+", 4);
		$form->addButton("GOD", 5);
		$form->addButton("DESTROYER", 6);
		$form->addButton("ELITE", 7);
		$form->addButton("KING", 8);
		$form->addButton("QUEEN", 9);    
		$form->sendToPlayer($sender);
        }
        return true;
    }

    public function VIP($sender){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createModalForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 1:
            $money = $this->eco->myMoney($sender);
            $vip = $this->settings->get("vip.cost");
            if($money >= $vip){
                
               $this->eco->reduceMoney($sender, $vip);
            $this->getServer()->dispatchCommand(new ConsoleCommandSender(), "setgroup " . $sender->getName() . " vip");
            return true;
               $sender->sendMessage($this->getConfig()->get("vip.buy.success"));
              return true;
            }else{
               $sender->sendMessage($this->getConfig()->get("vip.no.money"));
            }
                        break;
                    case 2:
               $sender->sendMessage($this->getConfig()->get("vip.cancelled"));
                        break;
            }
        });
        $form->setTitle("§lVIP");
        $form->setContent($this->getConfig()->get("vip.content"));
        $form->setButton1("Confirm", 1);
        $form->setButton2("Cancel", 2);
        $form->sendToPlayer($sender);
    }

    public function VIP+($sender){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createModalForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 1:
            $money = $this->eco->myMoney($sender);
            $vip+ = $this->settings->get("vip+.cost");
            if($money >= $vip){
                
               $this->eco->reduceMoney($sender, $vip+);
            $this->getServer()->dispatchCommand(new ConsoleCommandSender(), "setgroup " . $sender->getName() . " vip+");
            return true;
               $sender->sendMessage($this->getConfig()->get("vip+.buy.success"));
              return true;
            }else{
               $sender->sendMessage($this->getConfig()->get("vip+.no.money"));
            }
                        break;
                    case 2:
               $sender->sendMessage($this->getConfig()->get("vip+.cancelled"));
                        break;
            }
        });
        $form->setTitle("§lVIP+");
        $form->setContent($this->getConfig()->get("vip+.content"));
        $form->setButton1("Confirm", 1);
        $form->setButton2("Cancel", 2);
        $form->sendToPlayer($sender);
    }

    public function MVP($sender){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createModalForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 1:
            $money = $this->eco->myMoney($sender);
            $mvp = $this->settings->get("mvp.cost");
            if($money >= $mvp){
                
               $this->eco->reduceMoney($sender, $mvp);
            $this->getServer()->dispatchCommand(new ConsoleCommandSender(), "setgroup " . $sender->getName() . " mvp");
            return true;
               $sender->sendMessage($this->getConfig()->get("mvp.buy.success"));
              return true;
            }else{
               $sender->sendMessage($this->getConfig()->get("mvp.no.money"));
            }
                        break;
                    case 2:
               $sender->sendMessage($this->getConfig()->get("mvp.cancelled"));
                        break;
            }
        });
        $form->setTitle("§lMVP");
        $form->setContent($this->getConfig()->get("mvp.content"));
        $form->setButton1("Confirm", 1);
        $form->setButton2("Cancel", 2);
        $form->sendToPlayer($sender);
    }
	
    public function MVP+($sender){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createModalForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 1:
            $money = $this->eco->myMoney($sender);
            $mvp+ = $this->settings->get("mvp+.cost");
            if($money >= $mvp+){
                
               $this->eco->reduceMoney($sender, $mvp+);
            $this->getServer()->dispatchCommand(new ConsoleCommandSender(), "setgroup " . $sender->getName() . " mvp+");
            return true;
               $sender->sendMessage($this->getConfig()->get("mvp+.buy.success"));
              return true;
            }else{
               $sender->sendMessage($this->getConfig()->get("mvp+.no.money"));
            }
                        break;
                    case 2:
               $sender->sendMessage($this->getConfig()->get("mvp+.cancelled"));
                        break;
            }
        });
        $form->setTitle("§lMVP+");
        $form->setContent($this->getConfig()->get("mvp+.content"));
        $form->setButton1("Confirm", 1);
        $form->setButton2("Cancel", 2);
        $form->sendToPlayer($sender);
    }
	
	    public function GOD($sender){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createModalForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 1:
            $money = $this->eco->myMoney($sender);
            $god = $this->settings->get("god.cost");
            if($money >= $god){
                
               $this->eco->reduceMoney($sender, $god);
            $this->getServer()->dispatchCommand(new ConsoleCommandSender(), "setgroup " . $sender->getName() . " god");
            return true;
               $sender->sendMessage($this->getConfig()->get("god.buy.success"));
              return true;
            }else{
               $sender->sendMessage($this->getConfig()->get("god.no.money"));
            }
                        break;
                    case 2:
               $sender->sendMessage($this->getConfig()->get("god.cancelled"));
                        break;
            }
        });
        $form->setTitle("§lGOD");
        $form->setContent($this->getConfig()->get("god.content"));
        $form->setButton1("Confirm", 1);
        $form->setButton2("Cancel", 2);
        $form->sendToPlayer($sender);
    }
	
	    public function DESTROYER($sender){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createModalForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 1:
            $money = $this->eco->myMoney($sender);
            $destroyer = $this->settings->get("destroyer.cost");
            if($money >= $destroyer){
                
               $this->eco->reduceMoney($sender, $destroyer);
            $this->getServer()->dispatchCommand(new ConsoleCommandSender(), "setgroup " . $sender->getName() . " destroyer");
            return true;
               $sender->sendMessage($this->getConfig()->get("destroyer.buy.success"));
              return true;
            }else{
               $sender->sendMessage($this->getConfig()->get("destroyer.no.money"));
            }
                        break;
                    case 2:
               $sender->sendMessage($this->getConfig()->get("destroyer.cancelled"));
                        break;
            }
        });
        $form->setTitle("§lDESTROYER");
        $form->setContent($this->getConfig()->get("destroyer.content"));
        $form->setButton1("Confirm", 1);
        $form->setButton2("Cancel", 2);
        $form->sendToPlayer($sender);
    }
	
	    public function ELITE($sender){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createModalForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 1:
            $money = $this->eco->myMoney($sender);
            $elite = $this->settings->get("elite.cost");
            if($money >= $elite){
                
               $this->eco->reduceMoney($sender, $elite);
            $this->getServer()->dispatchCommand(new ConsoleCommandSender(), "setgroup " . $sender->getName() . " elite");
            return true;
               $sender->sendMessage($this->getConfig()->get("elite.buy.success"));
              return true;
            }else{
               $sender->sendMessage($this->getConfig()->get("elite.no.money"));
            }
                        break;
                    case 2:
               $sender->sendMessage($this->getConfig()->get("elite.cancelled"));
                        break;
            }
        });
        $form->setTitle("§lELITE");
        $form->setContent($this->getConfig()->get("elite.content"));
        $form->setButton1("Confirm", 1);
        $form->setButton2("Cancel", 2);
        $form->sendToPlayer($sender);
    }
	
	    public function KING($sender){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createModalForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 1:
            $money = $this->eco->myMoney($sender);
            $king = $this->settings->get("king.cost");
            if($money >= $king){
                
               $this->eco->reduceMoney($sender, $king);
            $this->getServer()->dispatchCommand(new ConsoleCommandSender(), "setgroup " . $sender->getName() . " king");
            return true;
               $sender->sendMessage($this->getConfig()->get("king.buy.success"));
              return true;
            }else{
               $sender->sendMessage($this->getConfig()->get("king.no.money"));
            }
                        break;
                    case 2:
               $sender->sendMessage($this->getConfig()->get("king.cancelled"));
                        break;
            }
        });
        $form->setTitle("§lKING");
        $form->setContent($this->getConfig()->get("king.content"));
        $form->setButton1("Confirm", 1);
        $form->setButton2("Cancel", 2);
        $form->sendToPlayer($sender);
    }
	
	    public function QUEEN($sender){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createModalForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 1:
            $money = $this->eco->myMoney($sender);
            $queen = $this->settings->get("queen.cost");
            if($money >= $queen){
                
               $this->eco->reduceMoney($sender, $queen);
            $this->getServer()->dispatchCommand(new ConsoleCommandSender(), "setgroup " . $sender->getName() . " queen");
            return true;
               $sender->sendMessage($this->getConfig()->get("queen.buy.success"));
              return true;
            }else{
               $sender->sendMessage($this->getConfig()->get("queen.no.money"));
            }
                        break;
                    case 2:
               $sender->sendMessage($this->getConfig()->get("queen.cancelled"));
                        break;
            }
        });
        $form->setTitle("§lQUEEN");
        $form->setContent($this->getConfig()->get("queen.content"));
        $form->setButton1("Confirm", 1);
        $form->setButton2("Cancel", 2);
        $form->sendToPlayer($sender);
    }

    public function onDisable(){
        $this->getLogger()->info("§cDisabling RankShopUI plugin...");
    }
}