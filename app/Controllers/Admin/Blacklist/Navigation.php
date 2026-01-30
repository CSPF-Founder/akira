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

namespace Tirreno\Controllers\Admin\Blacklist;

class Navigation extends \Tirreno\Controllers\Admin\Base\Navigation {
    public function __construct() {
        parent::__construct();

        $this->controller = new Data();
        $this->page = new Page();
    }

    public function getList(): array {
        return $this->apiKey ? $this->controller->getList($this->apiKey) : [];
    }

    public function setBlacklistUsersCount(bool $cache = false): array {
        return $this->apiKey ? $this->controller->setBlacklistUsersCount($cache, $this->apiKey) : [];
    }

    public function removeItemFromList(): array {
        if (!$this->apiKey || !$this->id) {
            return [];
        }

        $type   = \Tirreno\Utils\Conversion::getStringRequestParam('type');
        $this->controller->removeItemFromBlacklist($this->id, $type, $this->apiKey);
        $successCode = \Tirreno\Utils\ErrorCodes::ITEM_REMOVED_FROM_BLACKLIST;

        return [
            'success'   => $successCode,
            'id'        => $this->id,
        ];
    }
}
