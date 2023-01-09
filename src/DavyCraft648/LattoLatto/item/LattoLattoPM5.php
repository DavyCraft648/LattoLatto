<?php

namespace DavyCraft648\LattoLatto\item;

use pocketmine\item\ItemUseResult;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class LattoLattoPM5 extends LattoLatto{
	/** @noinspection PhpHierarchyChecksInspection */
	public function onClickAir(Player $player, Vector3 $directionVector, array &$returnedItems) : ItemUseResult{
		return $this->doAnimation($player);
	}
}
