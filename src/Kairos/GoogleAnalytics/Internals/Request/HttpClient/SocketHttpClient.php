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


class SocketHttpClient extends AbstractHttpClient {


    public function formatRequest() {

        //build socket request
        if($this->requestString['method'] == "GET") {
            $r = $this->requestString['method'] . $this->getConfig()->getEndpointPath() . '?' . $this->requestString['query'];
        } else {
            // FIXME: The "/p" shouldn't be hardcoded here, instead we need a GET and a POST endpoint...
            $r = $this->requestString['method'] . ' /p' . $this->getConfig()->getEndpointPath();
        }

        $r .= " " . $this->requestString['header'];

        if($this->requestString['method'] == "POST") {
            $r .= $this->requestString['query'];
        }

        return $r;
    }

    /**
     * send request
     *
     */
    public function sendRequest() {


        if($this->getConfig()->getEndpointHost() !== null) {

            $request = $this->formatRequest();
            $response = "";

            $timeout = $this->getConfig()->getRequestTimeout();

            $socket = fsockopen($this->getConfig()->getEndpointHost(), 80, $errno, $errstr, $timeout);
            if(!$socket) return false;

            if($this->getConfig()->getFireAndForget()) {
                stream_set_blocking($socket, false);
            }

            $timeoutS  = intval($timeout);
            $timeoutUs = ($timeout - $timeoutS) * 100000;
            stream_set_timeout($socket, $timeoutS, $timeoutUs);

            // Ensure that the full request is sent (see http://code.google.com/p/php-ga/issues/detail?id=11)
            $sentData = 0;
            $toBeSentData = strlen($request);
            while($sentData < $toBeSentData) {
                $sentData += fwrite($socket, $request);
            }

            if(!$this->getConfig()->getFireAndForget()) {
                while(!feof($socket)) {
                    $response .= fgets($socket, 512);
                }
            }

            fclose($socket);
        }

        if($loggingCallback = $this->getConfig()->getLoggingCallback()) {
            $loggingCallback($request, $response);
        }

        return $response;
    }

}

?>