<?php
/**
 * This file contains the implementation for the TCOM frame
 *
 * PHP version 5
 *
 * Copyright (C) 2006-2007 Alexander Merz
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category  File_Formats
 * @package   MP3_IDv2
 * @author    Alexander Merz <alexander.merz@web.de>
 * @copyright 2006-2007 Alexander Merz
 * @license   http://www.gnu.org/licenses/lgpl.html LGPL 2.1
 * @version   CVS: $Id: TCOM.php 248624 2007-12-20 19:07:33Z alexmerz $
 * @link      http://pear.php.net/package/MP3_IDv2
 * @since     File available since Release 0.1
 */

/**
 * load parent class
 */
require_once 'MP3/IDv2/Frame/CommonText.php';

/**
 * Data stucture for TCOM frame in a tag
 * (Composer(s))
 *
 * @category File_Formats
 * @package  MP3_IDv2
 * @author   Alexander Merz <alexander.merz@web.de>
 * @license  http://www.gnu.org/licenses/lgpl.html LGPL 2.1
 * @version  Release: @package_version@
 * @link     http://pear.php.net/package/MP3_IDv2
 * @since    Class available since Release 0.1.0
 */
class MP3_IDv2_Frame_TCOM extends MP3_IDv2_Frame_CommonText
{

    /**
     * Sets the id and purpose of the frame only
     *
     * @return void
     * @access public
     */
    public function __construct()
    {
        $this->setId("TCOM");
        $this->setPurpose("Composer(s)");
    }

    /**
     * Returns the composers as list of strings
     *
     * @return array list of the composers
     * @access public
     */
    public function getComposers()
    {
        return explode('/', $this->getText());
    }

    /**
     * Adds a composer to the composers
     *
     * @param string $comp a composer
     *
     * @return void
     * @access public
     */
    public function addComposer($comp)
    {
        $t = $this->getText();
        if ("" == $t) {
            $t = $comp;
        } else {
            $t = $t."/".$comp;
        }
        $this->setText($t);
    }
}
?>