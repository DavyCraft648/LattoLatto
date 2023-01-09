<?php

namespace DavyCraft648\LattoLatto;

use customiesdevs\customies\item\CustomiesItemFactory;
use DavyCraft648\LattoLatto\item\LattoLattoPM4;
use DavyCraft648\LattoLatto\item\LattoLattoPM5;
use pocketmine\resourcepacks\ZippedResourcePack;
use pocketmine\VersionInfo;
use Symfony\Component\Filesystem\Path;

final class Main extends \pocketmine\plugin\PluginBase{

	protected function onLoad() : void{
		$this->saveResource("LattoLattoRP.mcpack");
		$newPack = new ZippedResourcePack(Path::join($this->getDataFolder(), "LattoLattoRP.mcpack"));
		$rpManager = $this->getServer()->getResourcePackManager();
		$resourcePacks = new \ReflectionProperty($rpManager, "resourcePacks");
		$resourcePacks->setAccessible(true);
		$resourcePacks->setValue($rpManager, array_merge($resourcePacks->getValue($rpManager), [$newPack]));
		$uuidList = new \ReflectionProperty($rpManager, "uuidList");
		$uuidList->setAccessible(true);
		$uuidList->setValue($rpManager, $uuidList->getValue($rpManager) + [strtolower($newPack->getPackId()) => $newPack]);
		$serverForceResources = new \ReflectionProperty($rpManager, "serverForceResources");
		$serverForceResources->setAccessible(true);
		$serverForceResources->setValue($rpManager, true);
		CustomiesItemFactory::getInstance()->registerItem(VersionInfo::BASE_VERSION[0] === "5" ? LattoLattoPM5::class : LattoLattoPM4::class, "pa:latto_latto", "Latto Latto");
	}
}
