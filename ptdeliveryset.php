<?php
/**
 *    This file is part of the "PackageTracker"-module.
 *
 *    The PackageTracker-module gives you the ability to add a tracking-URL to each
 *    deliveryset. It takes the tracking-ID you can enter at each order an parses it into
 *    the tracking-URL, replacing the placeholder '[##TRKID##]'.
 *
 *    Setup:
 *    For setting up the module please read the readme.txt you should have received with
 *    these files.
 *
 *    HowTo:
 *    You can now enter a Tracking-URL for each logistic partner in your database (You can
 *    find some examples at the bottom of the readme.txt). Do this by using the form in the
 *    adminpanel: Shopeinstellungen => Versandarten
 *    In this URL you can nest the
 *    placeholder '[##TRKID##]' which will be replaced with the tracking-ID you can enter
 *    to each order. The placeholder can be anywhere in the URL:
 *    For example:
 *    http://nolp.dhl.de/nextt-online-public/set_identcodes.do?lang=de&idc=[##TRKID##]
 *    or
 *    http://nolp.dhl.de/nextt-online-public/set_identcodes.do?lang=de&idc=[##TRKID##]&andSomeOtherStuff=foobar
 *    Now the trackinglink will be parsed into the shipping-emails and the customer-area
 *    if you enter a tracking-ID to the order.
 *
 * @link http://andy-hofmann.com
 * @package packagetracker
 * @copyright (C) Andreas Hofmann 2010, ich@andy-hofmann.com
 * @version 1.0
 */

/**
 * Packagetracker module.
 *
 * This is the module-class which parses thr trackng-ID into the given tracking-URL.
 *
 * @package packagetracker
 */
class ptDeliverySet extends oxDeliverySet {

  /**
   * Returns the parsed tracking-URL.
   *
   * This method reads the tracking-URL from the current deliveryset. If there is one and
   * a tracking-ID is provided, this ID will be parsed into the URL, replacing the place-
   * holder '[##TRKID##]'.
   *
   * @param string $sTrackingId The tracking-ID that should be parsed into the URL
   *
   * @return string Complete tracking-URL
   */
  public function getTrackingUrl($sTrackingId = '') {

    $sTrackingUrl = isset($this->oxdeliveryset__oxtrackurl) ? $this->oxdeliveryset__oxtrackurl : '';

    // If there is a tracking-url for this deliveryset and we got a tracking-id, parse it into the tracking-url
    if(!empty($sTrackingUrl) && !empty($sTrackingId)) {
      $sTrackingUrl = str_ireplace('[##TRKID##]', $sTrackingId, $sTrackingUrl);
    }

    return $sTrackingUrl;
  }
}

?>