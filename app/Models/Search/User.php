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

namespace Tirreno\Models\Search;

class User extends \Tirreno\Models\BaseSql {
    protected $DB_TABLE_NAME = 'event_account';

    public function searchByUserId(string $query, int $apiKey): array {
        $params = [
            ':api_key' => $apiKey,
            ':query' => "%{$query}%",
        ];

        $query = (
            "SELECT
                event_account.id     AS id,
                'ID'                 AS \"groupName\",
                'id'                 AS \"entityId\",
                event_account.userid AS value

            FROM
                event_account

            WHERE
                LOWER(event_account.userid) LIKE LOWER(:query) AND
                event_account.key = :api_key

            LIMIT 25 OFFSET 0"
        );

        return $this->execQuery($query, $params);
    }

    public function searchByName(string $query, int $apiKey): array {
        $params = [
            ':api_key' => $apiKey,
            ':query' => "%{$query}%",
        ];

        $query = (
            "SELECT
                event_account.id                        AS id,
                'Name'                                  AS \"groupName\",
                'id'                                    AS \"entityId\",
                CONCAT_WS(' ', event_account.firstname,
                               event_account.lastname)  AS value

            FROM
                event_account

            WHERE
                (
                    LOWER(REPLACE(event_account.firstname || event_account.lastname, ' ', ''))
                                                    LIKE LOWER(REPLACE(:query, ' ', '')) OR
                    LOWER(REPLACE(event_account.lastname || event_account.firstname, ' ', ''))
                                                    LIKE LOWER(REPLACE(:query, ' ', ''))
                ) AND
                event_account.key = :api_key

            LIMIT 25 OFFSET 0"
        );

        return $this->execQuery($query, $params);
    }
}
