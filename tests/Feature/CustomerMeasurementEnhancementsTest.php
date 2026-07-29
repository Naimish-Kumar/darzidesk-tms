<?php

namespace Tests\Feature;

use App\Helper\WhatsAppService;
use App\Models\Customer;
use App\Models\Measurement;
use App\Models\MeasurementHistory;
use App\Models\Order;
use Tests\TestCase;

class CustomerMeasurementEnhancementsTest extends TestCase
{
    public function test_customer_model_supports_fitting_profile_attributes()
    {
        $customer = new Customer([
            'user_id' => 1,
            'city' => 'New York',
            'body_shape' => 'Sloping Shoulders',
            'posture_notes' => 'Left shoulder lower by 0.5 inches',
        ]);

        $this->assertEquals('Sloping Shoulders', $customer->body_shape);
        $this->assertEquals('Left shoulder lower by 0.5 inches', $customer->posture_notes);
    }

    public function test_whatsapp_service_generates_valid_urls_and_messages()
    {
        $order = new Order([
            'order_id' => 101,
            'tracking_token' => 'abc123xyz789',
        ]);

        $msg = WhatsAppService::getTrialReminderMessage($order);
        $this->assertStringContainsString('#101', $msg);

        $url = WhatsAppService::generateClickToChatUrl('+15551234567', $msg);
        $this->assertStringContainsString('wa.me/15551234567', $url);
    }

    public function test_measurement_history_model()
    {
        $history = new MeasurementHistory([
            'measurement_id' => 1,
            'customer_id' => 2,
            'change_notes' => 'Updated chest measurement from 40 to 42',
        ]);

        $this->assertEquals(1, $history->measurement_id);
        $this->assertEquals('Updated chest measurement from 40 to 42', $history->change_notes);
    }
}
