<?php

class GenerateFiles {
    public static string $orders_csv_name = 'orders.csv';
    public static string $products_csv_name = 'products.csv';
    private array $products_id = [];

    public function __construct() {
        $this->generateProductsCsv();
        $this->generateOrdersCsv();
    }

    private function generateProductsCsv() {
        $file     = fopen(self::$products_csv_name, 'w');
        fputcsv($file, ['product_id', 'name', 'price']);

        $count = 20;

        for ($i=0; $i < $count; $i++) { 
            $id =  sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
                mt_rand( 0, 0xffff ),
                mt_rand( 0, 0x0fff ) | 0x4000,
                mt_rand( 0, 0x3fff ) | 0x8000,
                mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
            );

            $this->products_id[] = $id;
            $value = rand(1, 2000) / 100;  
            $price = number_format($value, 2);

            fputcsv($file, [$id, 'Product ' . $i, $price]);
        }

        fclose($file);
    }

    private function generateOrdersCsv() {
        $file = fopen(self::$orders_csv_name, 'w');
        fputcsv($file, ['order_id', 'product_id', 'date', 'quantity']);

        $last_id = '';
        $last_date = '';

        $count = 35;

        for ($i=0; $i < $count; $i++) { 
            $same = rand(0, 1);

            if ($same) {
                $id   = $last_id;
                $date = $last_date;
            } else {
                $randomYear = rand(2016, 2022);
                $randomMonth = rand(1, 12);
                $randomDay  = rand(1, 30);
                $randomHour = rand(0, 23);
                $randomMinute = rand(0, 59);

                if ($randomMonth == 2 && $randomDay > 28) {
                    $randomDay = 28;
                }

                $id =  sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                    mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
                    mt_rand( 0, 0xffff ),
                    mt_rand( 0, 0x0fff ) | 0x4000,
                    mt_rand( 0, 0x3fff ) | 0x8000,
                    mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
                );

                $last_id = $id;

                $date = (new DateTime("$randomYear-$randomMonth-$randomDay $randomHour:$randomMinute"))->format('Y-m-d H:i');
                $last_date = $date;
            }

            $product_id = $this->products_id[array_rand($this->products_id)];
            $quantity = rand(1, 50);

            if (!empty($id) && !empty($product_id) && !empty($date) && !empty($quantity)) {
                fputcsv($file, [$id, $product_id, $date, $quantity]);
            } else {
                $count++;
            }
        }

        fclose($file);
    }
}

new GenerateFiles;