<?php

namespace App\Http\Controllers;

use App\Settings\PrestashopSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PrestashopController extends Controller
{
    public static function customers()
    {
        try {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => str_replace('://', '://' . app(PrestashopSettings::class)->key . '@', app(PrestashopSettings::class)->url) . '/api/customers?output_format=JSON&display=full',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);

            if ($response === false) {
                throw new \Exception('cURL error: ' . curl_error($curl));
            }

            $response = json_decode($response);
            curl_close($curl);

            return $response->customers ?? [];
        } catch (\Exception $e) {
            Log::error('Error fetching customers: ' . $e->getMessage());
            return [];
        }
    }

    public static function contacts()
    {
        try {
            $customers = PrestashopController::customers();
            $emails = [];

            foreach ($customers as $customer) {
                if ($customer->newsletter == 1 || $customer->newsletter == "1") {
                    $emails[] = $customer->email;
                }
            }

            return $emails;
        } catch (\Exception $e) {
            Log::error('Error fetching contacts: ' . $e->getMessage());
            return [];
        }
    }

    public static function customerIDByEmail(string $email)
    {
        $customers = PrestashopController::customers();

        foreach ($customers as $customer) {
            if ($customer->email == $email) {
                return $customer->id;
            }
        }

        return abort(404);
    }

    public static function customerByID(int $id)
    {
        try {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => str_replace('://', '://' . app(PrestashopSettings::class)->key . '@', app(PrestashopSettings::class)->url) . '/api/customers/' . $id . '?output_format=JSON',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);

            if ($response === false) {
                throw new \Exception('cURL error: ' . curl_error($curl));
            }

            $response = json_decode($response);
            curl_close($curl);

            return $response->customer ?? [];
        } catch (\Exception $e) {
            Log::error('Error fetching customer by ID: ' . $e->getMessage());
            return [];
        }
    }

    public static function customerByIDInXML(int $id)
    {
        try {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => str_replace('://', '://' . app(PrestashopSettings::class)->key . '@', app(PrestashopSettings::class)->url) . '/api/customers/' . $id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);

            if ($response === false) {
                throw new \Exception('cURL error: ' . curl_error($curl));
            }

            curl_close($curl);

            return $response;
        } catch (\Exception $e) {
            Log::error('Error fetching customer by ID in XML: ' . $e->getMessage());
            return [];
        }
    }

    public static function subscribe(int $id, $customer)
    {
        try {
            $dom = new \DOMDocument();
            $dom->loadXML($customer);

            // Find and modify the <newsletter> element
            $xpath = new \DOMXPath($dom);
            $newsletterNodes = $xpath->query('//newsletter');

            if ($newsletterNodes->length > 0) {
                $newsletterNode = $newsletterNodes->item(0);
                $newsletterNode->nodeValue = '1';
            } else {
                throw new \Exception("Newsletter element not found");
            }

            // Convert the updated DOM back to an XML string
            $updatedXml = $dom->saveXML();

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => str_replace('://', '://' . app(PrestashopSettings::class)->key . '@', app(PrestashopSettings::class)->url) . '/api/customers/' . $id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'PUT',
                CURLOPT_POSTFIELDS => $updatedXml
            ));

            $response = curl_exec($curl);

            if ($response === false) {
                throw new \Exception('cURL error: ' . curl_error($curl));
            }

            curl_close($curl);

            return $response;
        } catch (\Exception $e) {
            Log::error('Error subscribing customer: ' . $e->getMessage());
            return [];
        }
    }

    public static function unsubscribe(int $id, $customer)
    {
        try {
            $dom = new \DOMDocument();
            $dom->loadXML($customer);

            // Find and modify the <newsletter> element
            $xpath = new \DOMXPath($dom);
            $newsletterNodes = $xpath->query('//newsletter');

            if ($newsletterNodes->length > 0) {
                $newsletterNode = $newsletterNodes->item(0);
                $newsletterNode->nodeValue = '0';
            } else {
                throw new \Exception("Newsletter element not found");
            }

            // Convert the updated DOM back to an XML string
            $updatedXml = $dom->saveXML();

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => str_replace('://', '://' . app(PrestashopSettings::class)->key . '@', app(PrestashopSettings::class)->url) . '/api/customers/' . $id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'PUT',
                CURLOPT_POSTFIELDS => $updatedXml
            ));

            $response = curl_exec($curl);

            if ($response === false) {
                throw new \Exception('cURL error: ' . curl_error($curl));
            }

            curl_close($curl);

            return $response;
        } catch (\Exception $e) {
            Log::error('Error unsubscribing customer: ' . $e->getMessage());
            return [];
        }
    }
}
