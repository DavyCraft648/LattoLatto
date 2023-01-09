<?php

namespace DavyCraft648\LattoLatto\item;

use customiesdevs\customies\item\component\FoodComponent;
use customiesdevs\customies\item\component\HandEquippedComponent;
use customiesdevs\customies\item\CreativeInventoryInfo;
use customiesdevs\customies\item\ItemComponentsTrait;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemUseResult;
use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\network\mcpe\protocol\AnimateEntityPacket;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\player\Player;

abstract class LattoLatto extends \pocketmine\item\Item implements \customiesdevs\customies\item\ItemComponents{
	use ItemComponentsTrait {
		getComponents as _getComponents;
	}

	public function __construct(ItemIdentifier $identifier, string $name = "Unknown"){
		parent::__construct($identifier, $name);
		$this->initComponent("pa_latto_latto", new CreativeInventoryInfo(CreativeInventoryInfo::CATEGORY_EQUIPMENT));

		$this->setUseCooldown(8.5, "reload");
		$this->addComponent(new FoodComponent(true));
		$this->addComponent(new HandEquippedComponent(true));
		$this->setUseDuration(999999);
	}

	public function getComponents() : CompoundTag{
		$components = $this->_getComponents()->getCompoundTag("components");
		$components->setTag("minecraft:render_offsets", CompoundTag::create()
			->setTag("main_hand", CompoundTag::create()
				->setTag("first_person", $scale = CompoundTag::create()->setTag("scale", new ListTag([new FloatTag(0.0), new FloatTag(0.0), new FloatTag(0.0)], NBT::TAG_Float)))
				->setTag("third_person", $scale)
			)
		);
		return CompoundTag::create()
			->setTag("components", $components);
	}

	public function getMaxStackSize() : int{
		return 1;
	}

	public function doAnimation(Player $player) : ItemUseResult{
		$player->getServer()->broadcastPackets($player->getWorld()->getViewersForPosition($pos = $player->getPosition()), [
			AnimateEntityPacket::create(
				"animation.pose.latto", "", "", 0, "", 0.1, [$player->getId()]
			),
			PlaySoundPacket::create("pa_latto_latto_shot", $pos->x, $pos->y, $pos->z, 1.0, 1.0)
		]);
		return ItemUseResult::SUCCESS();
	}
}
