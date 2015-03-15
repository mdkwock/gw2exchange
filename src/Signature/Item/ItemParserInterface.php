<?php
namespace GW2ledger\Signature\Item;

use GW2ledger\Signature\Base\ParserInterface;

/**
 * This interface takes in a json string and creates an array
 * where all of the required fields for an item are converted to the right format for saving
 *
 * This interface was made so that there is a intermediate interface surrounding the GW2 endpoint
 * in case there is a change at the end point, does not care what you do with the data just makes it a uniform array
 */
interface ItemParserInterface extends ParserInterface
{
}