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

class Message extends \Tirreno\Models\BaseSql {
    protected $DB_TABLE_NAME = 'dshb_message';

    public function addMessage(string $msg): int {
        $this->text = $msg;

        $this->save();

        return \Tirreno\Utils\Conversion::intVal($this->id, 0);
    }

    public function getMessage(): self|null|false {
        $filters = [];
        $options = [
            'order' => 'id DESC',
            'offset' => 0,
            'limit' => 1,
        ];

        return $this->load($filters, $options);
    }
}
