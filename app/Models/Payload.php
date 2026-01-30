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

namespace Tirreno\Models;

class Payload extends \Tirreno\Models\BaseSql {
    protected $DB_TABLE_NAME = 'event_payload';

    public function getByEventId(int $eventId, int $apiKey): ?string {
        $params = [
            ':event_id' => $eventId,
            ':api_key'  => $apiKey,
        ];

        $query = (
            'SELECT
                event_payload.payload
            FROM
                event
            LEFT JOIN event_payload
            ON (event.payload = event_payload.id)
            WHERE
                event.id = :event_id AND
                event_payload.key = :api_key'
        );

        $result = $this->execQuery($query, $params);

        return count($result) ? $result[0]['payload'] : null;
    }
}
