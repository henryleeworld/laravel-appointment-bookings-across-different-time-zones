<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class TimeConversionTest extends TestCase
{
    public function test_correctly_transforms_utc_to_any_date(): void
    {
        $this->assertEquals('01/01/2025', toUserDate('2025-01-01'));
        $this->assertEquals('12/31/2024', toUserDate('2025-01-01', timezone: 'America/New_York'));
        $this->assertEquals('01/01/2025', toUserDate('2025-01-01', timezone: 'Europe/London'));

        // DST tests
        $this->assertEquals('07/01/2023', toUserDate('2023-07-01'));
        $this->assertEquals('06/30/2023', toUserDate('2023-07-01', timezone: 'America/New_York'));
        $this->assertEquals('07/01/2023', toUserDate('2023-07-01', timezone: 'Europe/London'));

        // This can be expanded to include more tests and edge-cases that we encounter
    }

    public function test_correctly_transforms_utc_to_any_time(): void
    {
        $this->assertEquals('12:00 AM', toUserTime('00:00:00'));
        $this->assertEquals('7:00 PM', toUserTime('00:00:00', timezone: 'America/New_York'));
        $this->assertEquals('12:00 AM', toUserTime('00:00:00', timezone: 'Europe/London'));

        // This can be expanded to include more tests and edge-cases that we encounter
    }

    public function test_correctly_transforms_utc_to_any_date_time(): void
    {
        $this->assertEquals('01/01/2025 12:00 AM', toUserDateTime('2025-01-01 00:00:00'));
        $this->assertEquals('12/31/2024 7:00 PM', toUserDateTime('2025-01-01 00:00:00', timezone: 'America/New_York'));
        $this->assertEquals('01/01/2025 12:00 AM', toUserDateTime('2025-01-01 00:00:00', timezone: 'Europe/London'));

        // DST tests
        $this->assertEquals('07/01/2023 12:00 AM', toUserDateTime('2023-07-01 00:00:00'));
        $this->assertEquals('06/30/2023 8:00 PM', toUserDateTime('2023-07-01 00:00:00', timezone: 'America/New_York'));
        $this->assertEquals('07/01/2023 1:00 AM', toUserDateTime('2023-07-01 00:00:00', timezone: 'Europe/London'));

        // This can be expanded to include more tests and edge-cases that we encounter
    }

    public function test_correctly_transforms_user_date_to_utc(): void
    {
        $this->assertEquals('2025-01-01', fromUserDate('01/01/2025', timezone: 'UTC'));
        $this->assertEquals('2024-12-31', fromUserDate('12/31/2024', timezone: 'America/New_York'));
        $this->assertEquals('2025-01-01', fromUserDate('01/01/2025', timezone: 'Europe/London'));

        // DST tests
        $this->assertEquals('2023-07-01', fromUserDate('07/01/2023', timezone: 'UTC'));
        $this->assertEquals('2023-06-30', fromUserDate('06/30/2023', timezone: 'America/New_York'));
        $this->assertEquals('2023-06-30', fromUserDate('07/01/2023', timezone: 'Europe/London'));

        // This can be expanded to include more tests and edge-cases that we encounter
    }

    public function test_correctly_transforms_users_time_to_utc(): void
    {
        $this->assertEquals('00:00:00', fromUserTime('12:00 AM', timezone: 'UTC'));
        $this->assertEquals('00:00:00', fromUserTime('7:00 PM', timezone: 'America/New_York'));
        $this->assertEquals('00:00:00', fromUserTime('12:00 AM', timezone: 'Europe/London'));

        // This can be expanded to include more tests and edge-cases that we encounter
    }

    public function test_correctly_transforms_user_date_time_to_utc(): void
    {
        $this->assertEquals('2025-01-01 00:00:00', fromUserDateTime('01/01/2025 12:00 AM', timezone: 'UTC'));
        $this->assertEquals('2025-01-01 00:00:00', fromUserDateTime('12/31/2024 7:00 PM', timezone: 'America/New_York'));
        $this->assertEquals('2025-01-01 01:00:00', fromUserDateTime('01/01/2025 1:00 AM', timezone: 'Europe/London'));

        // DST tests
        $this->assertEquals('2023-07-01 00:00:00', fromUserDateTime('07/01/2023 12:00 AM', timezone: 'UTC'));
        $this->assertEquals('2023-07-01 00:00:00', fromUserDateTime('06/30/2023 8:00 PM', timezone: 'America/New_York'));
        $this->assertEquals('2023-07-01 00:00:00', fromUserDateTime('07/01/2023 1:00 AM', timezone: 'Europe/London'));

        // This can be expanded to include more tests and edge-cases that we encounter
    }

    public function test_correctly_transforms_user_date_time_from_settings_to_utc(): void
    {
        $this->assertEquals('2025-01-01 00:00:00', fromUserDateTime('01/01/2025 12:00 AM', timezone: 'UTC'));

        date_default_timezone_set('America/New_York');
        $this->assertEquals('2025-01-01 00:00:00', fromUserDateTime('12/31/2024 7:00 PM', timezone: 'America/New_York'));

        date_default_timezone_set('Europe/London');
        $this->assertEquals('2025-01-01 01:00:00', fromUserDateTime('01/01/2025 1:00 AM', timezone: 'Europe/London'));

        // DST tests
        date_default_timezone_set('UTC');
        $this->assertEquals('2023-07-01 00:00:00', fromUserDateTime('07/01/2023 12:00 AM', timezone: 'UTC'));

        date_default_timezone_set('America/New_York');
        $this->assertEquals('2023-07-01 00:00:00', fromUserDateTime('06/30/2023 8:00 PM', timezone: 'America/New_York'));

        date_default_timezone_set('Europe/London');
        $this->assertEquals('2023-07-01 00:00:00', fromUserDateTime('07/01/2023 1:00 AM', timezone: 'Europe/London'));

        // This can be expanded to include more tests and edge-cases that we encounter
    }
}
