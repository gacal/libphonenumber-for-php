<?php
/**
 * Created by PhpStorm.
 * User: giggsey
 * Date: 7/27/13
 * Time: 11:53 PM
 */

namespace libphonenumber\prefixmapper;


use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberUtil;


/**
 * A utility that maps phone number prefixes to a description string,
 * which may be, for example, the geographical area the prefix covers.
 *
 * Class PhonePrefixMap
 * @package libphonenumber\prefixmapper
 */
class PhonePrefixMap
{
    private $phonePrefixMapStorage = array();
    /**
     * @var PhoneNumberUtil
     */
    private $phoneUtil;

    public function __construct($map)
    {
        $this->phonePrefixMapStorage = $map;
        $this->phoneUtil = PhoneNumberUtil::getInstance();
    }

    /**
     * Returns the description of the {@code $number}. This method distinguishes the case of an invalid
     * prefix and a prefix for which the name is not available in the current language. If the
     * description is not available in the current language an empty string is returned. If no
     * description was found for the provided number, null is returned.
     *
     * @param PhoneNumber $number The phone number to look up
     * @return string|null the description of the number
     */
    public function lookup(PhoneNumber $number)
    {
        if (count($this->phonePrefixMapStorage) == 0) {
            return null;
        }

        $phonePrefix = $number->getCountryCode() . $this->phoneUtil->getNationalSignificantNumber($number);

        while (strlen($phonePrefix) > 0) {
            if (array_key_exists($phonePrefix, $this->phonePrefixMapStorage)) {
                return $this->phonePrefixMapStorage[$phonePrefix];
            }

            $phonePrefix = substr($phonePrefix, 0, -1);
        }

        return null;
    }

} 