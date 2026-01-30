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

namespace Tirreno\Models\Grid\Domains;

class Ids extends \Tirreno\Models\Grid\Base\Ids {
    public function getDomainsIdsBySameIpDomainId(): string {
        return (
            'SELECT DISTINCT
                event_domain.id AS itemid
            FROM event_domain
            WHERE
                event_domain.ip = (
                    SELECT
                        ip
                    FROM event_domain
                    WHERE
                        event_domain.id = :domain_id AND
                        event_domain.key = :api_key
                    LIMIT 1
                ) AND
                event_domain.key = :api_key AND
                event_domain.id != :domain_id'
        );
    }
}
