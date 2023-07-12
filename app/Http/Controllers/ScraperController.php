<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;

class ScraperController extends Controller
{
    protected $results = array();
    public function scraper()
    {

        $client = new Client();
        $url = 'https://www.trendyol.com/mango/ince-triko-hirka-p-524671073?boutiqueId=621430&merchantId=104723&filterOverPriceListings=false&sav=true';
        $page =  $client->request('GET', $url);
        print_r($page);

        // echo "<pre>";
        print_r($page->filter('h1')->text());
        echo '<br>';
        print_r($page->filter('.product-price-container')->text());
        echo '<br>';
        print_r($page->filter('div > img')->attr('src'));
        echo '<br>';
        $sizes = $page->filter('.sp-itm');

        if ($sizes->count() > 0) {
            $sizes->each(function ($size) {
                echo $size->text() . "\n";
            });
        } else {
            echo "No sizes found.";
        }
        echo '<br>';

        $categories = $page->filter('.product-detail-breadcrumb-item');

        if ($categories->count() > 0) {
            $categories->each(function ($category) {
                echo $category->text() . "\n";
            });
        } else {
            echo "No category found.";
        }
         echo '<br>';

        $multipleImages = $page->filter('img');
        // dd($multipleImages);
        print_r($multipleImages);

        if ($multipleImages->count() > 0) {
            $multipleImages->each(function ($images) {
                echo ($images->attr('src'))  . "<br>";
            });
        } else {
            echo "No images found.";
        }

        $jsonScript = $page->filter('script[type="application/ld+json"]')->eq(0)->text();
        echo '<pre>';
        print_r($jsonScript);
        echo '</pre>';

// Parse the JSON data into a PHP object
$data = json_decode($jsonScript);

// Access the "color" field from the parsed data
$color = html_entity_decode($data->color);

// Output the scraped color
echo $color;



        // $multipleImages = $page->filterXPath('//img[@loading="lazy"]');

        // if ($multipleImages->count() > 0) {
        //     $multipleImages->each(function ($image) {
        //         $src = $image->attr('src');
        //         echo $src . '<br>';
        //     });
        // } else {
        //     echo "No images found.";
        // }


        // if ($anchors->count() > 0) {
        //     $anchors->each(function ($anchor) {
        //         $imageSrc = $anchor->find('img')->attr('src');
        //         echo $imageSrc . "\n";
        //     });
        // } else {
        //     echo "No anchors found.";
        // }



    }
}
