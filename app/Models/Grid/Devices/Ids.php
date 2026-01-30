<?php

/**
 * Akira ~ open-source security framework
 * Based on Tirreno (https://github.com/TirrenoTechnologies/tirreno)
 * Copyright (c) Tirreno Technologies Sàrl (https://www.tirreno.com)
 * Modified by Cyber Security and Privacy Foundation (https://cysecurity.org)
 *
 * Licensed under GNU Affero General Public License version 3 of the or any later version.
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Tirreno Technologies Sàrl, Cyber Security and Privacy Foundation
 * @license       https://opensource.org/licenses/AGPL-3.0 AGPL License
 * @link          https://cysecurity.org Akira
 */

declare(strict_types=1);

namespace Tirreno\Models\Grid\Devices;

class Ids extends \Tirreno\Models\Grid\Base\Ids {
    public function getDevicesIdsByIpId(): string {
        return (
            'SELECT DISTINCT
                event.device AS itemid
            FROM event
            WHERE
                event.ip = :ip_id AND
                event.key = :api_key'
        );
    }

    public function getDevicesIdsByUserId(): string {
        return (
            'SELECT DISTINCT
                event_device.id AS itemid
            FROM event_device
            WHERE
                event_device.account_id = :account_id AND
                event_device.key = :api_key'
        );
    }

    public function getDevicesIdsByResourceId(): string {
        return (
            'SELECT DISTINCT
                event.device AS itemid
            FROM event
            WHERE
                event.url = :resource_id AND
                event.key = :api_key'
        );
    }
}
