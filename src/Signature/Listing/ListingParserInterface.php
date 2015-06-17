<?php
namespace GW2Exchange\Signature\Listing;

use GW2Exchange\Signature\Base\ParserInterface;

/**
 * This interface takes in a json string and creates an array
 * where all of the required fields for an listing are converted to the right format for saving
 *
 * This interface was made so that there is a intermediate interface surrounding the GW2 endpoint
 * in case there is a change at the end point, does not care what you do with the data just makes it a uniform array
 */
interface ListingParserInterface extends ParserInterface
{
}