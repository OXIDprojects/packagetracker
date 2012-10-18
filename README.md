packagetracker
==============

The PackageTracker-module gives you the ability to add a tracking-URL to each deliveryset. It takes the tracking-ID you can enter at each order an parses it into the tracking-URL, replacing the placeholder '[##TRKID##]'.

Originally Registered: 2010-02-25 by Andreas Hofmann on former OXIDforge

--------------------
/**
 *    This file is part of the "PackageTracker"-module.
 *
 *    The PackageTracker-module gives you the ability to add a tracking-URL to each
 *    deliveryset. It takes the tracking-ID you can enter at each order an parses it into
 *    the tracking-URL, replacing the placeholder '[##TRKID##]'.
 *
 * @link http://andy-hofmann.com
 * @package packagetracker
 * @copyright (C) Andreas Hofmann 2010, ich@andy-hofmann.com
 * @version 1.0
 */

## Setup: ##
# Database: #
To save a tracking-URL per deliveryset, you have to expand the oxdeliveryset-table
by one field. Take the SQL-query saved in the ptdeliveryset.sql-file that you should have
received with these files, execute it on your database and you should be fine.

# Templates: #
You also have to edit the templates to display the tracking-URL there. The linenumbers
are based on the standard-oxid files.

out/admin/tpl/deliveryset_main.tpl (Admin interface for adding/editing a deliveryset):
Insert between lines 50 and 51:
----------
<tr>
  <td class="edittext" width="140">
    [{ oxmultilang ident="DELIVERYSET_TRACKING_URL" }]
  </td>
  <td class="edittext" width="250">
    <input type="text" class="editinput" size="50" maxlength="[{$edit->oxdeliveryset__oxtrackurl->fldmax_length}]" name="editval[oxdeliveryset__oxtrackurl]" value="[{$edit->oxdeliveryset__oxtrackurl->value}]" [{ $readonly }]>
    [{ oxinputhelp ident="HELP_DELIVERYSET_TRACKINGURL" }]
  </td>
</tr>
----------

out/basic/tpl/account_order.tpl (The order-overview in the customerarea):
Place comment-brackets before line 54 and insert this code after it:
----------
<a href="[{ $deliveryset->getTrackingUrl($order->oxorder__oxtrackcode->value) }]" target="_blank">[{ oxmultilang ident="ACCOUNT_ORDER_TRACKSHIPMENT" }]</a>
----------

out/basic/tpl/email_sendednow_html.tpl (The HTML-email that the package is out for delivery):
Insert this code between lines 23 and 24:
----------
[{ if $order->oxorder__oxtrackcode->value }]
  [{ assign var="deliveryset" value=$order->getDelSet() }]
  [{ oxmultilang ident="EMAIL_SENDEDNOW_HTML_YOUCANTRACK" }]: <a href="[{ $deliveryset->getTrackingUrl($order->oxorder__oxtrackcode->value) }]" target="_blank">[{ oxmultilang ident="EMAIL_SENDEDNOW_HTML_TRACKLINK" }]</a>
  <br /><br />
[{ /if }]
----------

out/basic/tpl/email_sendednow_plain.tpl (The plaintext-email that the package is out for delivery):
Insert this code at line 18:
----------
[{ if $order->oxorder__oxtrackcode->value }]
  [{ assign var="deliveryset" value=$order->getDelSet() }]
  [{ oxmultilang ident="EMAIL_SENDEDNOW_HTML_YOUCANTRACK" }]: [{ $deliveryset->getTrackingUrl($order->oxorder__oxtrackcode->value) }]
[{ /if }]
----------

# Language-files: #
Finally you have to add a few lines to the language files:

out/admin/de/cust_lang.php:
Insert at the end of the file (maybe you have to add a comma before the first line):
----------
'DELIVERYSET_TRACKING_URL'                  => 'Tracking-URL',
'EMAIL_SENDEDNOW_HTML_YOUCANTRACK'          => 'Sie können Ihr Paket über diesen Link verfolgen',
'EMAIL_SENDEDNOW_HTML_TRACKLINK'            => 'Zur Paketverfolgung'
----------

out/admin/de/help_lang.php:
Insert at the end of the file (maybe you have to add a comma before the first line):
----------
'HELP_DELIVERYSET_TRACKINGURL'                     => 'Bei <span class="navipath_or_inputname">Tracking-URL</span> können Sie die URL angeben, die beim Logistikpartner zur Paketverfolgung verwendet wird. In der URL können Sie den Platzhalter <span class="navipath_or_inputname">[##TRKID##]</span> unterbringen, für den dann die bei der Bestellung angegebene Tracking-ID eingefügt wird.',
----------

That's it! And to give you a start, I found out some Tracking URLs you can use:

(German) DHL: http://nolp.dhl.de/nextt-online-public/set_identcodes.do?lang=de&idc=[##TRKID##]
DPD: http://extranet.dpd.de/cgi-bin/delistrack?typ=1&lang=de&pknr=[##TRKID##]
Hermes: http://tracking.hlg.de/Tracking.jsp?TrackID=[##TRKID##]
UPS: http://wwwapps.ups.com/WebTracking/processRequest?HTMLVersion=5.0&Requester=NES&AgreeToTermsAndConditions=yes&loc=de_DE&tracknum=[##TRKID##]
USPS: http://trkcnfrm1.smi.usps.com/PTSInternetWeb/InterLabelInquiry.do?origTrackNum=[##TRKID##]