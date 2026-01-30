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

namespace Sensor\Entity;

class EventEntity {
    /**
     * @param array<mixed, mixed>|null $payload
     */
    public function __construct(
        public int $accountId,
        public SessionEntity $session,
        public int $apiKeyId,
        public IpAddressEntity|IpAddressEnrichedEntity|IpAddressLocalhostEnrichedEntity $ipAddress,
        public UrlEntity $url,
        public ?string $eventType,
        public ?string $httpMethod,
        public DeviceEntity $device,
        public ?RefererEntity $referer,
        public EmailEntity|EmailEnrichedEntity|null $email,
        public PhoneEntity|PhoneEnrichedEntity|PhoneInvalidEntity|null $phone,
        public ?int $httpCode,
        public \DateTimeImmutable $eventTime,
        public ?string $traceId,
        public ?PayloadEntity $payload,
        public ?FieldHistoryEntity $fieldHistory,
        public CountryEntity $country,
    ) {
    }
}
