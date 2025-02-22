<?php

namespace CLADevs\VanillaX\blocks\block;

use CLADevs\VanillaX\inventories\types\EnchantInventory;
use pocketmine\block\BlockBreakInfo;
use pocketmine\block\BlockIdentifier;
use pocketmine\block\BlockLegacyIds;
use pocketmine\block\BlockToolType;
use pocketmine\block\EnchantingTable;
use pocketmine\block\tile\EnchantTable;
use pocketmine\item\Item;
use pocketmine\item\ToolTier;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class EnchantmentTableBlock extends EnchantingTable{

    public function __construct(){
        parent::__construct(new BlockIdentifier(BlockLegacyIds::ENCHANTING_TABLE, 0, null, EnchantTable::class), "Enchanting Table", new BlockBreakInfo(5.0, BlockToolType::PICKAXE, ToolTier::WOOD()->getHarvestLevel(), 6000.0));
    }

    public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null): bool{
        $player?->setCurrentWindow(new EnchantInventory($this->getPosition()));
        return true;
    }
}
