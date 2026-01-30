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

namespace Tirreno\Controllers\Admin\Home;

class Navigation extends \Tirreno\Controllers\Admin\Base\Navigation {
    public function __construct() {
        parent::__construct();

        $this->controller = new Data();
        $this->page = new Page();
    }

    public function showIndexPage(): void {
        \Tirreno\Utils\Routes::redirectIfUnlogged('/login');

        parent::showIndexPage();
    }

    public function getDashboardStat(): array {
        $mode = \Tirreno\Utils\Conversion::getStringRequestParam('mode');
        $dateRange = \Tirreno\Utils\DateRange::getDatesRangeFromRequest();

        return $this->apiKey ? $this->controller->getStat($mode, $dateRange, $this->apiKey) : [];
    }

    public function getTopTen(): array {
        $mode = \Tirreno\Utils\Conversion::getStringRequestParam('mode');
        $dateRange = \Tirreno\Utils\DateRange::getDatesRangeFromRequest();

        return $this->apiKey ? $this->controller->getTopTen($mode, $dateRange, $this->apiKey) : [];
    }

    public function getChart(): array {
        $mode = \Tirreno\Utils\Conversion::getStringRequestParam('mode');

        return $this->apiKey ? $this->controller->getChart($mode, $this->apiKey) : [];
    }

    public function getCurrentTime(): array {
        return $this->operator ? $this->controller->getCurrentTime($this->operator) : [];
    }
}
