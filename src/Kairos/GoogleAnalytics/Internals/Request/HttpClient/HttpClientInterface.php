<?php

/**
 * Generic Server-Side Google Analytics PHP Client
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License (LGPL) as published by the Free Software Foundation; either
 * version 3 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA.
 *
 * Google Analytics is a registered trademark of Google Inc.
 *
 * @link      http://code.google.com/p/php-ga
 *
 * @license   http://www.gnu.org/licenses/lgpl.html
 * @author    Thomas Bachem <tb@unitedprototype.com>
 * @copyright Copyright (c) 2010 United Prototype GmbH (http://unitedprototype.com)
 */

namespace  Kairos\GoogleAnalytics\Internals\Request\HttpClient;

use  Kairos\GoogleAnalytics\Config;

interface HttpClientInterface {


    /*
     * @return bool
     */
    public function debug();


    /**
     * @return \Kairos\GoogleAnalytics\Config
     */
    public function getConfig();

    /**
     * @param \Kairos\GoogleAnalytics\Config $config
     */
    public function setConfig(Config $config);


    /**
     * @return \Kairos\GoogleAnalytics\Config
     */
    public function getRequestString();


    /**
     * @param \Kairos\GoogleAnalytics\Config $config
     */
    public function setRequestString($requestString);


    /**
     * @param string
     */
    public function sendRequest();


}

?>