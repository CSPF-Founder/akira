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

namespace Tirreno\Models\Grid\Phones;

class Ids extends \Tirreno\Models\Grid\Base\Ids {
    public function getPhonesIdsByUserId(): string {
        return (
            'SELECT DISTINCT
                event_phone.id AS itemid
            FROM event_phone
            WHERE
                event_phone.key = :api_key AND
                event_phone.account_id = :account_id'
        );
    }
}
